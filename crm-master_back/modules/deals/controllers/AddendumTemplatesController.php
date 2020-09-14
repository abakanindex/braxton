<?php

namespace app\modules\deals\controllers;

use app\models\Company;
use app\models\User;
use app\models\UserProfile;
use app\modules\deals\models\Templates;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use app\classes\existrecord\ExistRecordModel;
use app\classes\{CountAddedProducts, TotalNumberOfUsers};

/**
 * Class AddendumTemplatesController
 * @package app\modules\deals\controllers
 */
class AddendumTemplatesController extends Controller
{
    public $layout = 'deals-base';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'only'  => ['index', 'create', 'update', 'view', 'delete'],
                'rules' => [
                    [
                        'allow'       => true,
                        'actions'     => ['index'],
                        'permissions' => ['dealsView'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['create'],
                        'permissions' => ['dealsCreate'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['update'],
                        'permissions' => ['dealsUpdate'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['view'],
                        'permissions' => ['dealsView'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['delete'],
                        'permissions' => ['dealsDelete'],
                        'roles'       => ['Owner']
                    ],
                ],
            ],
        ];
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model        = (new Templates())->getFirstRecordModel();
        $searchModel  = new Templates();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->pagination->pageSize = 20;

        return $this->render('index', [
            'firstRecord'       => $model,
            'existRecord'       => (new ExistRecordModel())->getExistRecordModel(Templates::class),
            'disabledAttribute' => true,
            'dataProvider'      => $dataProvider,
            'filteredColumns'   => [],
            'searchModel'       => $searchModel,
        ]);
    }

    /**
     * Creates a new Templates model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = $searchModel = new Templates();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->pagination->pageSize = 20;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->created_by = Yii::$app->user->id;
            $model->created_at = $model->updated_at = time();
            $companyId = Company::getCompanyIdBySubdomain();

            if ($companyId == 'main') {
                $model->company_id = 0;
            } else {
                $model->company_id = $companyId;
            }

            if ($model->save()) {
                if (Templates::find()->where(['id' => $model->id])->exists())
                    return $this->redirect(['view', 'id' => $model->id]);
                else
                    return $this->redirect(['index']);
            }
        }

        return $this->render('index', [
            'firstRecord'            => $model,
            'disabledAttribute'      => false,
            'dataProvider'      => $dataProvider,
            'filteredColumns'   => [],
            'searchModel'       => $searchModel,
        ]);
    }

    /**
     * Displays a single Templates model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model        = (new Templates())->getFirstRecordModel($id);
        $searchModel  = new Templates();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->pagination->pageSize = 20;

        return $this->render('index', [
            'firstRecord'            => $model,
            'existRecord'            => (new ExistRecordModel())->getExistRecordModel(Templates::class),
            'disabledAttribute'      => true,
            'dataProvider'      => $dataProvider,
            'filteredColumns'   => [],
            'searchModel'       => $searchModel,
        ]);
    }

    /**
     * Updates an existing Templates model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = (new Templates())->getFirstRecordModel($id);
        $searchModel  = new Templates();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->pagination->pageSize = 20;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->created_by = Yii::$app->user->id;
            $model->updated_at = time();
            $companyId = Company::getCompanyIdBySubdomain();

            if ($companyId == 'main') {
                $model->company_id = 0;
            } else {
                $model->company_id = $companyId;
            }

            if ($model->save()) {
                if (Templates::find()->where(['id' => $model->id])->exists())
                    return $this->redirect(['view', 'id' => $model->id]);
                else
                    return $this->redirect(['index']);
            }
        }

        return $this->render('index', [
            'firstRecord'            => $model,
            'disabledAttribute'      => false,
            'dataProvider'      => $dataProvider,
            'filteredColumns'   => [],
            'searchModel'       => $searchModel,
        ]);
    }

    /**
     * Deletes an existing Templates model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        Templates::deleteAll([Templates::primaryKey()[0] => $id]);
        return $this->redirect(['index']);
    }
}