<?php

namespace app\controllers;

use app\models\Profile;
use app\models\User;
use Yii;
use app\models\UserProfile;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\UploadForm;
use yii\web\UploadedFile;

/**
 * ProfileController implements the CRUD actions for UserProfile model.
 */
class ProfileController extends Controller
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
     * @return string
     */
    public function actionView()
    {
        $id = Yii::$app->request->get('id');
        $model = UserProfile::findOne(['id' => $id]);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new UserProfile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserProfile();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionUpdate()
    {
        $id = Yii::$app->request->get('id');
        $model = UserProfile::find()->where(['id' => $id])->one();
        $modelImg = new UploadForm();
        $modelImg->name = 'imageFiles';

       /* if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }*/

        $modelImg->imageFiles = UploadedFile::getInstances($modelImg, 'imageFiles');

        if (!empty($modelImg->imageFiles[0]->name)) {
            $model->watermark = $modelImg->imageFiles[0]->name;
            $model->save();
        }

        $modelImg->uploadOneFile($modelImg->imageFiles);
        return $this->render('update', [
            'model' => $model,
            'modelImg' => $modelImg,
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

    /**
     * Finds the UserProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if ($model = UserProfile::findOne($id)) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
