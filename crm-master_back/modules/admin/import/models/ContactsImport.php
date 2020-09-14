<?php
/**
 * Created by PhpStorm.
 * User: Slavi
 * Date: 2/27/2018
 * Time: 1:39 PM
 */

namespace app\modules\admin\import\models;

use app\models\Company;
use Yii;
use yii\helpers\ArrayHelper;

class ContactsImport
{

    /**
     * @return array
     */
    public static function getArrayKeys()
    {
        $keys = require 'keys_contact.php';
        $a = 2;
        $newArray = [];
        for ($i = 0; $i <= count($keys); $i++) {
            $newArray[$a] = $keys[$i];
            $a++;
        }
        return $newArray;
    }

    /**
     * @param $username
     * @param $password
     * @param $clientId
     * @return mixed
     * @throws \Exception
     * @throws \yii\base\Exception
     */
    public function getContacts($username, $password, $clientId)
    {
        $curl = new Curl([], $username, $password, $clientId, Curl::CONTACTS);
        $data = $curl->loginAndDownload();
        return $data['aaData'];
    }

    /**
     * @param $data
     * @return bool | array
     */
    public function associateContactsArray($data)
    {
        $keys = self::getArrayKeys();
        $contacts = false;
        foreach ($data as $key => $datum) {
            ArrayHelper::remove($data[$key], 'DT_RowClass');
            ArrayHelper::remove($data[$key], 'DT_RowId');
            ArrayHelper::remove($data[$key], '0');
            ArrayHelper::remove($data[$key], '1');
        }

        foreach ($data as $key => $datum) {
            $contacts[$key]['ref'] = str_replace("'", '', $datum[2]);
            $contacts[$key]['gender'] = str_replace("'", '', $datum[3]);
            $contacts[$key]['parsed_full_name'] = (str_replace("'", '', strip_tags($datum[4]))) . ' ' . (str_replace("'", '', strip_tags($datum[5])));
            $contacts[$key]['parsed_full_name_reverse'] = (str_replace("'", '', strip_tags($datum[5]))) . ' ' . (str_replace("'", '', strip_tags($datum[4])));
            $contacts[$key]['first_name'] = str_replace("'", '', strip_tags($datum[4]));
            $contacts[$key]['last_name'] = str_replace("'", '', strip_tags($datum[5]));
            $contacts[$key]['home_address_1'] = str_replace("'", '', strip_tags($datum[6]));
            $contacts[$key]['home_address_2'] = str_replace("'", '', strip_tags($datum[7]));
            $contacts[$key]['home_city'] = str_replace("'", '', strip_tags($datum[8]));
            $contacts[$key]['home_state'] = str_replace("'", '', strip_tags($datum[9]));
            $contacts[$key]['home_country'] = str_replace("'", '', strip_tags($datum[10]));
            $contacts[$key]['home_zip_code'] = str_replace("'", '', strip_tags($datum[11]));
            $contacts[$key]['personal_phone'] = str_replace("'", '', strip_tags($datum[12]));
            $contacts[$key]['work_phone'] = str_replace("'", '', strip_tags($datum[13]));
            $contacts[$key]['home_fax'] = str_replace("'", '', strip_tags($datum[14]));
            $contacts[$key]['home_po_box'] = str_replace("'", '', strip_tags($datum[15]));
            $contacts[$key]['personal_mobile'] = str_replace("'", '', strip_tags($datum[17]));
            $contacts[$key]['personal_email'] = str_replace("'", '', strip_tags($datum[18]));
            $contacts[$key]['date_of_birth'] = str_replace("'", '', strip_tags($datum[20]));
            $contacts[$key]['designation'] = str_replace("'", '', strip_tags($datum[21]));
            $contacts[$key]['nationality'] = str_replace("'", '', strip_tags($datum[22]));
            $contacts[$key]['religion'] = str_replace("'", '', strip_tags($datum[23]));
            $contacts[$key]['title'] = str_replace("'", '', strip_tags($datum[24]));
            $contacts[$key]['assigned_to'] = str_replace("'", '', strip_tags($datum[26]));
            $contacts[$key]['updated'] = str_replace("'", '', strip_tags($datum[27]));
            $contacts[$key]['other_phone'] = str_replace("'", '', strip_tags($datum[28]));
            $contacts[$key]['created_by'] = \Yii::$app->user->id;
        }
        return $contacts;
    }


    public function saveContacts($data)
    {
        $contacts = $this->associateContactsArray($data);
        $company_id = Company::getCompanyIdBySubdomain();
        $company_id = ($company_id == 'main') ? 0 : $company_id;
        $insert = "INSERT INTO contacts (`" . implode("`, `", array_keys(array_shift($contacts))) . "`, `company_id`) VALUES ";

        foreach ($contacts as $contact) {
//            $trash = array_pop($contact);
//            unset($trash);
            $insert .= "('" . implode("', '", $contact) . "', '$company_id'),";
        }
        $insert = str_replace(', ``', '' , $insert);
        $insert = rtrim($insert, ",'");
        $query = Yii::$app->db->createCommand($insert);
        if ($query->execute()) {
            return true;
        }
        return null;
    }
}