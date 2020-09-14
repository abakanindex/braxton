<?php

namespace app\controllers;

use Yii;
use app\models\CommercialRentals;
use app\models\CommercialRentalsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use yii\helpers\ArrayHelper;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * CommercialRentalsController implements the CRUD actions for CommercialRentals model.
 */
class CommercialRentalsController extends Controller
{
    /**
     * @inheritdoc
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
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'create', 'update', 'view', 'delete'],
                'rules' => [
                    [
                        'allow'       => true,
                        'actions'     => ['index'],
                        'permissions' => ['commercialrentalsView'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['create'],
                        'permissions' => ['commercialrentalsCreate'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['update'],
                        'permissions' => ['commercialrentalsUpdate'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['view'],
                        'permissions' => ['commercialrentalsView'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['delete'],
                        'permissions' => ['commercialrentalsDelete'],
                        'roles'       => ['Owner']
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all CommercialRentals models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CommercialRentalsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CommercialRentals model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $modelGallery = new UploadForm();
        $modelGalleryTwo = new UploadForm();
        $modelItemsGallery = "";
        $modelItemsGalleryTwo = "";

        if (!empty($this->findModel($id)->photos)) {
            $modelItemsGallery = explode(',', $this->findModel($id)->photos);
            $modelItemsGallery = $modelGallery->imgItemsGallery($modelItemsGallery);
        }
        if (!empty($this->findModel($id)->floor_plans)) {
            $modelItemsGalleryTwo = explode(',', $this->findModel($id)->floor_plans);
            $modelItemsGalleryTwo = $modelGalleryTwo->imgItemsGallery($modelItemsGalleryTwo);
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelItemsGallery' => $modelItemsGallery,
            'modelItemsGalleryTwo' => $modelItemsGalleryTwo,
        ]);
    }

    /**
     * Creates a new CommercialRentals model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CommercialRentals();
        $modelImg = new UploadForm();
        $modelImg->name = 'imageFiles';
        $modelImgTwo = new UploadForm();
        $modelImgTwo->name = 'imageFilesTwo';
        $modelUser = User::find()->all();
        $modelUser = ArrayHelper::map($modelUser, 'id', 'username');

        if ($model->load(Yii::$app->request->post())) {

            if (!empty($model->portals)) {
                $model->portals = implode(',', $model->portals);
            }
            if (!empty($model->features)) {
                $model->features = implode(',', $model->features);
            }

            $modelImg->imageFiles = UploadedFile::getInstances($modelImg, 'imageFiles');
            $modelImgTwo->imageFilesTwo = UploadedFile::getInstances($modelImgTwo, 'imageFilesTwo');

            if (!empty($modelImg->imageFiles)) {
                $model->photos = implode(',', $modelImg->imageFiles);
            }
            if (!empty($modelImgTwo->imageFilesTwo)) {
                $model->floor_plans = implode(',', $modelImgTwo->imageFilesTwo);
            }

            $modelImg->upload($modelImg->imageFiles);
            $modelImgTwo->upload($modelImgTwo->imageFilesTwo);


            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }

        return $this->render('create', [
            'model' => $model,
            'modelUser' => $modelUser,
            'modelImg' => $modelImg,
            'modelImgTwo' => $modelImgTwo,

        ]);
    }

    /**
     * Updates an existing CommercialRentals model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelImg = new UploadForm();
        $modelImg->name = 'imageFiles';
        $modelImgTwo = new UploadForm();
        $modelImgTwo->name = 'imageFilesTwo';
        $modelUser = User::find()->all();
        $modelUser = ArrayHelper::map($modelUser, 'id', 'username');

        if (!empty($model->photos)) {
            $modelImg->imageFiles = explode(',', $model->photos);
        }

        if (!empty($model->floor_plans)) {
            $modelImgTwo->imageFilesTwo = explode(',', $model->floor_plans);
        }
        if (!empty($model->portals)) {
            $model->portals = explode(',', $model->portals);
        }
        if (!empty($model->features)) {
            $model->features = explode(',', $model->features);

        }

        if ($model->load(Yii::$app->request->post())) {

            if (!empty($model->portals)) {
                $model->portals = implode(',', $model->portals);
            }
            if (!empty($model->features)) {
                $model->features = implode(',', $model->features);
            }

            $modelImg->imageFiles = UploadedFile::getInstances($modelImg, 'imageFiles');
            $modelImgTwo->imageFilesTwo = UploadedFile::getInstances($modelImgTwo, 'imageFilesTwo');

            if (!empty($modelImg->imageFiles)) {
                $model->photos = implode(',', $modelImg->imageFiles);
            }
            if (!empty($modelImgTwo->imageFilesTwo)) {
                $model->floor_plans = implode(',', $modelImgTwo->imageFilesTwo);
            }

            $modelImg->upload($modelImg->imageFiles);
            $modelImgTwo->upload($modelImgTwo->imageFilesTwo);


            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }

        return $this->render('update', [
            'model' => $model,
            'modelUser' => $modelUser,
            'modelImg' => $modelImg,
            'modelImgTwo' => $modelImgTwo,
        ]);
    }

    /**
     * Deletes an existing CommercialRentals model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CommercialRentals model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CommercialRentals the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CommercialRentals::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
