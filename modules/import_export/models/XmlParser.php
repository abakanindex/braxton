<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 27.09.2017
 * Time: 1:46
 */

namespace app\modules\import_export\models;

use app\modules\ImportExport\models\UploadLog;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'] . '/app/yii2/uploads/');

class XmlParser
{

    private $xmlContent;

    public function __construct($fileName)
    {
        $this->xmlContent = $this->getXmlFileContent(UPLOAD_DIR . $fileName);
    }

    public function getXmlFileContent($fileName)
    {
        return simplexml_load_file($fileName);
    }

    public function XmlToArray($xmlContent)
    {
        return ArrayHelper::getValue($this->xmlContent, 'property');
    }

    public function testShow()
    {
        var_dump('<pre>', $this->xmlContent->property->photo);
    }
}