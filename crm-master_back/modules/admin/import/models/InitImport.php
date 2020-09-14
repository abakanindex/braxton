<?php namespace app\modules\admin\import\models;

set_time_limit(0);

use app\interfaces\relationShip\iRelationShip;
use app\models\Contacts;
use app\models\Locations;
use app\models\Rentals;
use app\modules\admin\import\controllers\IndexController;
use Yii;
use app\models\Company;
use app\models\Sale;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\Cookie;

/**
 * Created by PhpStorm.
 * User: qp
 * Date: 15.01.2018
 * Time: 14:54
 */
class InitImport extends \yii\base\Model
{
    public $username;

    public $password;

    public $clientId;

    public $xmlLink;

    public $pathToJson;

    public $progress;

    public function rules()
    {
        return [
            ['xmlLink', 'url',],
            ['clientId', 'integer'],
            ['username', 'string'],
            [['xmlLink', 'clientId', 'username', 'password'], 'required'],
        ];
    }

    public function saveXmlLink($link)
    {
        if (!ImportTemp::find()->where(['xml_link' => $link])->all()) {
            $model = new ImportTemp();
            $model->xml_link = $link;
            $model->datetime = date('d-m-y h:m:s');
            $this->downloadXml($link);
            return $model->save() ? true : null;
        }
        $this->downloadXml($link);
        $date = date('d-m-y h:m:s');
        return Yii::$app->db->createCommand()->update(
            'import_temp', ['datetime' => $date], "xml_link = '$link'"
        )->execute() ? true : null;
    }

    public function downloadXml($link)
    {
        $path = DOCUMENT__ROOT . '/web/xml/';
        if (!file_exists($path)) {
            FileHelper::createDirectory($path);
        }
        $filename = explode('?', $link);
        $file = $path . $filename[1] . '.xml';
        if (file_exists($file)) {
            return $this->readXmlToArray($link);
        }
        return Curl::downloadXml($link, $file);
    }

    public function readXmlToArray($link)
    {
        $filename = explode('?', $link);
        $file = DOCUMENT__ROOT . '/web/xml/' . $filename[1] . '.xml';
        return json_decode(json_encode(simplexml_load_file($file)), true);
    }

    /**
     * @param $link
     * @var $model = ImportTemp;
     * @return mixed
     */
    public function save($link)
    {
        $model = $this->findModelByLink($link, true);
        $model->username = $this->username;
        $model->password = $this->password;
        $model->client_id = $this->clientId;
        $this->pathToJson = DOCUMENT__ROOT . '/web/propspaceData/' . $this->username . '_' . $this->clientId;
        return $model->save();
    }

    /**
     * @param $link
     * @param bool $fromDatabase
     * @return bool|null|static|ImportTemp
     */
    public function findModelByLink($link, $fromDatabase = true)
    {
        if ($fromDatabase == true) {
            $model = ImportTemp::findOne(['xml_link' => $link]);
            return $model ? $model : new ImportTemp();
        }

        $importTemp = ImportTemp::find()
            ->where(['xml_link' => $link])
            ->one();
        $this->username = $importTemp->username;
        $this->password = $importTemp->password;
        $this->clientId = $importTemp->client_id;
        $this->xmlLink = $importTemp->xml_link;
        $this->pathToJson = DOCUMENT__ROOT . '/web/propspaceData/' . $this->username . '_' . $this->clientId;
        return $this;
    }

    public function getRentals($new_download = false)
    {
        if ($new_download == false) {
            if ($data = $this->readRentals()) {
                return $data;
            }
            return $this->downloadRentals();
        } else {
            return $this->downloadRentals();
        }
    }

    public function readRentals()
    {
        if (file_exists($this->pathToJson . '/rentalsData.json')) {
            return json_decode(file_get_contents($this->pathToJson . '/rentalsData.json'), true);
        }
        return null;
    }

    public function downloadRentals()
    {
        $model = new Curl([], $this->username, $this->password, $this->clientId, Curl::RENTALS);
        if ($data = $model->loginAndDownload()) {
            if (!file_exists($this->pathToJson)) {
                FileHelper::createDirectory($this->pathToJson);
            }
            file_put_contents($this->pathToJson . '/rentalsData.json', json_encode($data));
            return $data;
        }
        return null;
    }

    public function getSales($new_download = false)
    {
        if ($new_download == false) {
            if ($data = $this->readSales()) {
                return $data;
            }
            return $this->downloadSales();
        } else {
            return $this->downloadSales();
        }
    }

    public function readSales()
    {
        if (file_exists($this->pathToJson . '/salesData.json')) {
            return json_decode(file_get_contents($this->pathToJson . '/salesData.json'), true);
        }
        return null;
    }

    public function downloadSales()
    {
        $model = new Curl([], $this->username, $this->password, $this->clientId, Curl::SALES);
        if ($data = $model->loginAndDownload()) {
            if (!file_exists($this->pathToJson)) {
                FileHelper::createDirectory($this->pathToJson);
            }
            file_put_contents($this->pathToJson . '/salesData.json', json_encode($data));
            return $data;
        }
        return null;
    }


    public function saveRentals()
    {
        if ($data = $this->getRentals(true)) {
            $locations = ArrayHelper::map(Locations::getAll(), 'name', 'id');
            $data = $data['aaData'];
            $company_id = Company::getCompanyIdBySubdomain();
            $company_id = ($company_id == 'main') ? 0 : $company_id;

            $dataKeys = array_keys(array_shift($data));
            $tableKeys = array_values(Rentals::getTableSchema()->getColumnNames());
            if (($keyFind = array_search('latitude', $tableKeys)) !== false) {
                unset($tableKeys[$keyFind]);
            }
            if (($keyFind = array_search('longitude', $tableKeys)) !== false) {
                unset($tableKeys[$keyFind]);
            }
            if (($keyFind = array_search('is_parsed', $tableKeys)) !== false) {
                unset($tableKeys[$keyFind]);
            }
            if (($keyFind = array_search('price_per_day', $tableKeys)) !== false) {
                unset($tableKeys[$keyFind]);
            }
            if (($keyFind = array_search('price_per_week', $tableKeys)) !== false) {
                unset($tableKeys[$keyFind]);
            }
            if (($keyFind = array_search('price_per_month', $tableKeys)) !== false) {
                unset($tableKeys[$keyFind]);
            }
            ArrayHelper::removeValue($tableKeys, 'id');
            $diffColumns = array_diff($dataKeys, $tableKeys);
            $columnsToAdd = array_diff($tableKeys, $dataKeys);
            sort($tableKeys);

            $insert = "INSERT INTO `rentals` ( `" . implode('`, `', $tableKeys) . "`, `is_parsed`) VALUES ";
            foreach ($data as $key => $datum) {
                foreach ($datum as $colname => $value) {
                    if ($colname == 'region_id') {
                        $datum[$colname] = $locations[str_replace("'", '', strip_tags($datum[$colname]))];
                    } else if ($colname == 'area_location_id') {
                        $datum[$colname] = $locations[str_replace("'", '', strip_tags($datum[$colname]))];
                    } else if ($colname == 'sub_area_location_id') {
                        $datum[$colname] = $locations[str_replace("'", '', strip_tags($datum[$colname]))];
                    } else if ($colname == 'category_id') {
                        $datum[$colname] = $this->getCategory(str_replace("'", '', strip_tags($datum[$colname])));
                    } else if ($colname == 'status') {
                        $newStatus = "";
                        $a = new \DOMDocument();
                        $a->loadHTML($datum['status']);
                        $items = $a->getElementsByTagName('img');
                        if ($items->length > 0) {
                            $importStatus = $items->item(0)->getAttribute('title');

                            switch($importStatus) {
                                case 'Published':
                                    $newStatus = iRelationShip::STATUS_PUBLISHED;
                                    break;
                                case 'Draft':
                                    $newStatus = iRelationShip::STATUS_DRAFT;
                                    break;
                                case 'Unpublished':
                                    $newStatus = iRelationShip::STATUS_UNPUBLISHED;
                                    break;
                                case 'Waiting Approval':
                                    $newStatus = iRelationShip::STATUS_PENDING;
                                    break;
                            }
                        }
                        $datum[$colname] = $newStatus;
                    } else if ($colname == 'price') {
                        $datum[$colname] = str_replace(",", "", $value);
                    } else if ($colname == 'dateadded' || $colname == 'dateupdated') {
                        $datum[$colname] = date('Y-m-d H:i:s', strtotime(str_replace("'", '', strip_tags($value))));
                    } else {
                        $datum[$colname] = str_replace("'", '', strip_tags($value));
                        if (in_array($colname, $diffColumns)) ArrayHelper::remove($datum, $colname);
                        if ($colname == 'id') ArrayHelper::remove($datum, 'id');
                        foreach ($columnsToAdd as $column) {
                            $datum[$column] = '';
                            if ($column == 'company_id') $datum[$column] = $company_id;
                        }
                        $datum['slug'] = strip_tags($data[$key]['ref']);
                    }
                }
                ksort($datum);
                $insert .= "
            ('" . implode("', '", $datum) . "', '1'),";
            }
            $insert = rtrim($insert, ',');
            //echo $insert;exit();

            $query = Yii::$app->db->createCommand($insert);
            if ($query->execute()) {
                return true;
            }
        }
        return null;
    }

    public function saveSales()
    {
        if ($data = $this->getSales(true)) {
            $locations = ArrayHelper::map(Locations::getAll(), 'name', 'id');
            $data = $data['aaData'];
            $company_id = Company::getCompanyIdBySubdomain();
            $company_id = ($company_id == 'main') ? 0 : $company_id;

            $dataKeys = array_keys(array_shift($data));
            $tableKeys = array_values(Sale::getTableSchema()->getColumnNames());
            if (($keyFind = array_search('latitude', $tableKeys)) !== false) {
                unset($tableKeys[$keyFind]);
            }
            if (($keyFind = array_search('longitude', $tableKeys)) !== false) {
                unset($tableKeys[$keyFind]);
            }
            if (($keyFind = array_search('is_parsed', $tableKeys)) !== false) {
                unset($tableKeys[$keyFind]);
            }
            ArrayHelper::removeValue($tableKeys, 'id');
            $diffColumns = array_diff($dataKeys, $tableKeys);
            $columnsToAdd = array_diff($tableKeys, $dataKeys);
            sort($tableKeys);

            $insert = "INSERT INTO `sale` ( `" . implode('`, `', $tableKeys) . "`, `is_parsed`) VALUES ";//echo $insert;
            foreach ($data as $key => $datum) {
                foreach ($datum as $colname => $value) {
                    if ($colname == 'region_id') {
                        $datum[$colname] = $locations[str_replace("'", '', strip_tags($datum[$colname]))];
                    } else if ($colname == 'area_location_id') {
                        $datum[$colname] = $locations[str_replace("'", '', strip_tags($datum[$colname]))];
                    } else if ($colname == 'sub_area_location_id') {
                        $datum[$colname] = $locations[str_replace("'", '', strip_tags($datum[$colname]))];
                    } else if ($colname == 'category_id') {
                        $datum[$colname] = $this->getCategory(str_replace("'", '', strip_tags($datum[$colname])));
                    } else if ($colname == 'status') {
                        $newStatus = "";
                        $a = new \DOMDocument();
                        $a->loadHTML($datum['status']);
                        $items = $a->getElementsByTagName('img');
                        if ($items->length > 0) {
                            $importStatus = $items->item(0)->getAttribute('title');

                            switch($importStatus) {
                                case 'Published':
                                    $newStatus = iRelationShip::STATUS_PUBLISHED;
                                    break;
                                case 'Draft':
                                    $newStatus = iRelationShip::STATUS_DRAFT;
                                    break;
                                case 'Unpublished':
                                    $newStatus = iRelationShip::STATUS_UNPUBLISHED;
                                    break;
                                case 'Waiting Approval':
                                    $newStatus = iRelationShip::STATUS_PENDING;
                                    break;
                            }
                        }
                        $datum[$colname] = $newStatus;
                    } else if ($colname == 'price') {
                        $datum[$colname] = str_replace(",", "", $value);
                    } else if ($colname == 'dateadded' || $colname == 'dateupdated') {
                        $datum[$colname] = date('Y-m-d H:i:s', strtotime(str_replace("'", '', strip_tags($value))));
                    } else {
                        $datum[$colname] = str_replace("'", '', strip_tags($value));
                        if (in_array($colname, $diffColumns)) ArrayHelper::remove($datum, $colname);
                        if ($colname == 'id') ArrayHelper::remove($datum, 'id');
                        foreach ($columnsToAdd as $column) {
                            $datum[$column] = '';
                            if ($column == 'company_id') $datum[$column] = $company_id;
                        }
                        $datum['slug'] = strip_tags($data[$key]['ref']);
                    }
                }
                ksort($datum);
                $insert .= "
            ('" . implode("', '", $datum) . "', '1'),";
            }
            $insert = rtrim($insert, ',');
            //echo $insert;exit();

            $query = Yii::$app->db->createCommand($insert);
            if ($query->execute()) {
                return true;
            }
        }
        return null;
    }

    public function getImages()
    {
        $curl = new Curl([], $this->username, $this->password, $this->clientId, CURL::IMAGES);
        $data = $this->downloadXml($this->xmlLink);
        $images = [];
        foreach ($data['Listing'] as $datum) {
            foreach ($datum['Images'] as $image){
                foreach ($image as $value) {
                    $images[$datum['Property_Ref_No']][] = $value;
                }
            }
        }
        foreach ($images as $ref => $imageArray) {
            foreach ($imageArray as $image) {
                $curl->downloadImages($image, $ref);          
            }
        }
    }

    public function test()
    {
        $images = [];
        $data = $this->downloadXml($this->xmlLink);
        foreach ($data['Listing'] as $key => $datum) {
            foreach ($datum['Images'] as $image){
                foreach ($image as $value) {
                    $images[$datum['Property_Ref_No']][] = $value;
                }
            }
        }
        $this->getImagesRecursively($images);
    }

    public function getImagesRecursively(&$data)
    {
        $images = [];
        $curl = new Curl([], $this->username, $this->password, $this->clientId, CURL::IMAGES);
        foreach ($data as $ref => $imagesArray) {
            foreach ($imagesArray as $key => $value) {
                ArrayHelper::remove($imagesArray, $key);
            }
            ArrayHelper::remove($images, $ref);
        }
        echo count($data) . '<hr />';
        $this->getImagesRecursively($data);
        
    }

    public function saveImagesToGallery($path, $propertyId)
    {
        $insert = "INSERT INTO gallery (`ref`, `path`) VALUES ('$propertyId', '/web/images/img/{$propertyId}/{$path}')";
        $query = Yii::$app->db->createCommand($insert);
        $query->execute();
    }

    public function saveLeads()
    {
        $leads = new LeadsImport();
        $data = $leads->getLeads($this->username, $this->password, $this->clientId);
        return $leads->saveLeads($data);
    }

    public function saveContacts()
    {
        $contacts = new ContactsImport();
        $data = $contacts->getContacts($this->username, $this->password, $this->clientId);
        return $contacts->saveContacts($data);
    }

    public function saveUsers()
    {
        $users = new UsersImport();
        $data = $users->getUsers($this->username, $this->password, $this->clientId, Curl::USERS);
        if ($users->saveUsers($data)) {
            return true;
        }
        return null;
    }

    public function recurse(&$data, $step = 100)
    {
        $i = 0;
        $columns = array_keys(array_shift($data)); //достаем из массива названия колонок

        //начинаем собирать запрос, имплодом расхерачиваем вышеуказанный массив с названиями колонок
        $insert = "INSERT INTO rentals (" . implode(', ', $columns) . ") VALUES ";
        foreach ($data as $key => $value) {
            foreach ($value as $ke => $item) {
                //убираем html теги из массива
                $value[$ke] = strip_tags($item);
            }
            $i++;
            $insert .= "( " . implode(', ', $value) . " ),";//добавляем в запрос значения для записи
            if ($i == $step) { //проверяем, если i уже равна 100, сбрасываем ее
                unset($i);
                //здесь будет выполнение запроса
                $this->recurse($data); //вызов текущей функции
            }
        }
    }

    private function getCategory($category)
    {
        if ($category) {
            $categoryRecord =  Yii::$app->db->createCommand("SELECT * FROM property_category WHERE title = '$category'")->queryOne();
            if ($categoryRecord)
                return $categoryRecord['id'];
            else {
                $maxOrder =  Yii::$app->db->createCommand("SELECT MAX(`order`) as max_order FROM property_category")->queryOne();
                $maxOrder = $maxOrder['max_order'] + 1;
                $insert = "INSERT INTO property_category (`title`, `order`) VALUES ('$category', '$maxOrder')";
                Yii::$app->db->createCommand($insert)->execute();
                return  Yii::$app->db->getLastInsertID();
            }
        } else return 0;
    }

}

