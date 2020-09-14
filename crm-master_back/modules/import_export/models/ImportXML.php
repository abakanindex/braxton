<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 24.09.2017
 * Time: 18:17
 */

namespace app\modules\import_export\models;


use Yii;
use yii\base\Model;
use yii\db\Exception;
use yii\web\UploadedFile;
use app\modules\ImportExport\models\UploadLog;


class ImportXML extends Model
{
    /**
     * @var UploadedFile
     */
    public $xmlFile;

    /**
     * @var string
     */
    private $newFileName;

    /**
     * @var string
     */
    private $savePath;

    /**
     * @var bool
     */
    public $success = false;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['xmlFile'], 'file',],
        ];
    }

    /**
     * @return bool
     */
    public function uploadXmlFile()
    {
        $this->setSavePath($_SERVER['DOCUMENT_ROOT'] . '/app/yii2/uploads/');
        if ($this->validate()) {
            $path = $this->getSavePath();
            $this->xmlFile->saveAs($path . $this->getFilename());
            $this->setUploadLog();
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function setUploadLog()
    {
        $modelUploadLog = new UploadLog();
        if (!$modelUploadLog->insertLogRow($this->xmlFile->name,
            Yii::$app->user->getId(), $this->getFileIdentifier())) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return Yii::$app->user->getId() . '_' . $this->getTimestamp() . '_' .
            $this->getFileIdentifier() . '_' . $this->xmlFile->baseName . '.' . $this->xmlFile->extension;
    }

    /**
     * @return false|string
     */
    public function getTimestamp()
    {
        return date('Y-m-d');
    }

    /**
     * @return int
     */
    public function getFileIdentifier()
    {
        return rand(10000, 99999);
    }

    /**
     * @return string
     */
    public function getSavePath()
    {
        return $this->savePath;
    }

    /**
     * @param $savePath
     * @return bool
     */
    public function setSavePath($savePath)
    {
        if (!empty($savePath) && $savePath !== '') {
            $this->savePath = $savePath;
        } else return 'Save path must be a string and cant be empty!';
    }


}