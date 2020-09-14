<?php

namespace app\controllers;

use app\modules\lead\models\EmailImportLeadParser;
use camohob\imap\ImapAgent;
use Yii;
use app\models\EmailImportLead;
use app\models\EmailImportLeadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * EmailImportLeadController implements the CRUD actions for EmailImportLead model.
 */
class EmailImportLeadController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCheck()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $emailImportLead = EmailImportLead::findOne(['user_id'=>Yii::$app->user->id]);
        if ($emailImportLead)
            EmailImportLeadParser::checkNewEmails($emailImportLead);
        return ['result' => 'success'];
    }


    /**
     * Lists all EmailImportLead models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmailImportLeadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmailImportLead model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EmailImportLead model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmailImportLead();
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return ['result' => 'success', 'id' => $model->id];
            } else return ['result' => 'error'];
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionValidate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new EmailImportLead();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            return ActiveForm::validate($model);
            Yii::$app->end();
        }
    }

    /**
     * Updates an existing EmailImportLead model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return ['result' => 'success', 'id' => $model->id];
            } else return ['result' => 'error'];
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EmailImportLead model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EmailImportLead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmailImportLead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmailImportLead::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
