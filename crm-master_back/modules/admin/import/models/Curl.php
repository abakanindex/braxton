<?php
/**
 * Created by PhpStorm.
 * User: qp
 * Date: 18.01.2018
 * Time: 13:43
 */

namespace app\modules\admin\import\models;


use yii\base\Exception;
use yii\base\Model;
use yii\helpers\FileHelper;

class Curl extends Model
{

    private $username;
    private $password;
    private $clientId;
    private $targetUrl;

    const RENTALS = 'rentals';
    const SALES = 'sales';
    const LEADS = 'leads';
    const IMAGES = 'images';
    const CONTACTS = 'contacts';
    const USERS = 'users';

    /**
     * Curl constructor.
     * @param array $config
     * @param $username
     * @param $password
     * @param $clientId
     * @param string $type
     * @throws Exception
     */
    public function __construct($config = [], $username, $password, $clientId, $type)
    {
        if (empty($type) || $type == '') {
            if ($type !== Curl::RENTALS || $type !== Curl::SALES || $type !== Curl::LEADS) {
                throw new Exception('You need to set type: "Curl::RENTALS" or "Curl::SALES"');
            }
        }
        $this->username = $username;
        $this->password = $password;
        $this->clientId = $clientId;
        $this->targetUrl = 'https://crm.propspace.com/listings/datatable?type=';
        if ($type == Curl::RENTALS)
            $this->targetUrl .= Curl::RENTALS;
        if ($type == Curl::SALES)
            $this->targetUrl .= Curl::SALES;
        if ($type == Curl::LEADS)
            $this->targetUrl = 'https://crm.propspace.com/index.php/leads/datatable';
        if ($type == Curl::CONTACTS)
            $this->targetUrl = 'https://crm.propspace.com/landlord/datatable';
        if ($type == Curl::USERS)
            $this->targetUrl = 'https://crm.propspace.com/index.php/users/datatable?sEcho=1&iColumns=13&sColumns=&iDisplayStart=0&iDisplayLength=200&mDataProp_0=0&mDataProp_1=1&mDataProp_2=2&mDataProp_3=3&mDataProp_4=4&mDataProp_5=5&mDataProp_6=6&mDataProp_7=7&mDataProp_8=8&mDataProp_9=9&mDataProp_10=10&mDataProp_11=11&mDataProp_12=12&sSearch=&bRegex=false&sSearch_0=&bRegex_0=false&bSearchable_0=true&sSearch_1=&bRegex_1=false&bSearchable_1=true&sSearch_2=&bRegex_2=false&bSearchable_2=true&sSearch_3=&bRegex_3=false&bSearchable_3=true&sSearch_4=&bRegex_4=false&bSearchable_4=true&sSearch_5=&bRegex_5=false&bSearchable_5=true&sSearch_6=&bRegex_6=false&bSearchable_6=true&sSearch_7=&bRegex_7=false&bSearchable_7=true&sSearch_8=&bRegex_8=false&bSearchable_8=true&sSearch_9=&bRegex_9=false&bSearchable_9=true&sSearch_10=&bRegex_10=false&bSearchable_10=true&sSearch_11=&bRegex_11=false&bSearchable_11=true&sSearch_12=&bRegex_12=false&bSearchable_12=true&iSortCol_0=0&sSortDir_0=desc&iSortingCols=1&bSortable_0=false&bSortable_1=true&bSortable_2=true&bSortable_3=true&bSortable_4=true&bSortable_5=true&bSortable_6=true&bSortable_7=true&bSortable_8=true&bSortable_9=false&bSortable_10=true&bSortable_11=true&bSortable_12=true&due_dateS=';

        parent::__construct($config);
    }

    public function loginAndDownload()
    {
        define('USERNAME', $this->username);
        define('PASSWORD', $this->password);
        define('CLIENT_ID', $this->clientId);
        define('USER_AGENT', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.2309.372 Safari/537.36');
        define('COOKIE_FILE', $this->buildUniqueCookiePath());
        define('LOGIN_FORM_URL', 'https://crm.propspace.com/login.php');
        define('LOGIN_ACTION_URL', 'https://crm.propspace.com/verifylogin');
        define('TARGET_URL', $this->targetUrl);

        $postValues = [
            'client_id' => CLIENT_ID,
            'username' => USERNAME,
            'password' => PASSWORD
        ];

        if (strpos($this->targetUrl, '/users/') == false) {
            $dataPost = strpos($this->targetUrl, 'leads') == false ?
                $this->getRentalsPost() : $this->getLeadsPost();
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, LOGIN_ACTION_URL);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postValues));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_COOKIEJAR, COOKIE_FILE);
        curl_setopt($curl, CURLOPT_USERAGENT, USER_AGENT);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_REFERER, LOGIN_FORM_URL);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
        curl_exec($curl);
        if (curl_errno($curl)) {
            throw new \Exception(curl_error($curl));
        }
        curl_setopt($curl, CURLOPT_URL, $this->targetUrl);
        curl_setopt($curl, CURLOPT_POST, true);
        if (strpos($this->targetUrl, '/users/') == false) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($dataPost));
        }
        curl_setopt($curl, CURLOPT_COOKIEJAR, COOKIE_FILE);
        curl_setopt($curl, CURLOPT_USERAGENT, USER_AGENT);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $content = curl_exec($curl);
        if (curl_errno($curl)) {
            throw new \Exception(curl_error($curl));
        }
        return json_decode($content, true);
    }

    public static function downloadXml($link, $filePath)
    {
        $destinationFile = @fopen($filePath, "w");
        $resource = curl_init();
        curl_setopt($resource, CURLOPT_URL, $link);
        curl_setopt($resource, CURLOPT_FILE, $destinationFile);
        curl_setopt($resource, CURLOPT_HEADER, 0);
        $data = curl_exec($resource);
        curl_close($resource);
        fclose($destinationFile);
        return $data ? true : null;
    }

    public function downloadImages($imageLink, $propertyId)
    {
        parse_str($imageLink, $filename);
        $uniquePath = $this->buildUniqueImagesPath($propertyId) . '/' . $filename['image'];

        $import = new InitImport();
        $import->saveImagesToGallery(basename($uniquePath), $propertyId);

        $image = file_get_contents($imageLink);
        file_put_contents($uniquePath, $image);
    }

    private function getRentalsPost()
    {
        return require('post_array_rentals.php');
    }

    public function getLeadsPost()
    {
        return require('post_array_leads.php');
    }

    private function buildUniqueCookiePath($dir = '')
    {
        if ($dir === '') {
            $dir = DOCUMENT__ROOT . '/web/temp_cookies';
        }
        if (!file_exists($dir)) {
            FileHelper::createDirectory($dir);
        }
        $uniquePath = $dir . '/' . $this->clientId . '_' . $this->username;
        if (!file_exists($uniquePath)) {
            FileHelper::createDirectory($uniquePath);
            $cookieFile = $uniquePath . '/cookies.txt';
            file_put_contents($cookieFile, ' ');
            return $cookieFile;
        }
        return null;
    }

    private function buildUniqueImagesPath($propertyId)
    {
        $dir = DOCUMENT__ROOT . '/web/images/img';

        if (!file_exists($dir)) {
            FileHelper::createDirectory($dir);
        }
        $uniquePath = $dir . '/' . $propertyId;
        if (!file_exists($uniquePath)) {
            FileHelper::createDirectory($uniquePath);
        }
        return $uniquePath;
    }


}