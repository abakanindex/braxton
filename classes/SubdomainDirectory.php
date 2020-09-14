<?php 

namespace app\classes;


use yii\base\Model;
use app\widgets\JavascriptConsole;


class SubdomainDirectory extends Model
{
    public static $viewPath;

    public static $subdomainName;

    public static function checkIfExist($subdomainName)
    {
        self::$viewPath = $_SERVER['DOCUMENT_ROOT'] . '/views/COMPANIES/';
        self::$subdomainName = $subdomainName;
        return file_exists(self::$viewPath . $subdomainName . '/') ? true : false;
    }

    public static function createDirectory($subdomainName)
    {
        if (self::checkIfExist($subdomainName)) {
            return false;
        }
        return mkdir(self::$viewPath . $subdomainName . '/', null, false) ? true : false;
    }

    public static function createFile($filename, $path = '', $data = false)
    {
        if ($path == '') {
            if (!file_exists(self::$viewPath . self::$subdomainName . '/' . $filename)){
                return file_put_contents(self::$viewPath . self::$subdomainName . '/' . $filename, $data) ? true : false;
            }
        }
    }
}