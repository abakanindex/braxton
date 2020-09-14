<?php

namespace app\models;

use Yii;
use kartik\mpdf\Pdf;
use yii\helpers\{ArrayHelper, Url, Json, FileHelper};
use yii\data\ActiveDataProvider;
use yii2tech\spreadsheet\Spreadsheet;

/**
 * This is the model class for table "documents_generated".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $path
 * @property int $created_at
 */
class DocumentsGenerated extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documents_generated';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['user_id', 'created_at'], 'integer'],
            [['name', 'path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @param $pathUpload
     * @param $fileName
     * @param $data
     * @param $titles
     * @param $sheetName
     */
    public static function generateXls($pathUpload, $fileName, $query, $columns)
    {
        FileHelper::createDirectory($pathUpload);

        $exporter = new Spreadsheet([
            'dataProvider' => new ActiveDataProvider([
                    'query' => $query,
                ]),
            'columns' => $columns
        ]);
        $exporter->save($pathUpload . $fileName);
        DocumentsGenerated::add($fileName, $pathUpload, Yii::$app->user->id);
    }

    /**
     * @param $content
     * @param $pathUpload
     * @param $fileName
     */
    public static function generatePdf($content, $pathUpload, $fileName)
    {
        FileHelper::createDirectory($pathUpload);

        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A3,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_DOWNLOAD,//DEST_BROWSER
            // your html content input
            //'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '',
            // set mPDF properties on the fly
            'options' => ['title' => ''],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader'=>[''],
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);

        $mpdf = $pdf->api;
        $mpdf->WriteHTML($content);
        $mpdf->Output($pathUpload . $fileName, 'F');

        DocumentsGenerated::add($fileName, $pathUpload, Yii::$app->user->id);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'path' => 'Path',
            'created_at' => 'Created At',
        ];
    }

    public static function add($name, $path, $userId)
    {
        $model = new DocumentsGenerated();
        $model->name       = $name;
        $model->path       = $path;
        $model->user_id    = $userId;
        $model->created_at = time();
        $model->save();

        return $model;
    }

    public static function getForUser($name, $userId)
    {
        return self::findOne([
            'name'    => $name,
            'user_id' => $userId
        ]);
    }

    public static function getAll()
    {
        return self::find()->all();
    }
}
