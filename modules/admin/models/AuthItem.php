<?php

namespace app\modules\admin\models;

use Yii;
use app\models\Company;
use app\modules\admin\models\AuthItemChild;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property string $type
 * @property string $description
 * @property string $rule_name
 * @property resource $data
 * @property string $created_at
 * @property int $updated_at
 * @property int $company_id
 */
class AuthItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'company_id'], 'required'],
            [['description', 'data'], 'string'],
            [['updated_at', 'company_id'], 'integer'],
            [['name', 'type', 'rule_name', 'created_at'], 'string', 'max' => 255],
            [['name', 'company_id'], 'unique', 'targetAttribute' => ['name', 'company_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name'        => Yii::t('app', 'Name'),
            'type'        => Yii::t('app', 'Type'),
            'description' => Yii::t('app', 'Description'),
            'rule_name'   => Yii::t('app', 'Rule Name'),
            'data'        => Yii::t('app', 'Data'),
            'created_at'  => Yii::t('app', 'Created At'),
            'updated_at'  => Yii::t('app', 'Updated At'),
            'company_id'  => Yii::t('app', 'Company ID'),
        ];
    }

    /**
     *
     * This method returns the first record of model Sale
     * 
     * @param  string $id
     * @return iterable
     */
    public function getFirstRecordModel(?string $name = null): ?iterable
    {
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == '') {
            if (!$name) {
                empty(self::find()->one()) ? $firstRecord = $this : $firstRecord = self::find()->one();
            } else {
                $firstRecord = self::findOne($name);
            }
        } else {
            if (
                    Yii::$app->controller->action->id === 'manage-role' 
            ) {
                self::find()->where([
                        'company_id' => $companyId
                ])->one() ?
                    $firstRecord = self::find()->where([
                        'company_id' => $companyId
                    ])->one() 
                    : $firstRecord = $this;
            } else {
                $firstRecord = self::find()->where([
                    'name'       => $name,
                    'company_id' => $companyId
                ])->one();
            }
        }

        return $firstRecord;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function setPermissions($modelRoleForm)
    {
        $companyId = Company::getCompanyIdBySubdomain();
        $addPermissModel = new AuthItemChild();
        $rows = [];


        if ($modelRoleForm->leadscreate) {

            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->leadscreate);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }

        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('leadsCreate');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'leadsCreate', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'leadsCreate', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->leadsdelete) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->leadsdelete);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('leadsDelete');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'leadsDelete', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'leadsDelete', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->leadsupdate) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->leadsupdate);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('leadsUpdate');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'leadsUpdate', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'leadsUpdate', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->leadsview) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->leadsview);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('leadsView');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'leadsView', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'leadsView', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->contactscreate) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->contactscreate);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('contactsCreate');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'contactsCreate', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'contactsCreate', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->contactsdelete) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->contactsdelete);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('contactsDelete');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'contactsDelete', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'contactsDelete', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->contactsupdate) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->contactsupdate);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('contactsUpdate');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'contactsUpdate', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'contactsUpdate', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->contactsview) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->contactsview);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('contactsView');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'contactsView', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'contactsView', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->salecreate) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->salecreate);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('saleCreate');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'saleCreate', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'saleCreate', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->saledelete) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->saledelete);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('saleDelete');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'saleDelete', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'saleDelete', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->saleupdate) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->saleupdate);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('saleUpdate');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'saleUpdate', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'saleUpdate', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->saleview) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->saleview);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('saleView');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'saleView', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'saleView', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->rentalscreate) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->rentalscreate);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('rentalsCreate');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'rentalsCreate', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'rentalsCreate', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->rentalsdelete) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->rentalsdelete);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('rentalsDelete');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'rentalsDelete', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'rentalsDelete', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->rentalsupdate) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->rentalsupdate);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('rentalsUpdate');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'rentalsUpdate', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'rentalsUpdate', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->rentalsview) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->rentalsview);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('rentalsView');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'rentalsView', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'rentalsView', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->calendarview) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->calendarview);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('calendarView');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'calendarView', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'calendarView', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->commercialsalescreate) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->commercialsalescreate);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('commercialsalesCreate');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'commercialsalesCreate', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'commercialsalesCreate', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->commercialsalesdelete) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->commercialsalesdelete);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('commercialsalesDelete');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'commercialsalesDelete', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'commercialsalesDelete', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->commercialsalesupdate) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->commercialsalesupdate);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('commercialsalesUpdate');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'commercialsalesUpdate', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'commercialsalesUpdate', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->commercialsalesview) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->commercialsalesview);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('commercialsalesView');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'commercialsalesView', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'commercialsalesView', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->commercialrentalscreate) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->commercialrentalscreate);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('commercialrentalsCreate');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'commercialrentalsCreate', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'commercialrentalsCreate', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->commercialrentalsdelete) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->commercialrentalsdelete);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('commercialrentalsDelete');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'commercialrentalsDelete', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'commercialrentalsDelete', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->commercialrentalsupdate) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->commercialrentalsupdate);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('commercialrentalsUpdate');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'commercialrentalsUpdate', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'commercialrentalsUpdate', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->commercialrentalsview) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->commercialrentalsview);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('commercialrentalsView');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'commercialrentalsView', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'commercialrentalsView', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->reportscreate) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->reportscreate);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('reportsCreate');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'reportsCreate', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'reportsCreate', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->taskmanagercreate) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->taskmanagercreate);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('taskmanagerCreate');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'taskmanagerCreate', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'taskmanagerCreate', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->taskmanagerdelete) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->taskmanagerdelete);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('taskmanagerDelete');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'taskmanagerDelete', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'taskmanagerDelete', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->taskmanagerupdate) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->taskmanagerupdate);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('taskmanagerUpdate');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'taskmanagerUpdate', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'taskmanagerUpdate', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->taskmanagerview) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->taskmanagerview);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('taskmanagerView');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'taskmanagerView', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'taskmanagerView', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->myremindersview) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->myremindersview);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('myremindersView');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'myremindersView', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'myremindersView', 'company_id' => $companyId])->one()->delete();
            }
        }

        if ($modelRoleForm->dealsview) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->dealsview);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('dealsView');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'dealsView', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'dealsView', 'company_id' => $companyId])->one()->delete();
            }
        }

        if ($modelRoleForm->dealscreate) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->dealscreate);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('dealsCreate');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'dealsCreate', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'dealsCreate', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->dealsdelete) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->dealsdelete);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('dealsDelete');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'dealsDelete', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'dealsDelete', 'company_id' => $companyId])->one()->delete();
            }
        }
        if ($modelRoleForm->dealsupdate) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->dealsupdate);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('dealsUpdate');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'dealsUpdate', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'dealsUpdate', 'company_id' => $companyId])->one()->delete();
            }
        }

        if ($modelRoleForm->smsallowed) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->smsallowed);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('smsAllowed');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'smsAllowed', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'smsAllowed', 'company_id' => $companyId])->one()->delete();
            }
        }

        if ($modelRoleForm->excelexport) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->excelexport);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('excelExport');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'excelExport', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'excelExport', 'company_id' => $companyId])->one()->delete();
            }
        }

        if ($modelRoleForm->canassignlead) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->canassignlead);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('canAssignLead');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'canAssignLead', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'canAssignLead', 'company_id' => $companyId])->one()->delete();
            }
        }

        if ($modelRoleForm->contractscreate) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->contractscreate);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('contractsCreate');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'contractsCreate', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'contractsCreate', 'company_id' => $companyId])->one()->delete();
            }
        }

        if ($modelRoleForm->contractsdelete) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->contractsdelete);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('contractsDelete');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'contractsDelete', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'contractsDelete', 'company_id' => $companyId])->one()->delete();
            }
        }

        if ($modelRoleForm->contractsupdate) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->contractsupdate);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('contractsUpdate');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'contractsUpdate', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'contractsUpdate', 'company_id' => $companyId])->one()->delete();
            }
        }

        if ($modelRoleForm->contractsview) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->contractsview);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('contractsView');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'contractsView', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'contractsView', 'company_id' => $companyId])->one()->delete();
            }
        }

        if ($modelRoleForm->viewingcreate) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->viewingcreate);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('viewingCreate');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'viewingCreate', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'viewingCreate', 'company_id' => $companyId])->one()->delete();
            }
        }

        if ($modelRoleForm->viewingdelete) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->viewingdelete);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('viewingDelete');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'viewingDelete', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'viewingDelete', 'company_id' => $companyId])->one()->delete();
            }
        }

        if ($modelRoleForm->viewingupdate) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->viewingupdate);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('viewingUpdate');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'viewingUpdate', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'viewingUpdate', 'company_id' => $companyId])->one()->delete();
            }
        }

        if ($modelRoleForm->viewingview) {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission($modelRoleForm->viewingview);

            $result = AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => $permit->name, 'company_id' => $companyId])->exists();
            if ($result == false ) {
                $rows[] = [$userRole->name, $permit->name, $companyId];
            }
        } else {
            $userRole = Yii::$app->authManager->getRole($modelRoleForm->name);
            $permit   = Yii::$app->authManager->getPermission('viewingView');
            $result   = AuthItemChild::find()->where(['parent' => $userRole->name, 'child' => 'viewingView', 'company_id' => $companyId])->exists();
            if($result == true) {
                AuthItemChild::find()->where(['parent' =>  $userRole->name, 'child' => 'viewingView', 'company_id' => $companyId])->one()->delete();
            }
        }

         Yii::$app->db->createCommand()
        ->batchInsert(AuthItemChild::tableName(), ['parent', 'child', 'company_id'], $rows)
        ->execute();

    }


}
