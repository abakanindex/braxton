<?php

namespace app\models;

use app\models\ref\Ref;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\admin\models\OwnerManageGroup;

/**
 * This is the model class for table "viewings".
 *
 * @property int $id
 * @property string $date
 * @property int $agent_id
 * @property int $request_viewing_pack_id
 * @property string $listing_ref
 * @property int $status
 * @property string $client_name
 * @property string $ref
 * @property string $note
 * @property int $created_by
 * @property int $type
 * @property int $type_listing_ref
 * @property int $report_cancellations
 * @property string $report_cancellation_date
 * @property string $report_title
 * @property string $report_description
 * @property int $is_report_complete
 * @property int $is_sent_to_creator
 */
class Viewings extends \yii\db\ActiveRecord
{
    public function beforeSave($insert)
    {
        $listingRef = strtolower($this->listing_ref);

        if (strpos($listingRef, strtolower(Ref::REF_LEAD)) !== false)
            $this->type_listing_ref = Viewings::TYPE_LEAD;

        else if (strpos($listingRef, strtolower(Ref::REF_SALE)) !== false)
            $this->type_listing_ref = Viewings::TYPE_SALE;

        else if (strpos($listingRef, strtolower(Ref::REF_RENTAL)) !== false)
            $this->type_listing_ref = Viewings::TYPE_RENTAL;

        return parent::beforeSave($insert);
    }

    public $time;

    const STATUS_SCHEDULED = 1;
    const STATUS_CANCELLED = 2;
    const STATUS_SUCCESSFUL = 3;
    const STATUS_UNSUCCESSFUL = 4;

    const TYPE_SALE = 1;
    const TYPE_RENTAL = 2;
    const TYPE_LEAD = 3;

    const REPORT_MAX_CANCELLATIONS_AGENT = 3;

    public $username;
    public $first_name;
    public $last_name;

    public static $statuses = [
        self::STATUS_SCHEDULED =>  'SCHEDULED',
        self::STATUS_CANCELLED => 'CANCELLED',
        self::STATUS_SUCCESSFUL => 'SUCCESSFUL',
        self::STATUS_UNSUCCESSFUL => 'UNSUCCESSFUL',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'viewings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['agent_id', 'request_viewing_pack_id', 'status', 'created_by', 'type', 'type_listing_ref'], 'integer'],
            [['ref', 'client_name'], 'required'],
            [['note'], 'string'],
            [['listing_ref', 'client_name', 'ref'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                      => Yii::t('app', 'ID'),
            'date'                    => Yii::t('app', 'Date'),
            'agent_id'                => Yii::t('app', 'Agent ID'),
            'request_viewing_pack_id' => Yii::t('app', '2nd Agent ID'),
            'listing_ref'             => Yii::t('app', 'Listing Ref'),
            'status'                  => Yii::t('app', 'Status'),
            'client_name'             => Yii::t('app', 'Client Name'),
            'ref'                     => Yii::t('app', 'Ref'),
            'note'                    => Yii::t('app', 'Note'),
        ];
    }

    public function getAgent()
    {
        return $this->hasOne(User::className(), ['id' => 'agent_id']);
    }

    public function getRequestViewingPack()
    {
        return $this->hasOne(User::className(), ['id' => 'request_viewing_pack_id']);
    }

    public static function getByRef($ref)
    {
        return Viewings::find()->where(['ref' => $ref])->orderBy(['id' => SORT_DESC])->with('agent')->with('requestViewingPack')->all();
    }

    /**
     * return viewings, where report was complete
     * @param int $complete
     * @param string $ref
     * @param int $agentId
     * @return mixed
     */
    public static function getByCompleteReport(int $complete, ?string $ref, int $agentId)
    {
        return Viewings::find()
            ->where(['ref' => $ref])
            ->andWhere(['or',
                ['agent_id' => $agentId],
                ['request_viewing_pack_id' => $agentId]
            ])
            ->andWhere(['is_report_complete' => $complete])
            ->orderBy(['id' => SORT_DESC])
            ->all();
    }

    /**
     * @param null|string $ref
     * @param int $agentId
     * @return ActiveRecord[]
     */
    public static function getByRefByAgents(?string $ref, int $agentId) : array
    {
        return Viewings::find()
            ->where(['ref' => $ref])
            ->andWhere(['or',
                ['agent_id' => $agentId],
                ['request_viewing_pack_id' => $agentId]
            ])
            ->orderBy(['id' => SORT_DESC])
            ->with('agent')
            ->with('requestViewingPack')
            ->all();
    }

    public static function getByUser($userId)
    {
        return self::findAll(['created_by' => $userId]);
    }

    public function getLink()
    {
        switch($this->type) {
            case self::TYPE_SALE:
                return Html::a($this->ref, ['/sale/' . $this->ref], ['target' => '_blank', 'data-pjax' => '0']);
                break;
            case self::TYPE_LEAD:
                return Html::a($this->ref, ['/leads/' . $this->ref], ['target' => '_blank', 'data-pjax' => '0']);
                break;
            case self::TYPE_RENTAL:
                return Html::a($this->ref, ['/rentals/' . $this->ref], ['target' => '_blank', 'data-pjax' => '0']);
                break;
            default:
                return $this->ref;
        }
    }

    public function getLinkListingRef()
    {
        switch($this->type_listing_ref) {
            case self::TYPE_SALE:
                return Html::a($this->listing_ref, ['/sale/' . $this->listing_ref], ['target' => '_blank', 'data-pjax' => '0']);
                break;
            case self::TYPE_LEAD:
                return Html::a($this->listing_ref, ['/leads/' . $this->listing_ref], ['target' => '_blank', 'data-pjax' => '0']);
                break;
            case self::TYPE_RENTAL:
                return Html::a($this->listing_ref, ['/rentals/' . $this->listing_ref], ['target' => '_blank', 'data-pjax' => '0']);
                break;
            default:
                return $this->listing_ref;
        }
    }

    /**
     * @return array|Viewings[]
     */
    public static function getViewings() : array
    {
        $companyId = Company::getCompanyIdBySubdomain();
        if ($companyId == 'main' or $companyId == 0) {
            $query = self::find();
        } else {
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query = self::find();
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {

                    $query = self::find()
                        ->where(['created_by' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query = self::find()
                        ->where(['created_by' => Yii::$app->user->id]);
                }
            }
        }

        return $query->all();
    }

    /**
     * @return array
     */
    public static function getTypes() : array
    {
        $types[self::TYPE_SALE]   = Yii::t('app', 'Sales Type');
        $types[self::TYPE_RENTAL] = Yii::t('app', 'Rental Type');
        $types[self::TYPE_LEAD]   = Yii::t('app', 'Lead Type');
        return $types;
    }

    /**
     * @param string $date
     * @return string
     */
    public function getFormattedDateTime(string $date) : string
    {
        $date = strtotime($date);
        return date("Y-m-d", $date) . 'T' . date("H:i:s", $date);
    }

    /**
     * @return array
     */
    public static function getStatuses()
    {
        $result[self::STATUS_SCHEDULED]    = Yii::t('app', 'Scheduled');
        $result[self::STATUS_CANCELLED]    = Yii::t('app', 'Cancelled');
        $result[self::STATUS_SUCCESSFUL]   = Yii::t('app', 'Successful');
        $result[self::STATUS_UNSUCCESSFUL] = Yii::t('app', 'Not Successful');
        return $result;
    }

    /**
     * @param int $userId
     * @return null|ActiveRecord
     */
    public static function findForViewingReport(int $userId) : ?ActiveRecord
    {
        return self::find()
            ->where([
                'status' => self::STATUS_SUCCESSFUL,
                'agent_id' => $userId,
                'is_report_complete' => 0
            ])
            ->andWhere(['<', 'report_cancellations', self::REPORT_MAX_CANCELLATIONS_AGENT])
            ->andWhere('NOW() > DATE_ADD(report_cancellation_date, INTERVAL 1 DAY)')
            ->one();
    }

    /**
     * @return null|ActiveRecord[]
     */
    public static function findWithThreeCancellationsOfAgents() : ?array
    {
        return self::find()
            ->where([
                'status'               => self::STATUS_SUCCESSFUL,
                'report_cancellations' => self::REPORT_MAX_CANCELLATIONS_AGENT,
                'is_report_complete'   => 0,
                'is_sent_to_creator'   => 0,
            ])
            ->all();
    }

    /**
     * @param int $id
     * @return null|ActiveRecord
     */
    public static function getByIdWithAgent(int $id) : ?ActiveRecord
    {
        return self::find()
            ->alias('v')
            ->select('*')
            ->where(['v.id' => $id])
            ->joinWith('agent')
            ->one();
    }
}
