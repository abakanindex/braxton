<?php

namespace app\modules\lead\controllers;

use app\models\Leads;
use app\models\Reminder;
use Yii;
use app\modules\lead\models\LeadContactNote;
use app\modules\lead\models\LeadContactNoteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LeadContactNoteController implements the CRUD actions for LeadContactNote model.
 */
class LeadContactNoteController extends Controller
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

    /**
     * Lists all LeadContactNote models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LeadContactNoteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LeadContactNote model.
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
     * Creates a new LeadContactNote model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new LeadContactNote();
        $model->lead_id = $id;
        $model->created_at = time();
        $model->updated_at = time();
        $model->user_id = Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $lead = Leads::findOne($model->lead_id);

            $reminder = Reminder::find()
                ->where(['user_id'=>Yii::$app->user->id])
                ->andWhere(['key'=>Reminder::KEY_TYPE_LEAD_CONTACT])
                ->andWhere(['key_id'=>$lead->id])
                ->one();
            if ($reminder)
                $reminder->delete();

            return $this->redirect(['/leads/' . $lead->slug]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing LeadContactNote model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->updated_at = time();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $lead = Leads::findOne($model->lead_id);
            return $this->redirect(['/leads/' . $lead->slug]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LeadContactNote model.
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
     * Finds the LeadContactNote model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LeadContactNote the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LeadContactNote::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
