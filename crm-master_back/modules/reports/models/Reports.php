<?php

namespace app\modules\reports\models;

use app\models\Leads;
use app\models\User;
use app\modules\reports\models\search\LeadsReportsSearch;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "report".
 *
 * @property int $id
 * @property int $type
 * @property int $menu_item
 * @property int $user_id
 * @property int $created_at
 * @property string $description
 * @property string $name
 * @property int $date_type
 * @property int $date_from
 * @property int $date_to
 * @property int $url_id
 *
 * @property User $user
 */
class Reports extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report';
    }

    const MENU_ITEM = 1;
    const MENU_ITEM_NOT = 0;

    const SECTION_REPORTS_LISTINGS = 1;
    const SECTION_REPORTS_LEADS = 2;
    const SECTION_REPORTS_DEALS = 3;
    const SECTION_REPORTS_CONTACTS = 4;
    const SECTION_REPORTS_TO_DO_TASKS = 5;

    const LEAD_TYPE = 1;
    const LEAD_STATUS = 2;
    const LEAD_VIEWINGS = 3;
    const DEALS_TYPE_STATUS = 4;
    const DEALS_SUCCESSFUL = 5;
    const SALES_CATEGORY = 6;
    const RENTALS_CATEGORY = 7;
    const SALES_LOCATION = 8;
    const RENTALS_LOCATION = 9;
    const SALES_STATUS = 10;
    const RENTALS_STATUS = 11;
    const SALES_VIEWINGS_REPORT = 12;
    const RENTALS_VIEWINGS_REPORT = 13;
    const TASKS_PRIORITY_REPORT = 14;
    const AGENT_LEADER = 15;
    const SALES_AGENTS = 16;
    const RENTALS_AGENTS = 17;
    const LEAD_AGENTS = 18;
    const LEAD_PROPERTY = 19;
    const LEAD_SOURCE = 20;
    const LEAD_OPEN = 21;
    const LEAD_AGENT_CONTACT_INTERVAL = 22;
    const LEAD_AGENT_CONTACT_NUMBER = 23;
    const LEAD_BY_LOCATION = 24;
    const SALES_AGENTS_IN_NUMBERS_PROPERTIES = 25;
    const SALES_AGENTS_IN_AED = 26;
    const SALES_LOCATION_CLOSED = 27;
    const RENTALS_AGENTS_IN_NUMBERS_PROPERTIES = 28;
    const RENTALS_AGENTS_IN_AED = 29;
    const RENTALS_LOCATION_CLOSED = 30;
    const AGENT_LEADERBOARD_SALES = 31;
    const AGENT_LEADERBOARD_RENTALS = 32;
    const SALES_INACTIVE_AGENTS = 33;
    const RENTALS_INACTIVE_AGENTS = 34;

    const DATE_TYPE_TOTAL = 1;
    const DATE_TYPE_TIME = 2;

    public static $allColors = ['#1FCE6E', '#298ED2', '#F3AC5A', '#9D6CE1', '#21C2C5', '#E3071C', '#FFEA00', '#ED74BE', '#A1887F', '#B9BE29', '#C7C7C7'];

    public static $listingTypes = [
        self::SALES_CATEGORY,
        self::RENTALS_CATEGORY,
        self::SALES_LOCATION,
        self::RENTALS_LOCATION,
        self::SALES_STATUS,
        self::RENTALS_STATUS,
        self::SALES_VIEWINGS_REPORT,
        self::RENTALS_VIEWINGS_REPORT
    ];

    public static $leadTypes = [
        self::LEAD_TYPE,
        self::LEAD_STATUS,
        self::LEAD_VIEWINGS
    ];

    public static $dealsTypes = [
        self::DEALS_TYPE_STATUS,
        self::DEALS_SUCCESSFUL,
    ];

    public static $tasksTypes = [
        self::TASKS_PRIORITY_REPORT,
    ];

    public static $types = [
        self::LEAD_TYPE,
        self::LEAD_STATUS,
        self::LEAD_VIEWINGS,
        self::DEALS_TYPE_STATUS,
        self::DEALS_SUCCESSFUL
    ];

    public static $dateType = [
        self::DATE_TYPE_TOTAL,
        self::DATE_TYPE_TIME
    ];

    public static function getDateTypeTitle($type)
    {
        switch ($type) {
            case self::DATE_TYPE_TOTAL:
                return Yii::t('app', 'Total');
            case self::DATE_TYPE_TIME:
                return Yii::t('app', 'Interval');
        }
    }

    public static function getDateTypeArray()
    {
        $types = [];
        foreach (self::$dateType as $type) {
            $types[$type] = self::getDateTypeTitle($type);
        }
        return $types;
    }

    public static function getTypeTitle($type)
    {
        switch ($type) {
            case self::SECTION_REPORTS_LISTINGS:
                return Yii::t('app', 'Listings');
            case self::SECTION_REPORTS_LEADS:
                return Yii::t('app', 'Leads');
            case self::SECTION_REPORTS_DEALS:
                return Yii::t('app', 'Deals');
            case self::SECTION_REPORTS_CONTACTS:
                return Yii::t('app', 'Contacts');
            case self::SECTION_REPORTS_TO_DO_TASKS:
                return Yii::t('app', 'To-Do Tasks');
        }
    }

    public static function getTypeArray()
    {
        $types = [];
        foreach (self::$types as $type) {
            $types[$type] = self::getTypeTitle($type);
        }
        return $types;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'user_id', 'created_at', 'date_type', 'menu_item'], 'integer'],
            [['user_id', 'created_at', 'date_type', 'url_id', 'name', 'menu_item'], 'required'],
            [['description', 'url_id', 'date_from', 'date_to'], 'string'],
            [['description', 'date_from', 'date_to'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'description' => Yii::t('app', 'Description'),
            'name' => Yii::t('app', 'Name'),
            'date_type' => Yii::t('app', 'Date Type'),
            'date_from' => Yii::t('app', 'Date From'),
            'date_to' => Yii::t('app', 'Date To'),
            'url_id' => Yii::t('app', 'Url ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function generateUniqueRandomString($attribute, $length = 32)
    {

        $randomString = Yii::$app->getSecurity()->generateRandomString($length);

        if (!$this->findOne([$attribute => $randomString]))
            return $randomString;
        else
            return $this->generateUniqueRandomString($attribute, $length);

    }

}
