<?php

namespace app\controllers;

use Yii;
use app\models\PaymentPlan;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use developeruz\db_rbac\behaviors\AccessBehavior;



/**
 * PaymentPlanController implements the CRUD actions for PaymentPlan model.
 */
class PaymentPlanController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

            'as AccessBehavior' => [
                'class' => \developeruz\db_rbac\behaviors\AccessBehavior::className(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PaymentPlan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->setViewPath('@app/views/admin/payment');
        $dataProvider = new ActiveDataProvider([
            'query' => PaymentPlan::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PaymentPlan model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->setViewPath('@app/views/admin/payment');
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PaymentPlan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->setViewPath('@app/views/admin/payment');

        $model = new PaymentPlan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PaymentPlan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->setViewPath('@app/views/admin/payment');

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PaymentPlan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->setViewPath('@app/views/admin/payment');

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PaymentPlan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PaymentPlan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $this->setViewPath('@app/views/admin/payment');

        if (($model = PaymentPlan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
