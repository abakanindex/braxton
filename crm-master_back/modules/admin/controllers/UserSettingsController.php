<?php

namespace app\modules\admin\controllers;

use app\models\{EmailImportLead, UserSearch, User, UserCategories, AuthControllerList, Company, UserStatus};
use app\models\admin\rights\{AuthAssignment, AuthItemChild};
use app\models\reference_books\PropertyCategory;
use app\models\uploadfile\UploadForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\{Controller, UploadedFile, NotFoundHttpException};
use yii\filters\{VerbFilter, AccessControl};
use app\modules\admin\Rbac;
use app\components\{ControllerHelper, CompanyBehavior};
use app\components\rbac\Item;
use app\modules\admin\models\{
    RolesUpdateForm, 
    RoleForm, 
    AuthItem, 
    AuthItemSearch,
    ManageGroup,
    ManageGroupSearch, 
    UserSettingsForm,
    OwnerManageGroup,
    ManageGroupChild

};
use yii\db\Query;
use yii\helpers\{Json, ArrayHelper};
use yii\web\Response;
use app\modules\admin\models\AuthItemChild as PermissionForRole;




/**
 * UserSettingsController implements the CRUD actions for User model.
 */
class UserSettingsController extends Controller
{

    public $companyId;

    public function init() 
    {   

        parent::init();
        $companyId = Company::getCompanyIdBySubdomain();
        if ($companyId == 'main') {
            $this->companyId = 0;
        } else {
            $this->companyId = $companyId;
        }
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'company' => [
                'class' => CompanyBehavior::className(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],

            // 'access' => [
            //     'class' => AccessControl::className(),
            //     'rules' => [
            //         [
            //             'allow' => true,
            //             'roles' => ["Owner"],
            //         ],
            //         [
            //             'allow' => true,
            //             'roles' => ["Admin"],
            //         ],
            //     ],
            // ],
        ];
    }


    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $modelManageGroupChild      = new ManageGroupChild();
        $formGroup                  = new UserSettingsForm();
        $modelRoleForm              = new RoleForm();
        $propertyCategory           = ArrayHelper::map(PropertyCategory::find()->all(), 'id', 'title');
        $searchModel                = new UserSearch();
        $searchModelAuthItem        = new AuthItemSearch();
        $searchModelManageGroup     = new ManageGroupSearch();
        $dataProvider               = $searchModel->search(Yii::$app->request->queryParams);
        $roleDdataProvider          = $searchModelAuthItem->search(Yii::$app->request->queryParams);
        $manageGroupProvider        = $searchModelManageGroup->search(Yii::$app->request->queryParams);
        $model                      = (new User())->getFirstRecordModel();
        $modelRole                  = (new AuthItem())->getFirstRecordModel();
        $modelManageGroup           = (new ManageGroup())->getFirstRecordModel();
        $modelRoleForm->name        = $modelRole->name; 
        $modelRoleForm->description = $modelRole->description; 
        $authItems = ArrayHelper::map(
            AuthItem::find()
            ->where(['!=', 'name', 'Owner'])
            ->andWhere(['type' => '1', 'company_id' => $this->companyId])
            ->all(), 
            'name', 'name'
        );

        $groupsItems = ArrayHelper::map(
            ManageGroup::find()
            ->select(['group_name'])
            ->andWhere(['company_id' => $this->companyId])
            ->all(), 
            'group_name', 'group_name'
        );
        $groupsOwner = ArrayHelper::map(
            OwnerManageGroup::find()
            ->select(['group_name'])
            ->andWhere(['owner_id' => $model->id])
            ->all(), 
            'group_name', 'group_name'
        );
        $modelRoleForm->setCheck($modelRole->name);

        $formGroup->ownergroup = $groupsOwner;
        return $this->render('index', [
            'modelManageGroupChild' => $modelManageGroupChild,
            'formGroup'             => $formGroup,
            'roleDdataProvider'     => $roleDdataProvider,
            'dataProvider'          => $dataProvider,
            'manageGroupProvider'   => $manageGroupProvider,
            'searchModel'           => $searchModel,
            'model'                 => $model,
            'propertyCategory'      => $propertyCategory,
            'modelRoleForm'         => $modelRoleForm,
            'authItems'             => $authItems,
            'groupsItems'           => $groupsItems,
            'activeUsers'           => 'active',
            'disabled'              => true,
            'disabledRole'          => true,
            'disabledGroup'         => true,
            'modelRole'             => $modelRole,
            'modelManageGroup'      => $modelManageGroup,
            'modelImgPrew'          => $model->img_user_profile,
            'userStatuses'          => UserStatus::$statuses
        ]);
    }


    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionManageGroup()
    {
       
        $modelManageGroupChild      = new ManageGroupChild();
        $formGroup                  = new UserSettingsForm();
        $modelRoleForm              = new RoleForm();
        $propertyCategory           = ArrayHelper::map(PropertyCategory::find()->all(), 'id', 'title');
        $searchModel                = new UserSearch();
        $searchModelAuthItem        = new AuthItemSearch();
        $searchModelManageGroup     = new ManageGroupSearch();
        $dataProvider               = $searchModel->search(Yii::$app->request->queryParams);
        $roleDdataProvider          = $searchModelAuthItem->search(Yii::$app->request->queryParams);
        $manageGroupProvider        = $searchModelManageGroup->search(Yii::$app->request->queryParams);
        $model                      = reset($dataProvider->getModels());
        $modelRole                  = (new AuthItem())->getFirstRecordModel();
        $modelManageGroup           = (new ManageGroup())->getFirstRecordModel();
        $modelRoleForm->name        = $modelRole->name; 
        $modelRoleForm->description = $modelRole->description; 
        $authItems = ArrayHelper::map(
            AuthItem::find()
            ->where(['!=', 'name', 'Owner'])
            ->andWhere(['type' => '1', 'company_id' => $this->companyId])
            ->all(), 
            'name', 'name'
        );

        $groupsItems = ArrayHelper::map(
            ManageGroup::find()
            ->select(['group_name'])
            ->andWhere(['company_id' => $this->companyId])
            ->all(), 
            'group_name', 'group_name'
        );
        $groupsOwner = ArrayHelper::map(
            OwnerManageGroup::find()
            ->select(['group_name'])
            ->andWhere(['owner_id' => $model->id])
            ->all(), 
            'group_name', 'group_name'
        );
        $modelRoleForm->setCheck($modelRole->name);

        $formGroup->ownergroup = $groupsOwner;
        return $this->render('manageGroup', [
            'modelManageGroupChild' => $modelManageGroupChild,
            'formGroup'             => $formGroup,
            'dataProvider'          => $dataProvider,
            'manageGroupProvider'   => $manageGroupProvider,
            'searchModel'           => $searchModel,
            'model'                 => $model,
            'propertyCategory'      => $propertyCategory,
            'authItems'             => $authItems,
            'groupsItems'           => $groupsItems,
            'disabledGroup'         => true,
            'modelManageGroup'      => $modelManageGroup,
            'modelImgPrew'          => $model->img_user_profile
        ]);
    }
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionManageRole()
    {
       
        $modelManageGroupChild      = new ManageGroupChild();
        $formGroup                  = new UserSettingsForm();
        $modelRoleForm              = new RoleForm();
        $propertyCategory           = ArrayHelper::map(PropertyCategory::find()->all(), 'id', 'title');
        $searchModel                = new UserSearch();
        $searchModelAuthItem        = new AuthItemSearch();
        $searchModelManageGroup     = new ManageGroupSearch();
        $dataProvider               = $searchModel->search(Yii::$app->request->queryParams);
        $roleDdataProvider          = $searchModelAuthItem->search(Yii::$app->request->queryParams);
        $manageGroupProvider        = $searchModelManageGroup->search(Yii::$app->request->queryParams);
        $model                      = reset($dataProvider->getModels());
        $modelRole                  = (new AuthItem())->getFirstRecordModel();
        $modelManageGroup           = (new ManageGroup())->getFirstRecordModel();
        $modelRoleForm->name        = $modelRole->name; 
        $modelRoleForm->description = $modelRole->description; 
        $authItems = ArrayHelper::map(
            AuthItem::find()
            ->where(['!=', 'name', 'Owner'])
            ->andWhere(['type' => '1', 'company_id' => $this->companyId])
            ->all(), 
            'name', 'name'
        );

        $groupsItems = ArrayHelper::map(
            ManageGroup::find()
            ->select(['group_name'])
            ->andWhere(['company_id' => $this->companyId])
            ->all(), 
            'group_name', 'group_name'
        );
        $groupsOwner = ArrayHelper::map(
            OwnerManageGroup::find()
            ->select(['group_name'])
            ->andWhere(['owner_id' => $model->id])
            ->all(), 
            'group_name', 'group_name'
        );
        $modelRoleForm->setCheck($modelRole->name);

        $formGroup->ownergroup = $groupsOwner;
        return $this->render('manageRole', [
            'modelManageGroupChild' => $modelManageGroupChild,
            'formGroup'             => $formGroup,
            'roleDdataProvider'     => $roleDdataProvider,
            'dataProvider'          => $dataProvider,
            'manageGroupProvider'   => $manageGroupProvider,
            'searchModel'           => $searchModel,
            'model'                 => $model,
            'propertyCategory'      => $propertyCategory,
            'modelRoleForm'         => $modelRoleForm,
            'authItems'             => $authItems,
            'groupsItems'           => $groupsItems,
            'activeUsers'           => 'active',
            'disabled'              => true,
            'disabledRole'          => true,
            'disabledGroup'         => true,
            'modelRole'             => $modelRole,
            'modelManageGroup'      => $modelManageGroup,
            'modelImgPrew'          => $model->img_user_profile
        ]);
    }



    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $formGroup                  = new UserSettingsForm();
        $modelManageGroupChild      = new ManageGroupChild();
        $modelManageGroup           = (new ManageGroup())->getFirstRecordModel();
        $searchModelManageGroup     = new ManageGroupSearch();
        $manageGroupProvider        = $searchModelManageGroup->search(Yii::$app->request->queryParams);
        $modelRoleForm              = new RoleForm();
        $modelRole                  = (new AuthItem())->getFirstRecordModel();
        $modelRoleForm->name        = $modelRole->name; 
        $modelRoleForm->description = $modelRole->description; 
        $model                      = $this->findModel($id);
        $searchModel                = new UserSearch();
        $searchModelAuthItem        = new AuthItemSearch();
        $roleDdataProvider          = $searchModelAuthItem->search(Yii::$app->request->queryParams);
        $dataProvider               = $searchModel->search(Yii::$app->request->queryParams);
        $fileUserProfile            = UploadedFile::getInstance($model, 'file_user_profile');
        $fileContactOverlay         = UploadedFile::getInstance($model, 'file_contact_overlay');
        $uploadForm                 = new UploadForm();
        $authItems = ArrayHelper::map(
            AuthItem::find()
            ->where(['!=', 'name', 'Owner'])
            ->andWhere(['type' => '1', 'company_id' => $this->companyId])
            ->all(), 
            'name', 'name'
        );
        $groupsItems = ArrayHelper::map(
            ManageGroup::find()
            ->select(['group_name'])
            ->andWhere(['company_id' => $this->companyId])
            ->all(), 
            'group_name', 'group_name'
        );
        $groupsOwner = ArrayHelper::map(
            OwnerManageGroup::find()
            ->select(['group_name'])
            ->andWhere(['owner_id' => $id])
            ->all(), 
            'group_name', 'group_name'
        );

        $formGroup->ownergroup = $groupsOwner;
        $modelRoleForm->setCheck($modelRole->name);
        $propertyCategory = ArrayHelper::map(PropertyCategory::find()->all(), 'id', 'title');
        $postData = Yii::$app->request->post();

        if ($model->load($postData) && $model->save() && $model->changeRole($id)) {
            $userCategories = $postData['User']['userCategoriesData'];
            UserCategories::deleteAll(['user_id' => $model->id]);

            foreach ($userCategories as $uC) {
                $model->saveUserCategory($uC);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('index', [
            'groupsItems'           => $groupsItems,
            'modelManageGroupChild' => $modelManageGroupChild,
            'formGroup'             => $formGroup,
            'modelManageGroup'      => $modelManageGroup,
            'manageGroupProvider'   => $manageGroupProvider,
            'model'                 => $model,
            'searchModel'           => $searchModel,
            'dataProvider'          => $dataProvider,
            'authItems'             => $authItems,
            'propertyCategory'      => $propertyCategory,
            'modelRole'             => $modelRole,
            'modelRoleForm'         => $modelRoleForm,
            'disabled'              => true,
            'disabledRole'          => true,
            'disabledGroup'         => true,
            'activeUsers'           => 'active',
            'roleDdataProvider'     => $roleDdataProvider,
            'modelImgPrew'          => $model->img_user_profile,
            'userStatuses'          => UserStatus::$statuses
        ]);
    }

    public function actionViewRole($name)
    {
        $modelManageGroupChild      = new ManageGroupChild();
        $formGroup                  = new UserSettingsForm();
        $modelManageGroup           = (new ManageGroup())->getFirstRecordModel();
        $searchModelManageGroup     = new ManageGroupSearch();
        $manageGroupProvider        = $searchModelManageGroup->search(Yii::$app->request->queryParams);
        $modelRole                  = (new AuthItem())->getFirstRecordModel($name);
        $modelRoleForm              = new RoleForm();
        $propertyCategory           = ArrayHelper::map(PropertyCategory::find()->all(), 'id', 'title');
        $searchModel                = new UserSearch();
        $searchModelAuthItem        = new AuthItemSearch();
        $modelRoleForm->name        = $modelRole->name;
        $modelRoleForm->description = $modelRole->description;
        $dataProvider               = $searchModel->search(Yii::$app->request->queryParams);
        $roleDdataProvider          = $searchModelAuthItem->search(Yii::$app->request->queryParams);
        $model                      = reset($dataProvider->getModels());
        $authItems = ArrayHelper::map(
            AuthItem::find()
            ->where(['!=', 'name', 'Owner'])
            ->andWhere(['type' => '1', 'company_id' => $this->companyId])
            ->all(), 
            'name', 'name'
        );
        $groupsOwner = ArrayHelper::map(
            OwnerManageGroup::find()
            ->select(['group_name'])
            ->all(), 
            'group_name', 'group_name'
        );

        $formGroup->ownergroup = $groupsOwner;
        
        $modelRoleForm->setCheck($name);

        return $this->render('manageRole', [
            'modelManageGroupChild' => $modelManageGroupChild, 
            'formGroup'             => $formGroup,
            'modelManageGroup'      => $modelManageGroup,
            'manageGroupProvider'   => $manageGroupProvider,
            'roleDdataProvider'     => $roleDdataProvider,
            'dataProvider'          => $dataProvider,
            'searchModel'           => $searchModel,
            'model'                 => $model,
            'propertyCategory'      => $propertyCategory,
            'modelRoleForm'         => $modelRoleForm,
            'authItems'             => $authItems,
            'activeRoles'           => 'active',
            'disabled'              => true,
            'disabledRole'          => true,
            'disabledGroup'         => true,
            'modelRole'             => $modelRole,
            'modelImgPrew'          => $model->img_user_profile
            
        ]);
    }

    public function actionViewGroup($name)
    {
        $modelManageGroupChild      = new ManageGroupChild();
        $formGroup                  = new UserSettingsForm();
        $modelRole                  = (new AuthItem())->getFirstRecordModel('Admin');
        $modelRoleForm              = new RoleForm();
        $propertyCategory           = ArrayHelper::map(PropertyCategory::find()->all(), 'id', 'title');
        $searchModel                = new UserSearch();
        $searchModelAuthItem        = new AuthItemSearch();
        $modelRoleForm->name        = $modelRole->name;
        $modelRoleForm->description = $modelRole->description;
        $dataProvider               = $searchModel->search(Yii::$app->request->queryParams);
        $roleDdataProvider          = $searchModelAuthItem->search(Yii::$app->request->queryParams);
        $model                      = reset($dataProvider->getModels());
        $searchModelManageGroup     = new ManageGroupSearch();
        $manageGroupProvider        = $searchModelManageGroup->search(Yii::$app->request->queryParams);
        $modelManageGroup           = (new ManageGroup())->getFirstRecordModel($name);
        $authItems = ArrayHelper::map(
            AuthItem::find()
            ->where(['!=', 'name', 'Owner'])
            ->andWhere(['type' => '1', 'company_id' => $this->companyId])
            ->all(), 
            'name', 'name'
        );
        $groupsOwner = ArrayHelper::map(
            OwnerManageGroup::find()
            ->select(['group_name'])
            ->andWhere(['owner_id' => $model->id])
            ->all(), 
            'group_name', 'group_name'
        );

        $formGroup->ownergroup = $groupsOwner;
        
        $modelRoleForm->setCheck($name);

        return $this->render('manageGroup', [
            'modelManageGroupChild' => $modelManageGroupChild,
            'roleDdataProvider'     => $roleDdataProvider,
            'dataProvider'          => $dataProvider,
            'searchModel'           => $searchModel,
            'model'                 => $model,
            'propertyCategory'      => $propertyCategory,
            'modelRoleForm'         => $modelRoleForm,
            'authItems'             => $authItems,
            'activeGroups'          => 'active',
            'disabled'              => true,
            'disabledRole'          => true,
            'disabledGroup'         => true,
            'modelRole'             => $modelRole,
            'modelManageGroup'      => $modelManageGroup,
            'manageGroupProvider'   => $manageGroupProvider,
            'formGroup'             => $formGroup,
            'modelImgPrew'          => $model->img_user_profile
            
        ]);
    }

    /**
     * @return string|Response
     * @throws \Exception
     */
    public function actionCreate()
    {
        $modelManageGroupChild      = new ManageGroupChild();
        $modelOwnerUserGroup        = new OwnerManageGroup();
        $formGroup                  = new UserSettingsForm();
        $modelManageGroup           = (new ManageGroup())->getFirstRecordModel();
        $model                      = new User();
        $modelRoleForm              = new RoleForm();
        $searchModel                = new UserSearch();
        $modelRole                  = (new AuthItem())->getFirstRecordModel();
        $modelRoleForm->name        = $modelRole->name; 
        $modelRoleForm->description = $modelRole->description; 
        $searchModelAuthItem        = new AuthItemSearch();
        $dataProvider               = $searchModel->search(Yii::$app->request->queryParams);
        $roleDdataProvider          = $searchModelAuthItem->search(Yii::$app->request->queryParams);
        $fileUserProfile            = UploadedFile::getInstance($model, 'file_user_profile');
        $fileContactOverlay         = UploadedFile::getInstance($model, 'file_contact_overlay');
        $searchModelManageGroup     = new ManageGroupSearch();
        $manageGroupProvider        = $searchModelManageGroup->search(Yii::$app->request->queryParams);
        $uploadForm                 = new UploadForm();
        $propertyCategory           = ArrayHelper::map(PropertyCategory::find()->all(), 'id', 'title');
        $postData                   = Yii::$app->request->post();
        $modelImg                   = new UploadForm();
        $authItems = ArrayHelper::map(
            AuthItem::find()
            ->where(['!=', 'name', 'Owner'])
            ->andWhere(['type' => '1', 'company_id' => $this->companyId])
            ->all(), 
            'name', 'name'
        );
        $groupsItems = ArrayHelper::map(
            ManageGroup::find()
            ->select(['group_name'])
            ->andWhere(['company_id' => $this->companyId])
            ->all(), 
            'group_name', 'group_name'
        );

        
        $modelRoleForm->setCheck($modelRole->name);
        if ($this->companyId == 'main') {
            $model->company_id = 0;
        } else {
            $model->company_id = $this->companyId;
        }
        $model->create_by_user_id = Yii::$app->user->id;

        if ($model->load($postData) && $model->validate() && $model->save()) {
            $modelOwnerUserGroup->setGroupOwner($model->id, $postData['owner']);
            $userRole = Yii::$app->authManager->getRole($model->role);
            Yii::$app->authManager->assign($userRole, $model->id);

            $userCategories = $postData['User']['userCategoriesData'];
            UserCategories::deleteAll(['user_id' => $model->id]);

            foreach ($userCategories as $uC) {
                $model->saveUserCategory($uC);
            }

            $modelImg->uploadImgUser(UploadedFile::getInstances($modelImg, 'imageFiles')[0], $model, "img_user_profile");

            Yii::$app->session->setFlash('alerts', 'user created');

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('index', [
            'groupsItems'           => $groupsItems,
            'modelManageGroupChild' => $modelManageGroupChild,
            'formGroup'             => $formGroup,
            'manageGroupProvider'   => $manageGroupProvider,
            'model'                 => $model,
            'searchModel'           => $searchModel,
            'dataProvider'          => $dataProvider,
            'authItems'             => $authItems,
            'propertyCategory'      => $propertyCategory,
            'modelRoleForm'         => $modelRoleForm,
            'activeUsers'           => 'active',
            'disabled'              => false,
            'disabledRole'          => true,
            'disabledGroup'         => true,
            'roleDdataProvider'     => $roleDdataProvider,
            'modelManageGroup'      => $modelManageGroup,
            'modelImg'              => $modelImg,
            'modelImgPrew'          => $model->img_user_profile,
            'modelRole'             => $modelRole,
            'userStatuses'          => UserStatus::$statuses
        ]);
    }


    /**
     * @return string|Response
     * @throws \Exception
     */
    public function actionCreateRole()
    {
        $modelManageGroupChild  = new ManageGroupChild();
        $formGroup              = new UserSettingsForm();
        $modelManageGroup       = (new ManageGroup())->getFirstRecordModel();
        $searchModel            = new UserSearch();
        $companyId              = Company::getCompanyIdBySubdomain();
        $modelRoleForm          = new RoleForm();
        $searchModel            = new UserSearch();
        $searchModelAuthItem    = new AuthItemSearch();
        $modelRole              = new AuthItem();
        $roleDdataProvider      = $searchModelAuthItem->search(Yii::$app->request->queryParams);
        $dataProvider           = $searchModel->search(Yii::$app->request->queryParams);
        $model                  = reset($dataProvider->getModels());
        $searchModelManageGroup = new ManageGroupSearch();
        $manageGroupProvider    = $searchModelManageGroup->search(Yii::$app->request->queryParams);
        $authItems = ArrayHelper::map(
            AuthItem::find()
            ->where(['!=', 'name', 'Owner'])
            ->andWhere(['type' => '1', 'company_id' => $this->companyId])
            ->all(), 
            'name', 'name'
        );

        $groupsOwner = ArrayHelper::map(
            OwnerManageGroup::find()
            ->select(['group_name'])
            ->andWhere(['owner_id' => $model->id])
            ->all(), 
            'group_name', 'group_name'
        );

        $formGroup->ownergroup = $groupsOwner;
        $propertyCategory      = ArrayHelper::map(PropertyCategory::find()->all(), 'id', 'title');
        $postData              = Yii::$app->request->post();
        
 
        if ($modelRoleForm->load($postData)) {
            $result    = AuthItem::find()->where(['name' => $modelRoleForm->name, 'company_id' => $this->companyId])->exists();
            if ($result == false ) {
                $role              = Yii::$app->authManager->createRole($modelRoleForm->name);
                $role->description = $modelRoleForm->description;
                Yii::$app->authManager->add($role);
                Yii::$app->session->setFlash('alerts', 'role created');
                $modelRole->setPermissions($modelRoleForm);
            } else {
                Yii::$app->session->setFlash('warning', 'such a role already exists');
            }

            return $this->redirect(['view-role', 'name' => $modelRoleForm->name]);

        }

        return $this->render('manageRole', [
            'modelManageGroupChild' => $modelManageGroupChild,
            'formGroup'             => $formGroup,
            'modelManageGroup'      => $modelManageGroup,
            'manageGroupProvider'   => $manageGroupProvider,
            'model'                 => $model,
            'searchModel'           => $searchModel,
            'dataProvider'          => $dataProvider,
            'authItems'             => $authItems,
            'propertyCategory'      => $propertyCategory,
            'modelRoleForm'         => $modelRoleForm,
            'activeRoles'           => 'active',
            'roleDdataProvider'     => $roleDdataProvider,
            'modelRole'             => $modelRole,
            'disabled'              => true,
            'disabledRole'          => false,
            'disabledGroup'         => true,
            'modelImgPrew'          => $model->img_user_profile
        ]);
    }

    /**
     * @return string|Response
     * @throws \yii\db\Exception
     */
    public function actionCreateGroup()
    {
        $formGroup                  = new UserSettingsForm();
        $modelManageGroup           = new ManageGroup();
        $modelManageGroupChild      = new ManageGroupChild();
        $modelRoleForm              = new RoleForm();
        $searchModel                = new UserSearch();
        $searchModelAuthItem        = new AuthItemSearch();
        $modelRole                  = (new AuthItem())->getFirstRecordModel();
        $modelRoleForm->name        = $modelRole->name;
        $modelRoleForm->description = $modelRole->description;
        $searchModelManageGroup     = new ManageGroupSearch();
        $manageGroupProvider        = $searchModelManageGroup->search(Yii::$app->request->queryParams);
        $roleDdataProvider          = $searchModelAuthItem->search(Yii::$app->request->queryParams);
        $dataProvider               = $searchModel->search(Yii::$app->request->queryParams);
        $model                      = reset($dataProvider->getModels());
        $authItems = ArrayHelper::map(
            AuthItem::find()
            ->where(['!=', 'name', 'Owner'])
            ->andWhere(['type' => '1', 'company_id' => $this->companyId])
            ->all(), 
            'name', 'name'
        );
        $groupsOwner = ArrayHelper::map(
            OwnerManageGroup::find()
            ->select(['group_name'])
            ->andWhere(['owner_id' => $model->id])
            ->all(), 
            'group_name', 'group_name'
        );

        $formGroup->ownergroup = $groupsOwner;
        $modelRoleForm->setCheck($modelRole->name);
        $propertyCategory             = ArrayHelper::map(PropertyCategory::find()->all(), 'id', 'title');
        $getData                     = Yii::$app->request->get();
        $modelManageGroup->company_id = $this->companyId;

        if ($modelManageGroup->load(Yii::$app->request->get()) && $modelManageGroup->save()) {

            $modelManageGroup->checkGridDataUser($modelManageGroup->group_name, $getData['selection']);
                       
            if (array_filter($getData['UserSearch'])) {
                
            } else {
                Yii::$app->session->setFlash('alerts', 'group created');
                return $this->redirect(['view-group', 'name' => $modelManageGroup->group_name]);
            }
        }

        return $this->render('manageGroup', [
            'modelManageGroupChild' => $modelManageGroupChild,
            'formGroup'             => $formGroup,
            'model'                 => $model,
            'searchModel'           => $searchModel,
            'dataProvider'          => $dataProvider,
            'authItems'             => $authItems,
            'propertyCategory'      => $propertyCategory,
            'modelRoleForm'         => $modelRoleForm,
            'activeGroups'          => 'active',
            'roleDdataProvider'     => $roleDdataProvider,
            'modelRole'             => $modelRole,
            'disabled'              => true,
            'disabledRole'          => true,
            'modelManageGroup'      => $modelManageGroup,
            'manageGroupProvider'   => $manageGroupProvider,
            'modelImgPrew'          => $model->img_user_profile
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $modelManageGroupChild      = new ManageGroupChild();
        $modelOwnerUserGroup        = new OwnerManageGroup();
        $formGroup                  = new UserSettingsForm();
        $modelManageGroup           = (new ManageGroup())->getFirstRecordModel();
        $searchModelManageGroup     = new ManageGroupSearch();
        $manageGroupProvider        = $searchModelManageGroup->search(Yii::$app->request->queryParams);
        $modelRoleForm              = new RoleForm();
        $modelRole                  = (new AuthItem())->getFirstRecordModel();
        $modelRoleForm->name        = $modelRole->name; 
        $modelRoleForm->description = $modelRole->description; 
        $model                      = $this->findModel($id);
        $searchModel                = new UserSearch();
        $searchModelAuthItem        = new AuthItemSearch();
        $roleDdataProvider          = $searchModelAuthItem->search(Yii::$app->request->queryParams);
        $dataProvider               = $searchModel->search(Yii::$app->request->queryParams);
        $fileUserProfile            = UploadedFile::getInstance($model, 'file_user_profile');
        $fileContactOverlay         = UploadedFile::getInstance($model, 'file_contact_overlay');
        $uploadForm                 = new UploadForm();
        $modelImg                   = new UploadForm();
        $authItems = ArrayHelper::map(
            AuthItem::find()
            ->where(['!=', 'name', 'Owner'])
            ->andWhere(['type' => '1', 'company_id' => $this->companyId])
            ->all(), 
            'name', 'name'
        );
        $groupsItems = ArrayHelper::map(
            ManageGroup::find()
            ->select(['group_name'])
            ->andWhere(['company_id' => $this->companyId])
            ->all(), 
            'group_name', 'group_name'
        );
        $groupsOwner = ArrayHelper::map(
            OwnerManageGroup::find()
            ->select(['group_name'])
            ->andWhere(['owner_id' => $id])
            ->all(), 
            'group_name', 'group_name'
        );

        $formGroup->ownergroup = $groupsOwner;
        
        $modelRoleForm->setCheck($modelRole->name);
        $propertyCategory    = ArrayHelper::map(PropertyCategory::find()->all(), 'id', 'title');
        $postData            = Yii::$app->request->post();


        if ($model->load($postData)
            && $model->validate()
            && $model->save()
            && $model->changeRole($id)
        ) {
            $ownerGroup = $postData['owner'];
            $modelOwnerUserGroup::deleteAll(['owner_id' => $model->id]);
            $modelOwnerUserGroup->setGroupOwner($model->id, $postData['owner']);
            $userCategories = $postData['User']['userCategoriesData'];
            UserCategories::deleteAll(['user_id' => $model->id]);
            Yii::$app->session->setFlash('alerts', 'user updated');
            foreach ($userCategories as $uC) {
                $model->saveUserCategory($uC);
            }

            $modelImg->uploadImgUser(UploadedFile::getInstances($modelImg, 'imageFiles')[0], $model, "img_user_profile");

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('index', [
            'modelManageGroupChild' => $modelManageGroupChild, 
            'groupsItems'           => $groupsItems,
            'formGroup'             => $formGroup,
            'modelManageGroup'      => $modelManageGroup,
            'manageGroupProvider'   => $manageGroupProvider,
            'model'                 => $model,
            'searchModel'           => $searchModel,
            'dataProvider'          => $dataProvider,
            'authItems'             => $authItems,
            'propertyCategory'      => $propertyCategory,
            'modelRole'             => $modelRole,
            'modelRoleForm'         => $modelRoleForm,
            'disabled'              => false,
            'disabledRole'          => true,
            'disabledGroup'         => true,
            'activeUsers'           => 'active',
            'roleDdataProvider'     => $roleDdataProvider,
            'modelImg'              => $modelImg,
            'modelImgPrew'          => $model->img_user_profile,
            'userStatuses'          => UserStatus::$statuses
        ]);
    }


    public function actionUpdateRole($name)
    {
        $modelManageGroupChild      = new ManageGroupChild();
        $formGroup                  = new UserSettingsForm();
        $modelManageGroup           = (new ManageGroup())->getFirstRecordModel();
        $searchModelManageGroup     = new ManageGroupSearch();
        $manageGroupProvider        = $searchModelManageGroup->search(Yii::$app->request->queryParams);
        $model                      = new User();
        $modelRoleForm              = new RoleForm();
        $searchModel                = new UserSearch();
        $searchModelAuthItem        = new AuthItemSearch();
        $modelRole                  = (new AuthItem())->getFirstRecordModel($name);
        $modelRoleForm->name        = $modelRole->name; 
        $modelRoleForm->description = $modelRole->description; 
        $dataProvider               = $searchModel->search(Yii::$app->request->queryParams);
        $modelUser                  = reset($dataProvider->getModels());
        $roleDdataProvider          = $searchModelAuthItem->search(Yii::$app->request->queryParams);
        $dataProvider               = $searchModel->search(Yii::$app->request->queryParams);
        $fileUserProfile            = UploadedFile::getInstance($model, 'file_user_profile');
        $fileContactOverlay         = UploadedFile::getInstance($model, 'file_contact_overlay');
        $uploadForm                 = new UploadForm();
        $authItems = ArrayHelper::map(
            AuthItem::find()
            ->where(['!=', 'name', 'Owner'])
            ->andWhere(['type' => '1', 'company_id' => $this->companyId])
            ->all(), 
            'name', 'name'
        );
        $groupsOwner = ArrayHelper::map(
            OwnerManageGroup::find()
            ->select(['group_name'])
            ->andWhere(['owner_id' => $model->id])
            ->all(), 
            'group_name', 'group_name'
        );

        $formGroup->ownergroup = $groupsOwner;
        $propertyCategory      = ArrayHelper::map(PropertyCategory::find()->all(), 'id', 'title');
        $postData              = Yii::$app->request->post();
        

        if ($modelRoleForm->load($postData)) {
            
            
            $modelRole->name        = $modelRoleForm->name;
            $modelRole->description = $modelRoleForm->description;
            $modelRole->save();
            $modelRole->setPermissions($modelRoleForm);
            Yii::$app->session->setFlash('alerts', 'role updated');
            return $this->redirect(['view-role', 'name' => $modelRoleForm->name]);

        }
        $modelRoleForm->setCheck($name);

        return $this->render('manageRole', [          
            'formGroup'             => $formGroup,
            'modelManageGroupChild' => $modelManageGroupChild,
            'modelManageGroup'      => $modelManageGroup,
            'manageGroupProvider'   => $manageGroupProvider,
            'model'                 => $modelUser ,
            'searchModel'           => $searchModel,
            'dataProvider'          => $dataProvider,
            'authItems'             => $authItems,
            'propertyCategory'      => $propertyCategory,
            'modelRoleForm'         => $modelRoleForm,
            'activeRoles'           => 'active',
            'roleDdataProvider'     => $roleDdataProvider,
            'modelRole'             => $modelRole,
            'disabled'              => true,
            'disabledRole'          => false,
            'disabledGroup'         => true,
            'modelImgPrew'          => $modelUser->img_user_profile
        ]);
    }


    public function actionUpdateGroup($name)
    {
        $modelManageGroupChild      = new ManageGroupChild();
        $formGroup                  = new UserSettingsForm();
        $modelRole                  = (new AuthItem())->getFirstRecordModel();
        $modelRoleForm              = new RoleForm();
        $propertyCategory           = ArrayHelper::map(PropertyCategory::find()->all(), 'id', 'title');
        $searchModel                = new UserSearch();
        $searchModelAuthItem        = new AuthItemSearch();
        $modelRoleForm->name        = $modelRole->name;
        $modelRoleForm->description = $modelRole->description;
        $dataProvider               = $searchModel->search(Yii::$app->request->queryParams);
        $roleDdataProvider          = $searchModelAuthItem->search(Yii::$app->request->queryParams);
        $model                      = reset($dataProvider->getModels());
        $searchModelManageGroup     = new ManageGroupSearch();
        $manageGroupProvider        = $searchModelManageGroup->search(Yii::$app->request->queryParams);
        $modelManageGroup           = (new ManageGroup())->getFirstRecordModel($name);
        $authItems = ArrayHelper::map(
            AuthItem::find()
            ->where(['!=', 'name', 'Owner'])
            ->andWhere(['type' => '1', 'company_id' => $this->companyId])
            ->all(), 
            'name', 'name'
        );
        $groupsOwner = ArrayHelper::map(
            OwnerManageGroup::find()
            ->select(['group_name'])
            ->andWhere(['owner_id' => $model->id])
            ->all(), 
            'group_name', 'group_name'
        );
        $getData = Yii::$app->request->get();

        $formGroup->ownergroup = $groupsOwner;
        $modelRoleForm->setCheck($name);
        if ($modelManageGroup->load(Yii::$app->request->get()) && $modelManageGroup->save()) { 

            $modelManageGroup->checkGridDataUser($modelManageGroup->group_name, $getData['selection']);
            $modelManageGroup->save();
            if (array_filter($getData['UserSearch'])) {
                
            } else {
                Yii::$app->session->setFlash('alerts', 'group update');
                return $this->redirect(['view-group', 'name' => $modelManageGroup->group_name]);
            }
            
        }

        return $this->render('manageGroup', [
            'modelManageGroupChild' => $modelManageGroupChild,
            'formGroup'             => $formGroup,
            'roleDdataProvider'     => $roleDdataProvider,
            'dataProvider'          => $dataProvider,
            'searchModel'           => $searchModel,
            'model'                 => $model,
            'propertyCategory'      => $propertyCategory,
            'modelRoleForm'         => $modelRoleForm,
            'authItems'             => $authItems,
            'activeGroups'          => 'active',
            'disabled'              => true,
            'disabledRole'          => true,
            'disabledGroup'         => false,
            'modelRole'             => $modelRole,
            'modelManageGroup'      => $modelManageGroup,
            'manageGroupProvider'   => $manageGroupProvider,
            'modelImgPrew'          => $model->img_user_profile
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionDeleteRole($name)
    {
        (new AuthItem())->getFirstRecordModel($name)->delete();
        PermissionForRole::deleteAll(['parent' => $name, 'company_id' => $this->companyId]);
        Yii::$app->session->setFlash('alerts', 'role deleted');
        return $this->redirect(['manage-role']);
    }

    public function actionDeleteGroup($name)
    {
        (new ManageGroup())->getFirstRecordModel($name)->delete();
        Yii::$app->session->setFlash('alerts', 'group deleted');
        return $this->redirect(['manage-group']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = User::find()->where(['id' => $id])->with('userCategories')->one();
        if (($model) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * This method deletes image of user profile
     *
     * @return bool
     */
    public function actionDropImg() {
        $userId = Yii::$app->request->post('userId');

        if (empty($userId)) {
            return false;
        }

        $model = User::find()
            ->where(['id' => $userId])
            ->one();

        unlink(Yii::getAlias('@app') . $model->img_user_profile);

        $model->img_user_profile = null;
        $model->save();

        return true;
    }
}
