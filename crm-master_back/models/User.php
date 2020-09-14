<?php

namespace app\models;

use app\components\rbac\Assignment;
use app\models\admin\rights\AuthAssignment;
use app\widgets\JavascriptConsole;
use developeruz\db_rbac\interfaces\UserRbacInterface;
use Yii;
use yii\base\ErrorException;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\caching\ArrayCache;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $job_title
 * @property string $office_no
 * @property string $country_dialing
 * @property string $mobile_no
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $country
 * @property string $auth_key
 * @property string $activation
 * @property string $phone_number
 * @property integer $status
 * @property integer $role
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property int $company_id
 * @property string $department
 * @property string $rera
 * @property double $rental_commission
 * @property double $sales_commission
 * @property string $agent_signature
 * @property string $agent_bio
 * @property string $img_user_profile
 * @property string $img_contact_overlay
 * @property string $video_profile_name
 * @property string $video_profile_path
 * @property string $language
 * @property string $imap
 * @property string $imap_email
 * @property string $imap_password
 * @property string $imap_port
 * @property int $imap_enabled
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $file_user_profile;
    public $file_contact_overlay;
    public $file_video_profile;
    public $countDeals;
    public $userCategoriesData;

    const STATUS_DISABLED = 2;
    const STATUS_ACTIVE = 1;
    const STATUS_BANNED = 3;
    const STATUS_SUPERADMIN = 99;

    const ROLE_AGENT = 'Agent';

    public static $companyId;

    public function beforeSave($insert)
    {
        if (Yii::$app->controller->id !== 'registration'
            && Yii::$app->controller->action->id !== 'signup-user'
            && Yii::$app->controller->action->id !== 'reset-password'
        ) {
            if ($this->isNewRecord) {
                //for new record
                $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($this->password_hash);
            } else if (!$this->password_hash) {
                //if record exist and new password is empty, we will save old
                $user = User::findOne($this->id);
                $this->password_hash = $user->password_hash;
            } else if ($this->password_hash) {
                //if record exist and new password is not empty, we will save it
                $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($this->password_hash);
            }
        }

        return parent::beforeSave($insert);
    }

    private function getCompanyQueryUser()
    {
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
            $query = self::find();
        } else {
            $query = self::find()->where([
                'company_id' => $companyId
            ]);
        }

        $query->orderBy('username ASC');

        return $query;
    }

    public function getByRole($role)
    {
        $query = $this->getCompanyQueryUser();
        $query->andWhere(['role' => $role]);
        return $query->all();
    }

    public function getAllCompanyUsers()
    {
        $query = $this->getCompanyQueryUser();
        return $query->all();
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotes()
    {
        return $this->hasMany(Note::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocuments()
    {
        return $this->hasMany(Document::className(), ['user_id' => 'id']);
    }

    public function getUserCategories()
    {
        return $this->hasMany(UserCategories::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'job_title' => 'Job Title',
            'office_no' => 'Office No',
            'country_dialing' => 'Country Dialing',
            'mobile_no' => 'Mobile No',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'role' => 'Role',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'activation' => 'Activation',
            'phone_number' => 'Phone Number',
            'country' => 'Country',
            'company_id' => 'Company ID',
            'create_by_user_id' => 'Create by user id ID',
            'department' => 'Department',
            'rera' => 'Rera',
            'rental_commission' => 'Rental Commission',
            'sales_commission' => 'Sales Commission',
            'agent_signature' => 'Agent Signature',
            'agent_bio' => 'User Bio',
            'img_user_profile' => 'Img User Profile',
            'img_contact_overlay' => 'Img Contact Overlay',
            'language' => 'Language',
            'imap' => 'Imap',
            'imap_email' => 'Imap Email',
            'imap_password' => 'Imap Password',
            'imap_port' => 'Imap Port',
            'imap_enabled' => 'Imap Enabled',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => 2],
            [['username', 'first_name', 'last_name', 'job_title', 'office_no', 'country_dialing', 'mobile_no',
                'password_hash', 'password_reset_token', 'email',
                'role', 'activation', 'country', 'department',
                'rera', 'agent_signature', 'img_user_profile', 'img_contact_overlay',
                'video_profile_name', 'video_profile_path', 'language', 'imap', 'imap_email', 'imap_password', 'imap_port'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['password_reset_token', 'email', 'username'], 'unique'],
            ['email', 'email', ],
            [['username', 'email'], 'required'],
            [['status', 'created_at', 'updated_at', 'phone_number', 'company_id', 'imap_enabled'], 'integer'],
            [['rental_commission', 'sales_commission'], 'number'],
            ['role', 'default', 'value' => 'guest'],
            [['agent_bio', 'role'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $user = static::findOne([
            'id' => $id
        ]);
        $companyId = Company::getCompanyIdBySubdomain();
        if ($companyId !== 'main') {
            switch ($user->status) {
                case ($user->status == 1):
                    return $user->company_id == $companyId ? $user : null;
                    break;
                case($user->status == 99):
                    return $user;
                    break;
                case($user->status !== 1 && $user->status !== 99):
                    if ($user->status == 2)
                        throw new \yii\base\Exception('Sorry but your account is disabled.');
                    if ($user->status == 3)
                        throw new \yii\base\Exception('Sorry, but your account is banned');
                    break;
            }
        } else {
            if ($user->status !== 99 && strpos(Yii::$app->request->url, 'registration') == false)
                throw new \yii\base\Exception('Sorry, you don`t have permission to this page.');
            return $user;
        }
    }

    public function getFirstRecordModel($id = null)
    {
        if ($id) {
            $firstRecord = self::find()->where(['id' => $id])->one();
        } else {
            $firstRecord = empty(self::find()->one()) ? $this : self::find()->one();
        }

        return $firstRecord;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function getByUsername($username)
    {
        return User::findOne([
            'username' => $username
        ]);
    }

    public static function getUserEnableImap()
    {
        return User::find()->where(['imap_enabled' => 1])->with('emailImportLead')->all();
    }

    /**
     * @param $username
     * @return null|static
     * @throws \yii\base\Exception
     */
    public static function findByUsername($username)
    {
        $user = static::findOne([
            'username' => $username
        ]);
        $companyId = Company::getCompanyIdBySubdomain();
        if ($companyId !== 'main') {
            switch ($user->status) {
                case ($user->status == 1):
                    return $user->company_id == $companyId ? $user : null;
                    break;
                case($user->status == 99):
                    return $user;
                    break;
                case($user->status !== 1 && $user->status !== 99):
                    if ($user->status == 2)
                        throw new \yii\base\Exception('Sorry but your account is disabled.');
                    if ($user->status == 3)
                        throw new \yii\base\Exception('Sorry, but your account is banned');
                    break;
            }
        } else {
            if ($user->status !== 99) {
                $companyName = Company::find()
                    ->select(['company_name'])
                    ->where(['id' => $user->company_id])
                    ->asArray()
                    ->one();
                Yii::$app->response->redirect(
                    'http://' . $companyName['company_name'] . '.' . Yii::$app->request->serverName
                );
            } else {
                return $user;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function getEmailImportLead()
    {
        return $this->hasOne(EmailImportLead::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @param $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * generate email check key
     */
    public function generateActivationKey()
    {
        return $this->activation = Yii::$app->security->generateRandomString();
    }

    /**
     * @param $activation_key
     * @return null|static
     */
    public static function getByActivationKey($activation_key)
    {
        return static::findOne(['activation' => $activation_key, 'status' => self::STATUS_DISABLED]);
    }

    public function getCompanyName()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

    public function getUserStatus()
    {
        return $this->hasOne(UserStatus::className(), ['id' => 'status']);
    }

    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['country_id' => 'country']);
    }

    public function getAuthAssignment()
    {
        return $this->hasOne(AuthAssignment::className(), ['user_id' => 'id', 'company_id' => 'company_id']);
    }

    public function getUserName()
    {
        return $this->username;
    }

    public function setStatusActive()
    {
        $this->status = User::STATUS_ACTIVE;
        $this->save();
    }

    public static function isOwner($userId)
    {
        return Company::find()->where(['owner_user_id' => $userId])->all() ? true : null;
    }

    public function changeRole($id)
    {
        $auth = Yii::$app->authManager;
        $auth->revokeAll($id);

        $role = $auth->getRole($this->role);
        return $auth->assign($role, $id);
    }

    public function sendInvite()
    {
        if (!$this->isNewRecord) {
            return null;
        }
        return Yii::$app->mailer->compose()
            ->setFrom('no-reply@crm')
            ->setTo($this->email)
            ->setSubject('Crm invite')
            ->setTextBody(Html::a('Hello, click here to create account in ' . Company::getCompanyName() . ' company',
                'http://crm/web/registration/email-confirm?activation=' . $this->user->activation))
            ->send();
    }

    public static function findByEmail($email)
    {
        return self::find()->where(['email' => $email])->one();
    }

    public function saveUserCategory($categoryId)
    {
        $userCategory = new UserCategories();
        $userCategory->category_id = $categoryId;
        $userCategory->user_id     = $this->id;
        $userCategory->save();
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['number']);
    }

    public static function find()
    {
        return parent::find()
            ->with('companyName');
    }

    /**
     * @return array|ActiveRecord[]
     */
    public static function getUsers()
    {
        $companyId = Company::getCompanyIdBySubdomain();
        if ($companyId == 'main' or $companyId == 0) {
            $query = User::find();
        } else {
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query = User::find()->where([
                    'company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {

                    $query = User::find()->where([
                        'company_id' => $companyId
                    ])->andWhere(['id' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query = User::find()->where([
                        'company_id' => $companyId
                    ])->andWhere(['id' => Yii::$app->user->id]);
                }
            }
        }

        return $query->all();
    }
}
