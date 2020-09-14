<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 04.10.2017
 * Time: 19:04
 */

namespace app\models\registration;
use app\modules\admin\models\AuthItem;


use Yii;
use yii\base\Model;
use app\models\User;
use app\models\Company;
use yii\rest\Controller;


class RegisterCompanyForm extends Model
{

    public $company_name;
    public $employees_quantity;

    const DEFAULT_PAYMENT_PLAN = 0;
    const DEFAULT_PAYMENT_STATUS = 0;
    const DEFAULT_STATUS_DISABLED = 0;
    const DEFAULT_STATUS_ACTIVE = 1;

    public $company;

    public function rules()
    {
        return [

            ['company_name', 'trim'],
            ['company_name', 'required'],
            ['company_name', 'unique', 'targetClass' => 'app\models\Company', 'message' => 'This company name has already been taken.'],
            ['company_name', 'string', 'min' => 2, 'max' => 255],

            ['employees_quantity', 'integer'],

        ];
    }

    public function registerCompany()
    {
        $this->company = new Company();
        $this->company->company_name = $this->company_name;
        $this->company->employees_quantity = $this->employees_quantity;
        $this->company->owner_user_id = Yii::$app->user->getId();
        $this->company->payment_plan = self::DEFAULT_PAYMENT_PLAN;
        $this->company->payment_status = self::DEFAULT_PAYMENT_STATUS;
        $this->company->status = self::DEFAULT_STATUS_DISABLED;
        $this->company->token  = Company::getToken($this->company_name);

        if (!$this->company->save()) {

            return null;
        }

        $auth = Yii::$app->authManager;
        $role = $auth->getRole('Owner');
        
        $rows = [
            [
                'name' => 'Admin',
                'type' => '1',
                'company_id' => $this->company->id
            ],
            [
                'name' => 'Agent',
                'type' => '1',
                'company_id' => $this->company->id
            ],
            [
                'name' => 'Department Leader',
                'type' => '1',
                'company_id' => $this->company->id
            ],
            [
                'name' => 'Executive Agent',
                'type' => '1',
                'company_id' => $this->company->id
            ],
            [
                'name' => 'Manager',
                'type' => '1',
                'company_id' => $this->company->id
            ],
        ];

        Yii::$app->db->createCommand()
        ->batchInsert(AuthItem::tableName(), ['name', 'type', 'company_id'], $rows)
        ->execute();


        if($auth->assign($role, Yii::$app->user->getId())) {
            Yii::$app->session->setFlash('ownerAssign', 'User assigned');
        }

        return $this->company;
    }







}