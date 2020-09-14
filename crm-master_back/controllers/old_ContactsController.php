<?php

namespace app\controllers;

use Yii;
use app\models\Contacts;
use app\models\admin\dataselect\Nationalities;
use app\models\admin\dataselect\Title;
use app\models\admin\dataselect\Religion;
use app\models\admin\dataselect\ContactSource;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\UploadForm;
use yii\web\UploadedFile;
use app\models\User;
use app\models\Company;


/**
 * ContactsController implements the CRUD actions for Contacts model.
 */
class ContactsController extends Controller
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
     * Lists all Contacts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContactsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $nationModel = new Nationalities();
        $religionModel = new Religion();
        $ContactSoursModel = new ContactSource();
        $titleModel = new Title();

        $nationalities = ArrayHelper::map(Nationalities::find()->all(), 'id', 'national');
        $titles = ArrayHelper::map(Title::find()->all(), 'id', 'titles');
        $religions = ArrayHelper::map(Religion::find()->all(), 'id', 'religions');
        $sources = ArrayHelper::map(ContactSource::find()->all(), 'id', 'source');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'nationModel' => $nationModel,
            'religionModel' => $religionModel,
            'ContactSoursModel' => $ContactSoursModel,
            'titleModel' => $titleModel,
            'nationalities' => $nationalities,
            'titles' => $titles,
            'religions' => $religions,
            'sources' => $sources,
            'users' => User::find()->all(),
            'contactType' => array(
                'Tenant'         => 'Tenant',
                'Buyer'          => 'Buyer',
                'LandLord'       => 'LandLord',
                'Seler'          => 'Seler',
                'LandLord+Seler' => 'LandLord+Seler'
            ),
            'genderList' => array(
                'Male'   => Yii::t('app', 'Male'),
                'Female' => Yii::t('app', 'Female')
            )
        ]);
    }

    /**
     * Displays a single Contacts model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;

        $nationModel = "";
        $religionModel = "";
        $ContactSoursModel = "";
        $titleModel = "";
        $model = $this->findModel($id);

        $modelUser = User::findOne($model->assigned_to);


        if ($model->nationalities) {
            $idNational = $model->nationalities;
            $nationalities = Nationalities::findOne($idNational);
            $nationModel = $nationalities->national;
        }
        if ($model->religion) {
            $idReligion = $model->religion;
            $religion = Religion::findOne($idReligion);
            $religionModel = $religion->religions;
        }
        if ($model->contact_source) {
            $idContact = $model->contact_source;
            $contactSours = ContactSource::findOne($idContact);
            $ContactSoursModel = $contactSours->source;
        }
        if ($model->title) {
            $idTitle = $model->title;
            $title = Title::findOne($idTitle);
            $titleModel = $title->titles;
        }

        $data = [
            'model' => $model,
            'nationModel' => $nationModel,
            'religionModel' => $religionModel,
            'ContactSoursModel' => $ContactSoursModel,
            'titleModel' => $titleModel,
            'modelUser' => $modelUser,
            'urlUpdate' => Yii::$app->getUrlManager()->createUrl(['contacts/update', 'id' => $model->id])
        ];

        if ($request->isPost) {
            \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;

            return $data;
        } else {
            return $this->render('view', $data);
        }
    }

     public function actionSlug($slug)
    { 
        $model = Contacts::find()->where(['slug' => $slug])->one();
        $modelUser = User::findOne($model->assigned_to);
        $nationModel = "";
        $religionModel = "";
        $ContactSoursModel = "";
        $titleModel = "";


        if ($model->nationalities) {
            $idNational = $model->nationalities;
            $nationalities = Nationalities::findOne($idNational);
            $nationModel = $nationalities->national;
        }
        if ($model->religion) {
            $idReligion = $model->religion;
            $religion = Religion::findOne($idReligion);
            $religionModel = $religion->religions;
        }
        if ($model->contact_source) {
            $idContact = $model->contact_source;
            $contactSours = ContactSource::findOne($idContact);
            $ContactSoursModel = $contactSours->source;
        }
        if ($model->title) {
            $idTitle = $model->title;
            $title = Title::findOne($idTitle);
            $titleModel = $title->titles;
        }

        return $this->render('view', [
            'model' => $model,
            'nationModel' => $nationModel,
            'religionModel' => $religionModel,
            'ContactSoursModel' => $ContactSoursModel,
            'titleModel' => $titleModel,
            'modelUser' => $modelUser,
        ]);
    }

    /**
     * Creates a new Contacts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Contacts();
        $modelImg = new UploadForm();
        $modelContactItems = Contacts::find()->all();
        $companyId = Company::getCompanyIdBySubdomain(); 
        
        if ($companyId == 'main' ) {
            $modelUser = User::find()->all();
        } else {   
            $modelUser = User::find()->where([
                'company_id' => $companyId
            ])->all();
        }
        $modelUser = ArrayHelper::map($modelUser, 'id', 'username');

        $modelImg->name = 'imageFiles';

        $nationalitiesModel = Nationalities::find()->all();
        $titlesModel = Title::find()->all();
        $religionModel = Religion::find()->all();
        $sourceModel = ContactSource::find()->all();

        $nationModel = ArrayHelper::map($nationalitiesModel, 'id', 'national');
        $titlesModel = ArrayHelper::map($titlesModel, 'id', 'titles');
        $religionModel = ArrayHelper::map($religionModel, 'id', 'religions');
        $sourceModel = ArrayHelper::map($sourceModel, 'id', 'source');
        $companyId = Company::getCompanyIdBySubdomain();
        
        if ($model->load(Yii::$app->request->post())) {

            $modelImg->imageFiles = UploadedFile::getInstances($modelImg, 'imageFiles');

            if (!empty($modelImg->imageFiles[0]->name)) {
                $model->avatar = $modelImg->imageFiles[0]->name;
            }

            $modelImg->uploadOneFile($modelImg->imageFiles);

            if ($model->save()) {  
                
                if ($companyId == 'main') {
                    $model->company_id = 0;
                } else {   
                    $model->company_id = $companyId;
                }
                
                $model->ref = "ki-o-$model->id";
                $model->save();
          
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'nationModel' => $nationModel,
            'titlesModel' => $titlesModel,
            'religionModel' => $religionModel,
            'sourceModel' => $sourceModel,
            'modelImg' => $modelImg,
            'modelUser' => $modelUser,
        ]);
    }

    /**
     * Updates an existing Contacts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelImg = new UploadForm();
        $modelUser = User::find()->all();

        $modelImg->name = 'imageFiles';
        $modelUser = ArrayHelper::map($modelUser, 'id', 'username');

        $nationalities = ArrayHelper::map(Nationalities::find()->all(), 'id', 'national');
        $titles = ArrayHelper::map(Title::find()->all(), 'id', 'titles');
        $religions = ArrayHelper::map(Religion::find()->all(), 'id', 'religions');
        $sources = ArrayHelper::map(ContactSource::find()->all(), 'id', 'source');


        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $modelImg->imageFiles = UploadedFile::getInstances($modelImg, 'imageFiles');

            if (!empty($modelImg->imageFiles[0]->name)) {
                $model->avatar = $modelImg->imageFiles[0]->name;
                $model->save();
            }

            $modelImg->uploadOneFile($modelImg->imageFiles);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelImg' => $modelImg,
            'nationalities' => $nationalities,
            'titles' => $titles,
            'religions' => $religions,
            'sources' => $sources,
            'users' => $modelUser,
            'contactType' => array(
                'Tenant'         => 'Tenant',
                'Buyer'          => 'Buyer',
                'LandLord'       => 'LandLord',
                'Seler'          => 'Seler',
                'LandLord+Seler' => 'LandLord+Seler'
            ),
            'genderList' => array(
                'Male'   => Yii::t('app', 'Male'),
                'Female' => Yii::t('app', 'Female')
            )
        ]);
    }

    /**
     * Deletes an existing Contacts model.
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
     * Finds the Contacts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contacts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contacts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
