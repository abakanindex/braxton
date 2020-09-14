<?php

namespace app\controllers;

use app\components\widgets\DocumentsWidget;
use app\models\DocumentsGenerated;
use Yii;
use app\models\Document;
use app\models\DocumentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\validators\FileValidator;
use yii\db\Expression;

/**
 * DocumentsController implements the CRUD actions for Document model.
 */
class DocumentsController extends Controller
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

    public function actionDownload($id)
    {
        $document = Document::findOne($id);
        $path = Yii::getAlias('@app') . $document->path;

        if(file_exists($path) && ($document->user_id == Yii::$app->user->id || Yii::$app->user->can('Admin'))) {
            return Yii::$app->response->sendFile($path);
        } else {
            throw new NotFoundHttpException();
        }
    }

    public function actionDownloadPdf($name)
    {
        if (DocumentsGenerated::getForUser($name, Yii::$app->user->id))
            return Yii::$app->response->sendFile(Yii::getAlias('@app') . '/web/files/generated/pdf/' . $name);
    }

    public function actionDownloadPdfZip($name)
    {
        if (DocumentsGenerated::getForUser($name, Yii::$app->user->id))
            return Yii::$app->response->sendFile(Yii::getAlias('@app') . '/web/files/generated/archive/' . $name);
    }

    public function actionDownloadXls($name)
    {
        if (DocumentsGenerated::getForUser($name, Yii::$app->user->id))
            return Yii::$app->response->sendFile(Yii::getAlias('@app') . '/web/files/generated/xls/' . $name);
    }

    /**
     * Lists all Document models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocumentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Document model.
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
     * Creates a new Document model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Document();
        $request = Yii::$app->request;
        $postData = $request->post();
        $model->load($postData);
        $files = UploadedFile::getInstances($model, 'files');

        if ($request->isPost) {
            $model->upload($files, $postData);
        }

        return DocumentsWidget::widget(['model' => new Document(), 'ref' => $model->ref, 'keyType' => $postData['keyType']]);
    }

    /**
     * Updates an existing Document model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Document model.
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
     * Finds the Document model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Document the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Document::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
