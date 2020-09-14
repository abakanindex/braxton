<?php

namespace app\models;

use app\widgets\JavascriptConsole;
use Yii;
use app\classes\SubdomainDirectory;
use app\modules\profileCompany\models\ProfileCompany;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string $company_name
 * @property int $employees_quantity
 * @property int $owner_user_id
 * @property int $status
 * @property int $payment_status
 * @property int $payment_plan
 * @property int $userStatus
 * @property string $token
 */
class Company extends \yii\db\ActiveRecord
{
    public static $subDomain;

    public $userStatus;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employees_quantity', 'owner_user_id', 'status', 'payment_status', 'payment_plan'], 'integer'],
            [['company_name'], 'string', 'max' => 100],
            [['token'], 'string'],
            [['company_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => 'Company Name',
            'employees_quantity' => 'Employees Quantity',
            'owner_user_id' => 'Owner User ID',
            'status' => 'Status',
            'payment_status' => 'Payment Status',
            'payment_plan' => 'Payment Plan',
            'user.status' => 'User status',
            'token'       => 'Token'
        ];
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'owner_user_id']);
    }

    public static function getToken($companyName)
    {
        return uniqid($companyName . '_', true);
    }

    public static function isSubdomainUsed()
    {
        if (SUBDOMAIN_NAME === null) {
            return 'main';
        }
        return SUBDOMAIN_NAME;
    }

    public static function getCompanyIdBySubdomain()
    {
        if (self::isSubdomainUsed() == 'main') {
            return 'main';
        }
        return static::findOne(['company_name' => SUBDOMAIN_NAME])->id;
    }

    public static function getCompanyToken()
    {
        return (self::isSubdomainUsed() == 'main') ? '' : static::findOne(['company_name' => SUBDOMAIN_NAME])->token;
    }

    public static function getCompanyByToken($token)
    {
        return static::findOne(['token' => $token]);
    }

    public static function getCompanyBySubdomain()
    {
        if (self::isSubdomainUsed() == 'main') {
            return 'main';
        }
        return static::findOne(['company_name' => SUBDOMAIN_NAME]);
    }

    public static function createViewPath()
    {
        $subDomain = self::isSubdomainUsed();
        if (!Company::findOne(['company_name' => $subDomain])) {
            return 'company not found';
        }
        SubdomainDirectory::createDirectory($subDomain);
        copy(DOCUMENT__ROOT . '/views/site/index.php',
            DOCUMENT__ROOT . '/views/COMPANIES/' . $subDomain . '/index.php');
        return '@app/views/COMPANIES/' . $subDomain;
    }

    public static function getCompanyName()
    {
        $company = self::getCompanyBySubdomain();
        if ($company->company_name) {
            return $company->company_name;
        } else {
            return 'main';
        }
    }

    public static function getCompanyNameWithProfile()
    {
        $company = self::getCompanyBySubdomain();
        $profileCompany = ProfileCompany::findOne(['company_id' => $company->id]);
        if ($profileCompany && $result = $profileCompany->prefix) {
            return $result;
        } elseif ($result = $company->company_name) {
            return $result;
        } else {
            return 'main';
        }
    }

    public function afterSave($insert, $attributes)
    {
        parent::afterSave($insert, $attributes);

        if (!$user = User::findOne(['id' => $this->owner_user_id])) {
            return false;
        }
        $user->company_id = $this->id;
        return $user->save();
    }

    public function setOwner($userId)
    {
        $this->owner_user_id = $userId;
        $this->save();
    }
}
