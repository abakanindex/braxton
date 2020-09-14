<?php

namespace app\models;

use app\components\behaviors\ReminderBehavior;
use app\models\reference_books\PropertyCategory;
use app\models\statusHistory\ArchiveHistory;
use app\models\admin\dataselect\ContactSource;
use app\modules\lead\models\LeadAdditionalEmail;
use app\modules\lead\models\LeadContactNote;
use app\modules\lead\models\LeadNote;
use app\modules\lead\models\LeadProperty;
use app\modules\lead\models\LeadSocialMediaContact;
use app\modules\lead\models\LeadType;
use app\modules\lead\models\PropertyRequirement;
use app\modules\lead_viewing\models\LeadViewing;
use app\modules\lead\models\CompanySource;
use app\modules\lead\models\LeadAgent;
use app\modules\lead\models\LeadSubStatus;
use app\models\Company;
use Yii;
use yii\behaviors\SluggableBehavior;
use app\interfaces\leads\iLeads;
use app\interfaces\firstrecordmodel\IfirstRecordModel;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use app\modules\admin\models\OwnerManageGroup;
use yii\db\Query;

/**
 * This is the model class for table "leads".
 *
 * @property int $id
 * @property int $type_id
 * @property string $reference
 * @property int $status
 * @property int $sub_status_id
 * @property int $priority
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile_number
 * @property int $category_id
 * @property string $location
 * @property string $sub_location
 * @property string $unit_type
 * @property string $unit_number
 * @property int $min_beds
 * @property int $max_beds
 * @property string $min_price
 * @property string $max_price
 * @property int $min_area
 * @property int $max_area
 * @property int $activity
 * @property int $source
 * @property int $created_by_user_id
 * @property int $company_id
 * @property int $finance_type
 * @property int $enquiry_time
 * @property int $parent_id
 * @property int $updated_time
 * @property int $is_imported
 * @property string $contract_company
 * @property string $email
 * @property string $emirate
 * @property string $agent_referrala
 * @property string $shared_leads
 * @property string $hot_lead
 * @property string $listing_ref
 * @property string $agent_1
 * @property string $agent_2
 * @property string $agent_3
 * @property string $agent_4
 * @property string $agent_5
 * @property string $reminderAttr
 * @property double $latitude
 * @property double $longitude
 * @property int $created_at
 * @property string $origin
 *
 * @property LeadAgent[] $leadAgents
 * @property LeadViewing[] $leadViewings
 * @property Company $company
 * @property User $createdByUser
 * @property CompanySource $companySource
 * @property LeadSubStatus $subStatus
 */
class Leads extends \yii\db\ActiveRecord implements iLeads, IfirstRecordModel
{

    public $categoryTitle;
    public $agentContactIntervalDays;
    public $viewingStatus;
    public $noteAgentName;
    public $propertyLocationName;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leads';
    }

    public $number;
    public $distribution;
    public $totalCount;
    public $socialMediaContacts;
    public $additionalEmails;
    public $notesAttr;
    public $agents;
    public $emailImportLeadRef;
    public $reminder;

    const IS_PARSED = 1;
    const IS_PARSED_NOT = 0;

    const ORIGIN_ADDED_MANUALLY = 1;
    const ORIGIN_IMPORT_FROM_PROPSPACE = 2;
    const ORIGIN_IMAP = 3;

    public static $origins = [
        self::ORIGIN_ADDED_MANUALLY        => 'Added manually',
        self::ORIGIN_IMPORT_FROM_PROPSPACE => 'Import from Propspace',
        self::ORIGIN_IMAP                  => 'Imap'
    ];

    public static $statuses = [
        self::STATUS_OPEN,
        self::STATUS_CLOSED,
        self::STATUS_NOT_SPECIFIED,
    ];

    public function behaviors()
    {
        return [
            [
                'class'     => SluggableBehavior::className(),
                'attribute' => 'reference',
            ],
            [
                'class'        => ReminderBehavior::className(),
                'reminderAttr' => 'reminder',
                'key'          => Reminder::KEY_TYPE_LEAD,
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!$this->origin) {
                $this->origin = self::ORIGIN_ADDED_MANUALLY;
            }

            if (Yii::$app->controller->action->id === 'update') {
                $archive = new ArchiveHistory(self::findOne($this->id));
                $archive->addArchiveProperty(
                    $this->getDirtyAttributes(),
                    $this->getOldAttributes()
                );
            }
            return true;
        }
        return false;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getType($id = null)
    {
        if ($id == null) {
            return LeadType::findOne(['id' => $this->type_id])->title;
        } else {
            return LeadType::findOne(['id' => $id])->title;
        }
        
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeOne()
    {
        return $this->hasOne(LeadType::class, ['id' => 'type_id']);
    }

    /**
     * Undocumented function
     *
     * @param  $type
     * @return void
     */
    public static function findType($type)
    {
        return LeadType::findOne(['id' => $type])->title;
    }

    public function getEmirateRecord()
    {
        return $this->hasOne(Locations::className(), ['id' => 'emirate']);
    }

    public function getLocationRecord()
    {
        return $this->hasOne(Locations::className(), ['id' => 'location']);
    }

    public function getSubLocationRecord()
    {
        return $this->hasOne(Locations::className(), ['id' => 'sub_location']);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function getStatuses()
    {
        $statusArr[self::STATUS_OPEN]          = Yii::t('app', 'Open');
        $statusArr[self::STATUS_CLOSED]        = Yii::t('app', 'Closed');
        $statusArr[self::STATUS_NOT_SPECIFIED] = Yii::t('app', 'Not specified');
        return $statusArr;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function getImportStatuses()
    {
        $importStatusArr[self::IMPORTED]     = Yii::t('app', 'Imported');
        $importStatusArr[self::IMPORTED_NOT] = Yii::t('app', 'Not imported');
        return $importStatusArr;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function getPriorities()
    {
        $priorityArr[self::PRIORITY_URGENT] = Yii::t('app', 'Urgent');
        $priorityArr[self::PRIORITY_HIGH]   = Yii::t('app', 'High');
        $priorityArr[self::PRIORITY_NORMAL] = Yii::t('app', 'Normal');
        $priorityArr[self::PRIORITY_LOW]    = Yii::t('app', 'Low');
        return $priorityArr;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getFinanceType($id = null)
    {
        if ($id == null) {
            switch ($this->finance_type) {
                case self::FINANCE_TYPE_CASH:
                    return Yii::t('app', 'Cash');
                case self::FINANCE_TYPE_LOAN_APPROVED:
                    return Yii::t('app', 'Loan (approved)');
                case self::FINANCE_TYPE_LOAN_NOT_APPROVED:
                    return Yii::t('app', 'Loan (not approved)');
            }
        } else {
            switch ($id) {
                case self::FINANCE_TYPE_CASH:
                    return Yii::t('app', 'Cash');
                case self::FINANCE_TYPE_LOAN_APPROVED:
                    return Yii::t('app', 'Loan (approved)');
                case self::FINANCE_TYPE_LOAN_NOT_APPROVED:
                    return Yii::t('app', 'Loan (not approved)');
            }
        }

    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function getFinanceTypes()
    {
        $financeTypesArr[self::FINANCE_TYPE_CASH]              = Yii::t('app', 'Cash');
        $financeTypesArr[self::FINANCE_TYPE_LOAN_APPROVED]     = Yii::t('app', 'Loan (approved)');
        $financeTypesArr[self::FINANCE_TYPE_LOAN_NOT_APPROVED] = Yii::t('app', 'Loan (not approved)');
        return $financeTypesArr;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getStatus()
    {
        switch ($this->status) {
            case self::STATUS_OPEN:
                return Yii::t('app', 'Open');
            case self::STATUS_CLOSED:
                return Yii::t('app', 'Closed');
            case self::STATUS_NOT_SPECIFIED:
                return Yii::t('app', 'Not Specified');
        }
    }

    public function getOrigin()
    {
        return ($this->origin) ? self::$origins[$this->origin] : '';
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getPriority($id = null)
    {
        if ($id == null) {
            switch ($this->priority) {
                case self::PRIORITY_URGENT:
                    return Yii::t('app', 'Urgent');
                case self::PRIORITY_HIGH:
                    return Yii::t('app', 'High');
                case self::PRIORITY_NORMAL:
                    return Yii::t('app', 'Normal');
                case self::PRIORITY_LOW:
                    return Yii::t('app', 'Low');
            }
        } else {
            switch ($id) {
                case self::PRIORITY_URGENT:
                    return Yii::t('app', 'Urgent');
                case self::PRIORITY_HIGH:
                    return Yii::t('app', 'High');
                case self::PRIORITY_NORMAL:
                    return Yii::t('app', 'Normal');
                case self::PRIORITY_LOW:
                    return Yii::t('app', 'Low');
            }
        }

    }

    /**
     * Undocumented function
     *
     * @param $insert
     * @param $changedAttributes
     * @return void
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        LeadSocialMediaContact::deleteAll(['lead_id' => $this->id]);
        $decodedText = html_entity_decode($this->socialMediaContacts);
        $leadSocialMediaContacts = json_decode($decodedText);
        foreach ($leadSocialMediaContacts as $leadSocialMediaContact) {
            if ($leadSocialMediaContact->type && $leadSocialMediaContact->link) {
                $leadSocialMediaContactModel = new LeadSocialMediaContact();
                $leadSocialMediaContactModel->lead_id = $this->id;
                $leadSocialMediaContactModel->type = $leadSocialMediaContact->type;
                $leadSocialMediaContactModel->link = $leadSocialMediaContact->link;
                $leadSocialMediaContactModel->save();
            }
        }

        LeadAdditionalEmail::deleteAll(['lead_id' => $this->id]);
        $additionalEmailsdecodedText = html_entity_decode($this->additionalEmails);
        $additionalEmails = json_decode($additionalEmailsdecodedText);
        foreach ($additionalEmails as $additionalEmail) {
            if (!empty($additionalEmail) && (filter_var($additionalEmail, FILTER_VALIDATE_EMAIL))) {
                $additionalEmailModel = new LeadAdditionalEmail();
                $additionalEmailModel->lead_id = $this->id;
                $additionalEmailModel->email = $additionalEmail;
                $additionalEmailModel->save();
            }
        }

        LeadNote::deleteAll(['lead_id' => $this->id]);
        $notesDecodedText = html_entity_decode($this->notesAttr);
        $notes = json_decode($notesDecodedText);
        foreach ($notes as $note) {
            if (!empty($note)) {
                $newNote = new LeadNote();
                $newNote->lead_id = $this->id;
                $newNote->text = $note;
                if ($newNote->save()) {} else { print_r($newNote->getErrors()); die(); }
            }
        }

        LeadAgent::deleteAll(['lead_id' => $this->id]);
        $agentsDecodedText = html_entity_decode($this->agents);
        $agents = json_decode($agentsDecodedText);
        foreach ($agents as $agent) {
            if (!empty($agent)) {
                $agentModel = new LeadAgent();
                $agentModel->lead_id = $this->id;
                $agentModel->user_id = $agent;
                $agentModel->save();
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'required'],
            [['email', 'mobile_number'], 'atLeastOne', 'skipOnEmpty' => false, 'skipOnError' => false],
            [['company_id', 'agents', 'email_opt_out', 'phone_opt_out'], 'safe'],
            [['agent_1', 'agent_2', 'agent_3', 'agent_4', 'agent_5'], 'safe'],
            [['latitude', 'longitude'], 'number'],
            [
                [
                    'activity', 
                    'type_id', 
                    'status', 
                    'sub_status_id', 
                    'priority', 
                    'category_id', 
                    'source', 
                    'created_by_user_id',
                    /*'company_id', */
                    'finance_type', 
                    'updated_time',
                    'origin'
                ], 'integer'
            ],
            [['max_price'], 'number'],
            [['email'], 'email'],
            [
                [
                    'hot_lead', 
                    'emirate', 
                    'shared_leads', 
                    'agent_referrala', 
                    'listing_ref', 
                    'socialMediaContacts', 
                    'additionalEmails', 
                    'reference', 
                    'enquiry_time', 
                    'activity',
                    'location',
                    'sub_location',
                    'created_at'
                ], 'safe'
            ],
            [['reference'], 'string', 'max' => 20],
            [['first_name', 'last_name', 'contract_company', 'email'], 'string', 'max' => 100],
            [['mobile_number'], 'string', 'max' => 30],
            // [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [
                ['created_by_user_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => User::className(),
                'targetAttribute' => ['created_by_user_id' => 'id']
            ],
            [
                ['sub_status_id'], 
                'exist', 
                'skipOnError'     => true, 
                'targetClass'     => LeadSubStatus::className(), 
                'targetAttribute' => ['sub_status_id' => 'id']
            ],
            [
                [
                    'reminder', 
                    'notesAttr', 
                    'max_beds', 
                    'min_beds', 
                    'max_price', 
                    'min_price', 
                    'min_area', 
                    'max_area'
                ], 'safe'
            ]
        ];
    }

    public function atLeastOne($attribute)
    {
        if (empty($this->email)
            && empty($this->mobile_number)) {
            $this->addError($attribute, Yii::t('app', 'At least 1 of the field must be filled up properly'));

            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                  => Yii::t('app', 'ID'),
            'reference'           => Yii::t('app', 'Reference'),
            'status'              => Yii::t('app', 'Status'),
            'sub_status_id'       => Yii::t('app', 'Sub Status'),
            'priority'            => Yii::t('app', 'Priority'),
            'first_name'          => Yii::t('app', 'First Name'),
            'last_name'           => Yii::t('app', 'Last Name'),
            'mobile_number'       => Yii::t('app', 'Mobile Number'),
            'category_id'         => Yii::t('app', 'Category'),
            'location'            => Yii::t('app', 'Location'),
            'sub_location'        => Yii::t('app', 'Sub Location'),
            'unit_type'           => Yii::t('app', 'Unit Type'),
            'unit_number'         => Yii::t('app', 'Unit Number'),
            'max_beds'            => Yii::t('app', 'Max beds'),
            'min_beds'            => Yii::t('app', 'Min beds'),
            'max_price'           => Yii::t('app', 'Max price'),
            'min_price'           => Yii::t('app', 'Min price'),
            'max_area'            => Yii::t('app', 'Max area'),
            'min_area'            => Yii::t('app', 'Min area'),
            'source'              => Yii::t('app', 'Source'),
            'created_by_user_id'  => Yii::t('app', 'Created By'),
            'company_id'          => Yii::t('app', 'Company'),
            'finance_type'        => Yii::t('app', 'Finance Type'),
            'enquiry_time'        => Yii::t('app', 'Enquiry Time'),
            'updated_time'        => Yii::t('app', 'Updated Time'),
            'contract_company'    => Yii::t('app', 'Contract Company'),
            'email'               => Yii::t('app', 'Email'),
            'type_id'             => Yii::t('app', 'Type'),
            'additionalEmails'    => Yii::t('app', 'Additional Emails'),
            'socialMediaContacts' => Yii::t('app', 'Social Media Contacts'),
            'email_opt_out'       => Yii::t('app', 'Email Opt-Out'),
            'phone_opt_out'       => Yii::t('app', 'Phone Opt-Out'),
            'is_imported'         => Yii::t('app', 'Import from Propspace'),
            'latitude'            => Yii::t('app', 'Latitude'),
            'longitude'           => Yii::t('app', 'Longitude'),
            'created_at'          => Yii::t('app', 'Created At'),
            'origin'              => Yii::t('app', 'Origin'),
        ];
    }

    public function getAttributesForDetailView()
    {
        $attributes = [];
        if ($this->type_id)
            $attributes[] = ['attribute' => 'type_id', 'value' => $this->getType()];
        if ($this->status)
            $attributes[] = ['attribute' => 'status', 'value' => $this->getStatus()];
        if ($this->sub_status_id)
            $attributes[] = ['attribute' => 'sub_status_id', 'value' => $this->subStatus->title];

        if ($this->priority)
            $attributes[] = ['attribute' => 'priority', 'value' => $this->getPriority()];

        if ($this->hot_lead)
            $attributes[] = ['attribute' => 'hot_lead', 'value' => $this->hot_lead];

        if ($this->source)
            $attributes[] = ['attribute' => 'source', 'value' => $this->contactSource->source];

        if ($this->listing_ref)
            $attributes[] = ['attribute' => 'listing_ref', 'value' => $this->listing_ref];

        if ($this->created_by_user_id)
            $attributes[] = ['attribute' => 'created_by_user_id', 'value' => $this->getCreatedUserFullname()];

        if ($this->agent_1)
            $attributes[] = ['attribute' => 'agent_1', 'value' => $this->agent_1];

        if ($this->agent_2)
            $attributes[] = ['attribute' => 'agent_2', 'value' => $this->agent_2];

        if ($this->agent_3)
            $attributes[] = ['attribute' => 'agent_3', 'value' => $this->agent_3];

        if ($this->agent_4)
            $attributes[] = ['attribute' => 'agent_4', 'value' => $this->agent_4];

        if ($this->agent_5)
            $attributes[] = ['attribute' => 'agent_5', 'value' => $this->agent_5];

        if ($this->finance_type)
            $attributes[] = ['attribute' => 'finance_type', 'value' => $this->getFinanceType()];

        if ($this->enquiry_time)
            $attributes[] = ['attribute' => 'enquiry_time', 'value' => date('Y-m-d H:i', $this->enquiry_time)];

        if ($this->updated_time)
            $attributes[] = ['attribute' => 'updated_time', 'value' => date('Y-m-d H:i', $this->updated_time)];

        if ($this->contract_company)
            $attributes[] = ['attribute' => 'contract_company', 'value' => $this->contract_company];

        if ($this->agent_referrala)
            $attributes[] = ['attribute' => 'agent_referrala', 'value' => $this->agentReferral->username];

        if ($this->shared_leads)
            $attributes[] = ['attribute' => 'shared_leads', 'value' => $this->shared_leads];

        if ($this->additionalEmails) {
            $additionalEmailsList = '<ul style="list-style: none">';
            foreach ($this->additionalEmails as $additionalEmails)
                $additionalEmailsList .=   '<li>' .
                    $additionalEmails->email . '</li>';
            $additionalEmailsList .=   '</ul>';
            $attributes[] = ['label'  => Yii::t('app', 'Additional Emails'), 'format' => 'raw', 'value' => $additionalEmailsList];
        }

        if($this->socialMediaContacts) {
            $socialMediaContactsList = '<ul style="list-style: none">';
            foreach ($this->socialMediaContacts as $socialMediaContact) {
                $socialMediaContactsList .= '<li>' .
                    Html::a(FA::icon($socialMediaContact->getBtnClass()), $socialMediaContact->link, ['target' => '_blank']) . '</li>';
            }
            $socialMediaContactsList .= '</ul>';
            $attributes[] = ['label'  => Yii::t('app', 'Social Media Contacts'), 'format' => 'raw', 'value' => $socialMediaContactsList];
        }

        if ($this->agents) {
            $leadAgentsList = '<ul style="list-style: none">';
            foreach ($this->agents as $leadAgent) {
                $leadAgentsList .= '<li>' . $leadAgent->agent->username . '</li>';
            }
            $leadAgentsList .= '</ul>';
            $attributes[] = ['label'  => Yii::t('app', 'Agents'), 'format' => 'raw', 'value' => $leadAgentsList];
        }

        return $attributes;
    }

    public static function getColumns($userCreatedFilter)
    {
        $companyId = Company::getCompanyIdBySubdomain();

        return [
            'mobile_number' => [
                'attribute' => 'mobile_number',
                'value' => 'mobile_number',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            'listing_ref' => [
                'attribute' => 'listing_ref',
                'value' => 'listing_ref',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            'created_by_user_id' => [
                'attribute' => 'created_by_user_id',
                'value' => 'createdByUser.username',
                'filter' => $userCreatedFilter,
                'headerOptions' => ['style' => 'min-width:150px;'],
            ],
            'finance_type' => [
                'attribute' => 'finance_type',
                'value' => function ($model) {
                        return $model->getFinanceType();
                    },
                'filter' => Leads::getFinanceTypes(),
                'headerOptions' => ['style' => 'min-width:150px;'],
            ],
            'enquiry_time' => [
                'attribute' => 'enquiry_time',
                'value' => function ($model, $index, $widget) {
                    if ($model->enquiry_time) {
                        return Yii::$app->formatter->asDate($model->enquiry_time); //"short", "medium", "long", or "full"
                    } else {
                        return '';
                    }
                },
                'format' => 'date',
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ]
                ],
                'headerOptions' => ['style' => 'min-width:200px;'],
                'hAlign' => 'center',
            ],
            'updated_time' => [
                'attribute' => 'updated_time',
                'value' => function ($model, $index, $widget) {
                    return Yii::$app->formatter->asDate($model->updated_time);
                },
                'format' => 'date',
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ]
                ],
                'headerOptions' => ['style' => 'min-width:200px;'],
                'hAlign' => 'center',
            ],
            'contract_company' => [
                'attribute' => 'contract_company',
                'value' => 'contract_company',
                'headerOptions' => ['style' => 'min-width:140px;'],
            ],
            'email' => [
                'attribute' => 'email',
                'value' => 'email',
                'format' => 'email',
                'headerOptions' => ['style' => 'min-width:140px;'],
            ],
            'email_opt_out' => [
                'attribute' => 'email_opt_out',
                'value' => function ($model, $index, $widget) {
                        if ($model->email_opt_out)
                            $email_opt_out = Yii::t('app', 'yes');
                        else
                            $email_opt_out = '';
                        return $email_opt_out;
                    },
            ]
        ];
    }

    //todo add company id everywhere
    public static function searchBy($value)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->andWhere([
                    'l.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->andWhere([
                        'l.company_id' => $companyId
                    ])->andWhere(['l.created_by_user_id' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->andWhere([
                        'l.company_id' => $companyId
                    ])->andWhere(['l.created_by_user_id' => Yii::$app->user->id]);
                }
            }
        }

        return $query->select([
            'l.reference',
            'l.id',
            'l.first_name',
            'l.last_name',
            'l.mobile_number',
            'l.company_id',
            'l.created_by_user_id'
        ])
            ->from(Leads::tableName() . ' l')
            ->andWhere(['or',
                ['like', 'l.first_name', $value],
                ['like', 'l.last_name', $value],
                ['like', 'l.reference', $value],
                ['like', 'l.mobile_number', $value]
            ])
            ->all();
    }

    public static function getByReference($reference)
    {
        return self::findOne(['reference' => $reference]);
    }

    /**
     * @param $listingRef
     * @return mixed
     */
    public static function getByListingRef($listingRef)
    {
        return Leads::findAll(['listing_ref' => $listingRef]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getLeadType()
    {
        return $this->hasOne(LeadType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeadAgents()
    {
        return $this->hasMany(LeadAgent::className(), ['lead_id' => 'id']);
    }

    public function getAgentReferral()
    {
        return $this->hasOne(User::className(), ['id' => 'agent_referrala']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeadProperties()
    {
        return $this->hasMany(LeadProperty::className(), ['lead_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeadViewings()
    {
        return $this->hasMany(LeadViewing::className(), ['lead_id' => 'id']);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getAdditionalEmailsList()
    {
        return $this->hasMany(LeadAdditionalEmail::className(), ['lead_id' => 'id']);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getNotesList()
    {
        return $this->hasMany(LeadNote::className(), ['lead_id' => 'id']);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getLeadSocialMeadiaContacts()
    {
        return $this->hasMany(LeadSocialMediaContact::className(), ['lead_id' => 'id']);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getContactNote()
    {
        return $this->hasMany(Note::className(), ['ref' => 'reference']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by_user_id'])->from(User::tableName() . ' u2');;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getCreatedByUserProfile()
    {
        return $this->hasOne(UserProfile::class, ['id' => 'user_id'])->via('createdByUser');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanySource()
    {
        return $this->hasOne(CompanySource::className(), ['id' => 'source']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubStatus()
    {
        return $this->hasOne(LeadSubStatus::className(), ['id' => 'sub_status_id']);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getCategory()
    {
        return $this->hasOne(PropertyCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContactSource()
    {
        return $this->hasOne(ContactSource::class, ['id' => 'source']);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getPropertyRequirements()
    {
        return $this->hasMany(PropertyRequirement::className(), ['lead_id' => 'id']);
    }

    public static function find()
    {
        return parent::find()->with('agentReferral');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getCreatedUserFullname()
    {
        if ($this->createdByUser->userProfile)
            return $this->createdByUser->userProfile->getFullname();
        else return '';
    }

    public static function getBySlug($slug)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();
        $query = self::find()->where(['slug' => $slug]);

        if ($companyId == 'main' or $companyId == 0) {
        } else {
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->andWhere([
                    'company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->andWhere([
                        'company_id' => $companyId
                    ])->andWhere(['created_by_user_id' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->andWhere([
                        'company_id' => $companyId
                    ])->andWhere(['created_by_user_id' => Yii::$app->user->id]);
                }
            }
        }

        return $query->one();
    }


    /**
     *
     * This method returns the first record of model Leads
     * 
     * @param  string $id
     * @return iterable
     */
    public function getFirstRecordModel(?string $id = null): ?iterable
    {
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == '') {
            if (!$id) {
                empty(self::find()->one()) ? $firstRecord = $this : $firstRecord = self::find()->one();
            } else {
                $firstRecord = self::find()->where([
                    'id'         => $id
                ])->one();
            }
        } else {
            if ((new OwnerManageGroup())->getViewsByGroup()) {
                if (Yii::$app->controller->action->id === 'index') {                  
                    self::find()->where([
                        'company_id'         => $companyId,
                        'created_by_user_id' => (new OwnerManageGroup())->getViewsByGroup()
                    ])->one() ?
                        $firstRecord = self::find()->where([
                            'company_id'         => $companyId,
                            'created_by_user_id' => (new OwnerManageGroup())->getViewsByGroup()
                        ])->one() 
                        : $firstRecord = $this;
                } else {
                    self::find()->where([
                        'id'         => $id,
                        'company_id' => $companyId
                    ])->one() ?
                        $firstRecord = self::find()->where([
                            'id'         => $id,
                            'company_id' => $companyId
                        ])->one()
                        : $firstRecord = $this;
                }
            } else {
                if (Yii::$app->controller->action->id === 'index') {
                    
                    self::find()->where([
                        'company_id'         => $companyId,
                        'created_by_user_id' => Yii::$app->user->id
                    ])->one() ?
                        $firstRecord = self::find()->where([
                            'company_id'         => $companyId,
                            'created_by_user_id' => Yii::$app->user->id
                        ])->one() 
                        : $firstRecord = $this;
                } else {
                    self::find()->where([
                        'id'         => $id,
                        'company_id' => $companyId
                    ])->one() ?
                        $firstRecord = self::find()->where([
                            'id'         => $id,
                            'company_id' => $companyId
                        ])->one()
                        : $firstRecord = $this;
                }
            }
        }

        return $firstRecord;
    }

}
