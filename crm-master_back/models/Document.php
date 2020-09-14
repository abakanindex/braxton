<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\helpers\FileHelper;
use yii\validators\FileValidator;

/**
 * This is the model class for table "document".
 *
 * @property int $id
 * @property string $ref
 * @property string $name
 * @property string $path
 * @property int $user_id
 * @property int $category
 * @property string $date
 */
class Document extends \yii\db\ActiveRecord
{
    public $files;

    const KEY_TYPE_LEAD = 1;
    const KEY_TYPE_SALE = 2;
    const KEY_TYPE_RENTAL = 3;
    const KEY_TYPE_CONTACT = 4;

    public static $documentLeads = [
        self::DOCUMENT_TYPE_PASSPORT_COPY => 'Passport copy',
        self::DOCUMENT_TYPE_VISA_PAGE => 'Visa Page',
        self::DOCUMENT_TYPE_EMIRATES_ID => 'Emirates ID',
        self::DOCUMENT_TYPE_FORM_B => 'Form B',
        self::DOCUMENT_TYPE_BROKERAGE_AGREEMENT => 'Brokerage Agreement',
        self::DOCUMENT_TYPE_EXCLUSIVITY_AGREEMENT => 'Exclusivity Agreement',
        self::DOCUMENT_TYPE_POA => 'POA',
        self::DOCUMENT_TYPE_OTHERS => 'Others'
    ];

    public static $documentTenants = [
        self::DOCUMENT_TYPE_PASSPORT_COPY => 'Passport copy',
        self::DOCUMENT_TYPE_VISA_PAGE => 'Visa Page',
        self::DOCUMENT_TYPE_EMIRATES_ID => 'Emirates ID',
        self::DOCUMENT_TYPE_FORM_B => 'Form B',
        self::DOCUMENT_TYPE_EJARI => 'Ejari',
        self::DOCUMENT_TYPE_COPY_OF_CHEQUES => 'Copy of Cheques',
        self::DOCUMENT_TYPE_TENANCY_CONTRACT => 'Tenancy Contract',
        self::DOCUMENT_TYPE_DEWA_FINAL_BILL => 'Dewa Final Bill',
        self::DOCUMENT_TYPE_DEWA_CONNECTION => 'Dewa Connection',
        self::DOCUMENT_TYPE_POA => 'POA',
        self::DOCUMENT_TYPE_EXCLUSIVITY_AGREEMENT => 'Exclusivity Agreement',
        self::DOCUMENT_TYPE_OTHERS => 'Others'
    ];

    public static $documentBuyers = [
        self::DOCUMENT_TYPE_PASSPORT_COPY => 'Passport copy',
        self::DOCUMENT_TYPE_VISA_PAGE => 'Visa Page',
        self::DOCUMENT_TYPE_EMIRATES_ID => 'Emirates ID',
        self::DOCUMENT_TYPE_FORM_B => 'Form B',
        self::DOCUMENT_TYPE_VIEWING_FORM => 'Viewing Form',
        self::DOCUMENT_TYPE_FORM_F => 'Form F',
        self::DOCUMENT_TYPE_FORM_I => 'Form I',
        self::DOCUMENT_TYPE_MOU => 'MOU',
        self::DOCUMENT_TYPE_POA => 'POA',
        self::DOCUMENT_TYPE_EXCLUSIVITY_AGREEMENT => 'Exclusivity Agreement',
        self::DOCUMENT_TYPE_OTHERS => 'Others'
    ];

    public static $documentLandlordsSellers = [
        self::DOCUMENT_TYPE_PASSPORT_COPY => 'Passport copy',
        self::DOCUMENT_TYPE_VISA_PAGE => 'Visa Page',
        self::DOCUMENT_TYPE_EMIRATES_ID => 'Emirates ID',
        self::DOCUMENT_TYPE_MARKETING_FORM => 'Marketing Form',
        self::DOCUMENT_TYPE_FORM_A => 'Form A',
        self::DOCUMENT_TYPE_TITLE_DEED => 'Title deed',
        self::DOCUMENT_TYPE_POA => 'POA',
        self::DOCUMENT_TYPE_MORTGAGE_DETAILS => 'Mortgage Details',
        self::DOCUMENT_TYPE_TRADE_LICENSE => 'Trade License',
        self::DOCUMENT_TYPE_AFFECTION_PLAN => 'Affection Plan',
        self::DOCUMENT_TYPE_NOC => 'NOC',
        self::DOCUMENT_TYPE_CLIENT_INFORMATION_FORM => 'Client Information Form',
        self::DOCUMENT_TYPE_NDA => 'NDA',
        self::DOCUMENT_TYPE_EXCLUSIVITY_AGREEMENT => 'Exclusivity Agreement',
        self::DOCUMENT_TYPE_OTHERS => 'Others'
    ];

    public static $documentAgents = [
        self::DOCUMENT_TYPE_PASSPORT_COPY => 'Passport copy',
        self::DOCUMENT_TYPE_VISA_PAGE => 'Visa Page',
        self::DOCUMENT_TYPE_EMIRATES_ID => 'Emirates ID',
        self::DOCUMENT_TYPE_FORM_I => 'Form I',
        self::DOCUMENT_TYPE_RERA_CERTIFICATE => 'RERA Certificate',
        self::DOCUMENT_TYPE_COMPANY_ORN => 'Company ORN',
        self::DOCUMENT_TYPE_COMPANY_TRADE_LICENSE => 'Company Trade License',
        self::DOCUMENT_TYPE_OTHERS => 'Others'
    ];

    const DOCUMENT_TYPE_PASSPORT_COPY = 1;
    const DOCUMENT_TYPE_VISA_PAGE = 2;
    const DOCUMENT_TYPE_EMIRATES_ID = 3;
    const DOCUMENT_TYPE_FORM_B = 4;
    const DOCUMENT_TYPE_BROKERAGE_AGREEMENT = 5;
    const DOCUMENT_TYPE_EXCLUSIVITY_AGREEMENT = 6;
    const DOCUMENT_TYPE_POA = 7;
    const DOCUMENT_TYPE_OTHERS = 8;
    const DOCUMENT_TYPE_EJARI = 9;
    const DOCUMENT_TYPE_COPY_OF_CHEQUES = 10;
    const DOCUMENT_TYPE_TENANCY_CONTRACT = 11;
    const DOCUMENT_TYPE_DEWA_FINAL_BILL = 12;
    const DOCUMENT_TYPE_DEWA_CONNECTION = 13;
    const DOCUMENT_TYPE_VIEWING_FORM = 14;
    const DOCUMENT_TYPE_FORM_F = 15;
    const DOCUMENT_TYPE_FORM_I = 16;
    const DOCUMENT_TYPE_MOU = 17;
    const DOCUMENT_TYPE_MARKETING_FORM = 18;
    const DOCUMENT_TYPE_FORM_A = 19;
    const DOCUMENT_TYPE_TITLE_DEED = 20;
    const DOCUMENT_TYPE_MORTGAGE_DETAILS = 21;
    const DOCUMENT_TYPE_TRADE_LICENSE = 22;
    const DOCUMENT_TYPE_AFFECTION_PLAN = 23;
    const DOCUMENT_TYPE_NOC = 24;
    const DOCUMENT_TYPE_CLIENT_INFORMATION_FORM = 25;
    const DOCUMENT_TYPE_NDA = 26;
    const DOCUMENT_TYPE_RERA_CERTIFICATE = 27;
    const DOCUMENT_TYPE_COMPANY_ORN = 28;
    const DOCUMENT_TYPE_COMPANY_TRADE_LICENSE = 29;

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->date = new Expression('NOW()');
        }

        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'document';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ref', 'name', 'path', 'user_id'], 'required'],
            [['user_id', 'category'], 'integer'],
            [['date'], 'safe'],
            [['ref', 'name', 'path'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ref' => Yii::t('app', 'Ref'),
            'path' => Yii::t('app', 'Path'),
            'user_id' => Yii::t('app', 'User ID'),
            'date' => Yii::t('app', 'Date'),
            'category' => Yii::t('app', 'Category')
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function getByRef($ref)
    {
        return Document::find()->where(['ref' => $ref])->orderBy(['id' => SORT_DESC])->with('user')->all();
    }

    public function upload($files, $postData)
    {
        $fileNameCustom = $postData['Document']['name'];
        $dirToUpload = '/uploads/' . $this->ref;
        $path = Yii::getAlias('@app') . $dirToUpload;
        FileHelper::createDirectory($path);
        $fileValidator = new FileValidator([
//            'extensions' => 'doc, docx, xls, xlsx, ppt, pptx, pdf, txt',
//            'checkExtensionByMimeType' => false,
            'maxSize' => 5242880
        ]);

        foreach ($files as $file) {
            if ($fileValidator->validate($file)) {
                $fileName = $fileNameCustom . '.' . $file->extension;
                $fileNameUpload = '/' . $fileName;

                if ($file->saveAs($path . $fileNameUpload)) {
                    $modelDoc = new Document();
                    $modelDoc->load($postData);
                    $modelDoc->path = $dirToUpload . $fileNameUpload;
                    $modelDoc->user_id = Yii::$app->user->id;
                    $modelDoc->name = $fileName;
                    $modelDoc->save();
                }
            }
        }
    }
}
