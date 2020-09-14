<?php

namespace app\controllers;

use app\models\Rentals;
use app\models\RentalsSearch;
use app\models\SaleSearch;
use app\models\UserViewing;
use app\modules\lead\models\LeadsSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use yii\helpers\ArrayHelper;
use app\models\UploadForm;
use yii\web\UploadedFile;
use app\models\Contacts;
use app\models\Company;

/**
 * RentalsController implements the CRUD actions for Rentals model.
 */
class RentalsController extends Controller
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
        ];
    }

    /**
     * Lists all Sale models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RentalsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Rentals model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        UserViewing::create(UserViewing::TYPE_SALE, $id);
        $modelGallery = new UploadForm();
        $modelGalleryTwo = new UploadForm();
        $modelContactItems = Contacts::findOne($this->findModel($id)->owner);
        $modelUser = User::findOne($this->findModel($id)->user_id);

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

        $leadViewingSalesSearchModel = new SaleSearch();
        $leadViewingSalesDataProvider = $leadViewingSalesSearchModel->search(Yii::$app->request->queryParams);
        $leadViewingSalesDataProvider->pagination->pageSize = 5;

        $leadViewingRentalsSearchModel = new RentalsSearch();
        $leadViewingRentalsDataProvider = $leadViewingRentalsSearchModel->search(Yii::$app->request->queryParams);
        $leadViewingRentalsDataProvider->pagination->pageSize = 5;

        $leadViewingLeadsSearchModel = new LeadsSearch();
        $leadViewingLeadsDataProvider = $leadViewingLeadsSearchModel->search(Yii::$app->request->queryParams);
        $leadViewingLeadsDataProvider->pagination->pageSize = 5;

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelItemsGallery' => $modelItemsGallery,
            'modelItemsGalleryTwo' => $modelItemsGalleryTwo,
            'modelContactItems' => $modelContactItems,
            'modelUser' => $modelUser,
            'leadViewingSalesSearchModel' => $leadViewingSalesSearchModel,
            'leadViewingSalesDataProvider' => $leadViewingSalesDataProvider,
            'leadViewingRentalsSearchModel' => $leadViewingRentalsSearchModel,
            'leadViewingRentalsDataProvider' => $leadViewingRentalsDataProvider,
            'leadViewingLeadsSearchModel' => $leadViewingLeadsSearchModel,
            'leadViewingLeadsDataProvider' => $leadViewingLeadsDataProvider,
        ]);
    }


    public function actionSlug($slug)
    {
        $model = Rentals::find()->where(['slug' => $slug])->one();
        UserViewing::create(UserViewing::TYPE_SALE, $slug);
        $modelGallery = new UploadForm();
        $modelGalleryTwo = new UploadForm();
        $modelContactItems = Contacts::findOne($model->owner);
        $modelUser = User::findOne($model->user_id);

        $modelItemsGallery = "";
        $modelItemsGalleryTwo = "";


        if (!empty($model->photos)) {
            $modelItemsGallery = explode(',', $model->photos);
            $modelItemsGallery = $modelGallery->imgItemsGallery($modelItemsGallery);
        }
        if (!empty($model->floor_plans)) {
            $modelItemsGalleryTwo = explode(',', $model->floor_plans);
            $modelItemsGalleryTwo = $modelGalleryTwo->imgItemsGallery($modelItemsGalleryTwo);
        }


        if (!is_null($model)) {
            $leadViewingSalesSearchModel = new SaleSearch();
            $leadViewingSalesDataProvider = $leadViewingSalesSearchModel->search(Yii::$app->request->queryParams);
            $leadViewingSalesDataProvider->pagination->pageSize = 5;

            $leadViewingRentalsSearchModel = new RentalsSearch();
            $leadViewingRentalsDataProvider = $leadViewingRentalsSearchModel->search(Yii::$app->request->queryParams);
            $leadViewingRentalsDataProvider->pagination->pageSize = 5;

            $leadViewingLeadsSearchModel = new LeadsSearch();
            $leadViewingLeadsDataProvider = $leadViewingLeadsSearchModel->search(Yii::$app->request->queryParams);
            $leadViewingLeadsDataProvider->pagination->pageSize = 5;
            return $this->render('view', [
                'model' => $model,
                'modelItemsGallery' => $modelItemsGallery,
                'modelItemsGalleryTwo' => $modelItemsGalleryTwo,
                'modelContactItems' => $modelContactItems,
                'modelUser' => $modelUser,
                'leadViewingSalesSearchModel' => $leadViewingSalesSearchModel,
                'leadViewingSalesDataProvider' => $leadViewingSalesDataProvider,
                'leadViewingRentalsSearchModel' => $leadViewingRentalsSearchModel,
                'leadViewingRentalsDataProvider' => $leadViewingRentalsDataProvider,
                'leadViewingLeadsSearchModel' => $leadViewingLeadsSearchModel,
                'leadViewingLeadsDataProvider' => $leadViewingLeadsDataProvider,
            ]);

        } else {
            return $this->redirect('/rentals/index');
        }
    }

    /**
     * Creates a new Rentals model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Rentals();
        $modelImg = new UploadForm();
        $modelImg->name = 'imageFiles';
        $modelImgTwo = new UploadForm();
        $modelImgTwo->name = 'imageFilesTwo';
        $companyId = Company::getCompanyIdBySubdomain(); 

        if ($companyId == 'main' ) {
            $modelUser = User::find()->all();
            $modelContactItems = Contacts::find()->all();
        } else {   
            $modelUser = User::find()->where([
                'company_id' => $companyId
            ])->all();
            
            $modelContactItems = Contacts::find()->where([
                'company_id' => $companyId
            ])->all();
        }
        
        $modelUser = ArrayHelper::map($modelUser, 'id', 'username');
        $modelContactItems = ArrayHelper::map($modelContactItems, 'id', 'last_name');

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
                
                if ($companyId == 'main') {
                    $model->company_id = 0;
                } else {   
                    $model->company_id = $companyId;
                }   
                
                $model->ref = "ki-r-$model->id";
                $model->save();

                return $this->redirect(['view', 'id' => $model->id]);
            }

        }

        return $this->render('create', [
            'model' => $model,
            'modelUser' => $modelUser,
            'modelImg' => $modelImg,
            'modelImgTwo' => $modelImgTwo,
            'modelContactItems' => $modelContactItems,

        ]);
    }

    /**
     * Updates an existing Rentals model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelImg = new UploadForm();
        $modelImg->name = 'imageFiles';
        $modelImgTwo = new UploadForm();
        $modelImgTwo->name = 'imageFilesTwo';
        $modelContactItems = Contacts::find()->all();
        $modelUser = User::find()->all();

        $modelContactItems = ArrayHelper::map($modelContactItems, 'id', 'last_name');
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
            'modelContactItems' => $modelContactItems,
        ]);
    }

    /**
     * Deletes an existing Rentals model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Rentals model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Rentals the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rentals::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
