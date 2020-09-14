<?php

namespace app\controllers;

use app\models\Leads;
use Yii;
use app\models\Viewings;
use app\models\ViewingsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\components\widgets\ViewingsSaleRentalWidget;
use app\components\widgets\ViewingsLeadWidget;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

/**
 * ViewingController implements the CRUD actions for Viewings model.
 */
class ViewingController extends Controller
{
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
                    'viewingReportForm' => ['POST'],
                    'viewingReportCancellation' => ['POST'],
                    'viewingReportSave' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'permissions' => ['viewingView'],
                        'roles' => ['Owner']
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Viewings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ViewingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Viewings model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => Viewings::getByIdWithAgent($id),
        ]);
    }

    /**
     * Load single Viewing model for edit, etc.
     * @param $id
     * @param $ref
     * @param $type
     */
    public function actionLoad($id, $ref, $type)
    {
        if ($type == Viewings::TYPE_RENTAL || $type == Viewings::TYPE_SALE) {
            return ViewingsSaleRentalWidget::widget(['model' => Viewings::findOne($id), 'ref' => $ref, 'type' => $type]);
        } else if ($type == Viewings::TYPE_LEAD) {
            return ViewingsLeadWidget::widget(['model' => Viewings::findOne($id), 'modelLead' => Leads::findOne(['reference' => $ref]), 'type' => $type]);
        }
    }

    /**
     * Creates a new Viewings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return string
     * @throws \Exception
     */
    public function actionCreate()
    {
        $model = new Viewings();
        $postData = Yii::$app->request->post();

        if ($model->load($postData) && $model->validate()) {
            $model->created_by = Yii::$app->user->id;
            if ($postData['Viewings']['date'])
                $model->date = $model->report_cancellation_date = $postData['Viewings']['date'] . ' ' . $postData['Viewings']['time'];
            $model->save();
        }

        if ($model->type == Viewings::TYPE_RENTAL || $model->type == Viewings::TYPE_SALE) {
            return ViewingsSaleRentalWidget::widget(['model' => new Viewings(), 'ref' => $model->ref, 'type' => $model->type]);
        } else if ($model->type == Viewings::TYPE_LEAD) {
            return ViewingsLeadWidget::widget(['model' => new Viewings(), 'modelLead' => Leads::findOne(['reference' => $model->ref]), 'type' => $model->type]);
        }
    }

    /**
     * Updates an existing Viewings model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model    = $this->findModel($id);
        $postData = Yii::$app->request->post();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($postData['Viewings']['date'])
                $model->date = $model->report_cancellation_date = $postData['Viewings']['date'] . ' ' . $postData['Viewings']['time'];
            $model->save();
        }

        if ($model->type == Viewings::TYPE_RENTAL || $model->type == Viewings::TYPE_SALE) {
            return ViewingsSaleRentalWidget::widget(['model' => new Viewings(), 'ref' => $model->ref, 'type' => $model->type]);
        } else if ($model->type == Viewings::TYPE_LEAD) {
            return ViewingsLeadWidget::widget(['model' => new Viewings(), 'modelLead' => Leads::findOne(['reference' => $model->ref]), 'type' => $model->type]);
        }
    }

    /**
     * Deletes an existing Viewings model.
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
     * Finds the Viewings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Viewings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Viewings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return null|string
     */
    public function actionViewingReportForm()
    {
        if (Yii::$app->request->isAjax) {
            $viewingId = Yii::$app->request->post()['id'];

            if ($viewingId) {
                return $this->renderAjax('@app/views/parts/viewingReportFormContent', [
                    'model' => Viewings::findOne($viewingId)
                ]);
            } else if (($model = Viewings::findForViewingReport(Yii::$app->user->id)) !== null) {
                return $this->renderAjax('@app/views/parts/viewingReportFormContent', [
                    'model' => $model
                ]);
            }
            return null;
        }
        return null;
    }

    public function actionViewingReportCancellation()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('Viewings')['id'];
            $model = Viewings::findOne($id);
            $model->report_cancellations++;
            $model->report_cancellation_date = date('Y-m-d H:i:s');
            $model->save();
        }
    }

    public function actionViewingReportSave()
    {
        if (Yii::$app->request->isAjax) {
            $postData = Yii::$app->request->post('Viewings');
            $model = Viewings::findOne($postData['id']);
            $model->is_report_complete = 1;
            $model->report_title = $postData['report_title'];
            $model->report_description = $postData['report_description'];
            return $model->save();

        }
        return null;
    }
}
