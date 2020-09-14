<?php

namespace app\modules\admin\import\controllers;


use app\models\Company;
use app\models\Contacts;
use app\models\PortalListing;
use app\models\ref\Ref;
use app\models\reference_books\Portals;
use app\models\Rentals;
use app\models\Sale;
use app\modules\admin\import\models\ContactsImport;
use app\modules\admin\import\models\LeadsImport;
use app\modules\admin\import\models\ImportTemp;
use Yii;
use app\modules\admin\import\models\InitImport;
use yii\web\Controller;
use yii\helpers\{ArrayHelper, Json, Url, FileHelper};

/**
 * Default controller for the `PropspaceImport` module
 */
class IndexController extends Controller
{
    public $link;

    public static $progress;

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionStep1()
    {
        $model = new InitImport();
        $post = Yii::$app->request->post('InitImport');
        $this->link = $post['xmlLink'];
        if ($model->load(Yii::$app->request->post()) && $model->saveXmlLink($this->link)) {
            return $this->redirect(['step2', 'link' => $this->link]);
        }
        return $this->render('step1-enter-xml-link', ['model' => $model]);
    }

    public function actionStep2($link)
    {
        $model = new InitImport();
        $model = $model->findModelByLink($link, false);
        if ($model->load(Yii::$app->request->post()) && $model->save($link)) {
            return 'Saved!';
        }
        return $this->render('step2-enter-credentials', ['model' => $model]);
    }

    protected function updateOwners($model)
    {
        $limit = 500;
        $totalCount = $model::find()->where('is_parsed', 1)->count();
        $iterNumb  = ceil($totalCount / $limit);
        $modelTableName = $model::tableName();
        $companyId = Company::getCompanyIdBySubdomain();
        $companyId = ($companyId == 'main') ? 0 : $companyId;
        $queryUpdateSale = "";

        for($i = 0; $i < $iterNumb; $i++) {
            $items = $model::find()->where('is_parsed', 1)->limit($limit)->offset($i * $limit)->all();

            foreach($items as $s) {
                if (strlen($s->landlord_id) >= 2 && strpos($s->landlord_id, "- -") === false) {
                    $contact = Contacts::find()->andWhere(['or',
                        ['=', 'parsed_full_name', $s->landlord_id],
                        ['=', 'parsed_full_name_reverse', $s->landlord_id],
                    ])->one();

                    if ($contact) {
                        $queryUpdateSale .= "Update " . $modelTableName . " set landlord_id='$contact->id' where landlord_id='$s->landlord_id';";
                    } else {
                        $words = explode(" ", $s->landlord_id);

                        if (count($words) > 0) {
                            if (count($words) == 1) {
                                $firstName = $words[0];
                                $lastName = "";
                            } else if (count($words) == 2) {
                                $firstName = $words[0];
                                $lastName = $words[1];
                            } else if (count($words) > 2) {
                                $firstName = $words[0];
                                $lastName = "";
                                $countWords = count($words);

                                for($iW = 1; $iW < $countWords; $iW++) {
                                    $lastName .= $words[$iW];
                                    $lastName .= ($iW != $countWords - 1) ? " " : "";
                                }
                            }

                            $contact = new Contacts();
                            $contact->first_name = $firstName;
                            $contact->last_name = $lastName;
                            $contact->parsed_full_name = $s->landlord_id;
                            $contact->personal_email = $s->owner_email;
                            $contact->personal_mobile = $s->owner_mobile;
                            $contact->created_by = Yii::$app->user->id;
                            $contact->company_id = $companyId;

                            if ($contact->save(false)) {
                                $contact->ref = (new Ref())->getRefCompany($contact);
                                $contact->save(false);

                                $queryUpdateSale .= "Update " . $modelTableName . " set landlord_id='$contact->id' where landlord_id='$s->landlord_id';";
                            }
                        }
                    }
                }
            }
        }

        if ($queryUpdateSale) {
            Yii::$app->db->createCommand($queryUpdateSale)->execute();
        }
    }

    public function actionUpdateOwnersSales()
    {
        $this->updateOwners(new Sale());

        return 'Owner for sales updates!';
    }

    public function actionUpdateOwnersRentals()
    {
        $this->updateOwners(new Rentals());

        return 'Owner for rentals updates!';
    }

    /**
     * Replace string data in table contacts with id
     * @return string
     */
    public function actionReplaceContactsStringOnId()
    {
        $company_id = Company::getCompanyIdBySubdomain();
        $company_id = ($company_id == 'main') ? 0 : $company_id;

        $query = "update `contacts`
         set `contacts`.assigned_to = (select `user`.id from `user` where concat(`user`.first_name, ' ', `user`.last_name) = `contacts`.assigned_to and `user`.company_id = '$company_id')
         where `contacts`.company_id = '$company_id'";

        $db = Yii::$app->db->createCommand($query);
        if ($db->execute()) {
            return 'Contacts assigned_to updated!';
        } else {
            return 'Some error';
        }
    }

    /**
     * Replace string data in tables sale, rental with id
     * @return bool
     */
    public function actionReplaceSaleRentalStringOnId()
    {
        $company_id = Company::getCompanyIdBySubdomain();
        $company_id = ($company_id == 'main') ? 0 : $company_id;

        $query = "update `sale`
        set
        `sale`.agent_id = (select `user`.id from `user` where concat(`user`.first_name, ' ', `user`.last_name) = `sale`.agent_id and `user`.company_id = '$company_id'),
        `sale`.user_id  = (select `user`.id from `user` where concat(`user`.first_name, ' ', `user`.last_name) = `sale`.user_id and `user`.company_id = '$company_id')
        where `sale`.company_id = '$company_id';

        update `rentals`
        set
        `rentals`.agent_id = (select `user`.id from `user` where concat(`user`.first_name, ' ', `user`.last_name) = `rentals`.agent_id and `user`.company_id = '$company_id'),
        `rentals`.user_id  = (select `user`.id from `user` where concat(`user`.first_name, ' ', `user`.last_name) = `rentals`.user_id and `user`.company_id = '$company_id')
        where `rentals`.company_id = '$company_id';";

        $db = Yii::$app->db->createCommand($query);
        if ($db->execute()) {
            echo 'Sale, Rental(agent_id, user_id) updated';
        } else {
            return 'Some error';
        }

        return true;
    }

    public function actionReplaceLeadAgent()
    {
        $company_id = Company::getCompanyIdBySubdomain();
        $company_id = ($company_id == 'main') ? 0 : $company_id;

        $query = "update `leads`
        set
        `leads`.agent_1 = (select `user`.id from `user` where concat(`user`.first_name, ' ', `user`.last_name) = `leads`.agent_1 and `user`.company_id = '$company_id'),
        `leads`.agent_2 = (select `user`.id from `user` where concat(`user`.first_name, ' ', `user`.last_name) = `leads`.agent_2 and `user`.company_id = '$company_id'),
        `leads`.agent_3 = (select `user`.id from `user` where concat(`user`.first_name, ' ', `user`.last_name) = `leads`.agent_3 and `user`.company_id = '$company_id'),
        `leads`.agent_4 = (select `user`.id from `user` where concat(`user`.first_name, ' ', `user`.last_name) = `leads`.agent_4 and `user`.company_id = '$company_id'),
        `leads`.agent_5 = (select `user`.id from `user` where concat(`user`.first_name, ' ', `user`.last_name) = `leads`.agent_5 and `user`.company_id = '$company_id')
        where `leads`.company_id = '$company_id';

        insert into `lead_agent` (`lead_id`, `user_id`) select `id`, `agent_1` from `leads` where `leads`.company_id = '$company_id' and `leads`.agent_1 > 0;
        insert into `lead_agent` (`lead_id`, `user_id`) select `id`, `agent_2` from `leads` where `leads`.company_id = '$company_id' and `leads`.agent_2 > 0;
        insert into `lead_agent` (`lead_id`, `user_id`) select `id`, `agent_3` from `leads` where `leads`.company_id = '$company_id' and `leads`.agent_3 > 0;
        insert into `lead_agent` (`lead_id`, `user_id`) select `id`, `agent_4` from `leads` where `leads`.company_id = '$company_id' and `leads`.agent_4 > 0;
        insert into `lead_agent` (`lead_id`, `user_id`) select `id`, `agent_5` from `leads` where `leads`.company_id = '$company_id' and `leads`.agent_5 > 0;

        update `leads` set `leads`.agent_1 = '', `leads`.agent_2 = '', `leads`.agent_3 = '', `leads`.agent_4 = '', `leads`.agent_5 = '' where `leads`.company_id = '$company_id';";

        $db = Yii::$app->db->createCommand($query);

        if ($db->execute($query)) {
            echo 'Lead agent id saved!';
        } else {
            return 'Some error';
        }

        return true;
    }

    /**
     * set token for companies if it is empty
     */
    public function actionUpdateCompanyToken()
    {
        $companies = Company::find()->all();

        foreach ($companies as  $company) {
            if (empty($company->token)) {
                $company->token = Company::getToken($company->company_name);
                $company->save();
            }
        }

        return 'Saved!';
    }

    /**
     * Parse xml for property finder, save price
     */
    public function actionParseXmlPrice($link)
    {
        $xml = simplexml_load_file($link, 'SimpleXMLElement', LIBXML_NOCDATA);
        $tblSale   = Sale::tableName();
        $tblRental = Rentals::tableName();

        foreach($xml->Listing as $item) {
            switch($item->Ad_Type) {
                case "Sale":
                    $query .= "update `$tblSale` set `price` = '$item->Price' where `ref` = '$item->Property_Ref_No';";
                    break;
                case "Rent":
                    switch($item->Frequency) {
                        case "per month":
                            $query .= "update `$tblRental` set `price_per_month` = '$item->Price' where `ref` = '$item->Property_Ref_No';";
                            break;
                        case "per week":
                            $query .= "update `$tblRental` set `price_per_week` = '$item->Price' where `ref` = '$item->Property_Ref_No';";
                            break;
                        case "per day":
                            $query .= "update `$tblRental` set `price_per_day` = '$item->Price' where `ref` = '$item->Property_Ref_No';";
                            break;
                        case "per year":
                            $query .= "update `$tblRental` set `price` = '$item->Price' where `ref` = '$item->Property_Ref_No';";
                            break;
                    }
                    break;
            }
        }
        $db = Yii::$app->db->createCommand($query);
        $db->execute($query);

        return true;
    }

    /**
     * Update description, other info for sale, rental which in Xml for property finder
     * @param $link
     * @return string
     */
    public function actionParseXmlPropertyfinder($link)
    {
        $simpleXml          = simplexml_load_file($link, 'SimpleXMLElement', LIBXML_NOCDATA);
        $portalListingTable = PortalListing::tableName();
        $query              = "insert into `$portalListingTable` (`portal_id`, `ref`, `type`) values ";
        $saleTable          = Sale::tableName();
        $rentalTable        = Rentals::tableName();
        $portalProp         = Portals::PORTAL_PROPERTY_FINDER;
        $portalBayut        = Portals::PORTAL_BAYUT;
        $portalDubizzle     = Portals::PORTAL_DUBIZZLE;

        foreach($simpleXml->Listing as $item) {
            $description = addslashes($item->Web_Remarks);

            switch($item->Ad_Type) {
                case "Sale":
                    $sale = Sale::findOne(['ref' => $item->Property_Ref_No]);
                    if ($sale) {
                        $queryUpdate .= "update `$saleTable` set `description` = '$description' where ref = '$item->Property_Ref_No';";

                        $ref      = $sale->ref;
                        $type     = PortalListing::TYPE_SALE;
                        $query   .= "('$portalProp', '$ref', '$type'), ('$portalBayut', '$ref', '$type'), ('$portalDubizzle', '$ref', '$type'),";
                    }
                    break;
                case "Rent":
                    $rent = Rentals::findOne(['ref' => $item->Property_Ref_No]);
                    if ($rent) {
                        $queryUpdate .= "update `$rentalTable` set `description` = '$description' where ref = '$item->Property_Ref_No';";

                        $ref      = $rent->ref;
                        $type     = PortalListing::TYPE_RENTAL;
                        $query   .= "('$portalProp', '$ref', '$type'), ('$portalBayut', '$ref', '$type'), ('$portalDubizzle', '$ref', '$type'),";
                    }
                    break;
            }
        }

        Yii::$app->db->createCommand(rtrim($query, ','))->execute();
        Yii::$app->db->createCommand($queryUpdate)->execute();

        return "Saved!";
    }

    public function actionChangeDatesRentalsSales()
    {
        $limit = 500;
        $totalSales = Sale::find()->count();
        $totalRentals = Rentals::find()->count();
        $iterSales  = ceil($totalSales / $limit);
        $iterRentals  = ceil($totalRentals / $limit);

        for($i = 0; $i < $iterSales; $i++) {
            $query = Sale::find();
            $sales = $query->limit($limit)->offset($i * $limit)->all();

            foreach ($sales as $k => $sale) {
                $sale->dateadded   = date('Y-m-d H:i:s', strtotime($sale->dateadded));
                $sale->dateupdated = date('Y-m-d H:i:s', strtotime($sale->dateupdated));
                $sale->save();
            }
        }

        for($i = 0; $i < $iterRentals; $i++) {
            $query = Rentals::find();
            $rentals = $query->limit($limit)->offset($i * $limit)->all();

            foreach ($rentals as $k => $rent) {
                $rent->dateadded   = date('Y-m-d H:i:s', strtotime($rent->dateadded));
                $rent->dateupdated = date('Y-m-d H:i:s', strtotime($rent->dateupdated));
                $rent->save();
            }
        }

        return 'Changed';
    }

    public function actionGetRentalsSales($link)
    {
        $model = new InitImport();
        $model = $model->findModelByLink($link, false);

        if ($model->saveRentals()) {
            echo 'Rentals saved <br />';
            flush();
            ob_flush();
        } else {
            return null;
        }
        if ($model->saveSales()) {
            echo 'Sales saved <br />';
            flush();
            ob_flush();
        } else {
            return null;
        }

        return true;
    }

    public function actionGetContacts($link)
    {
        $model = new InitImport();
        $model = $model->findModelByLink($link, false);
        if ($model->saveContacts()) {
            echo 'Contacts saved!';
        }
        return null;
    }

    public function actionGetLeads($link)
    {
        $model = new InitImport();
        $model = $model->findModelByLink($link, false);
        if ($model->saveLeads()) {
            echo 'Leads saved!';
        }
        return null;
    }

    public function actionGetUsers($link)
    {
        $model = new InitImport();
        $model = $model->findModelByLink($link, false);
        if ($model->saveUsers()) {
            echo 'Users saved!';
        }
        return null;
    }

    public function actionDownloadImages($link)
    {
        $model = new InitImport();
        $model = $model->findModelByLink($link, false);
        $model->getImages();
     }

    public function actionService()
    {
        $model = new ImportTemp();
        $model->updateRentalsTable();
        $model->updateSalesTable();
    }
}


/*public function actionGetInfo($link)
   {
       $model = new InitImport();
       $model->findModelByLink($link, false);
             $leads = $model->getLeads();
               $leadsKeys = LeadsImport::getLeadsArrayKeys();
               $leadDb = Leads::getTableSchema()->columnNames;
               $contacts = $model->getContacts();
               $contactKeys = ContactsImport::getArrayKeys();
               $contactDb = Contacts::getTableSchema()->columnNames;

               echo 'LEADS: <br />количество полей в нашей БД: <strong>' . count($leadDb) . '</strong><br />';
               echo 'количество полей в моем массиве с названиями полей: <strong>' . count($leadsKeys) . '</strong><br />';
               echo 'количество полей у ПРОПСПЕЙСА: <strong>' . count(array_shift($leads)) . '</strong><br />';
               echo 'CONTACTS: <br />количество полей в нашей БД: <strong>' . count($contactDb) . '</strong><br />';
               echo 'количество полей в моем массиве с названиями полей: <strong>' . count($contactKeys) . '</strong><br />';
               echo 'количество полей у ПРОПСПЕЙСА: <strong>' . count(array_shift($contacts)) . '</strong><br />';

   }*/