<?php

namespace app\modules\profileCompany\controllers;

use Yii;
use app\modules\profileCompany\models\ProfileCompany;
use app\modules\profileCompany\models\ProfileCompanySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Company;
use yii\web\UploadedFile;
use app\models\uploadfile\UploadForm;
use yii\filters\AccessControl;

/**
 * ProfileCompanyController implements the CRUD actions for ProfileCompany model.
 */
class ProfileCompanyController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ["Owner"],
                    ],
                    [
                        'allow' => true,
                        'roles' => ["Admin"],
                    ],
                ],
            ],
        ];
    }

    
    /**
     * Lists all ProfileCompany models.
     * @return mixed
     */
    public function actionIndex()
    {
        $companyId = Company::getCompanyIdBySubdomain();
        $modelImg  = new UploadForm();

        if (ProfileCompany::findOne(['company_id' => $companyId]) == null) {
            $model = new ProfileCompany();
        } else {
            $model = ProfileCompany::findOne(['company_id' => $companyId]);
        }


        if ($model->load(Yii::$app->request->post())) {
            $logo      = UploadedFile::getInstances($model, 'logo');
            $watermark = UploadedFile::getInstances($model, 'watermark');  
            if ($logo) {
                $model->logo = $modelImg->upload($logo[0]->name, $logo[0]); 
            } 
            if ($watermark) {
                $model->watermark = $modelImg->upload($watermark[0]->name, $watermark[0]); 
            }

            $model->company_id = $companyId;
            $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('index', [
            'model'        => $model,
            'modelImg'     => $modelImg,
            'companyToken' => Company::getCompanyToken()
        ]);
    }

    /**
     * This method deletes image of company profile
     *
     * @return bool
     */
    public function actionDropImg() {
        $companyId = Yii::$app->request->post('companyId');
        $typeImage = Yii::$app->request->post('typeImage');

        if (empty($companyId) || empty($typeImage)) {
            return false;
        }

        $model = ProfileCompany::find()
            ->where(['company_id' => $companyId])
            ->one();

        unlink(Yii::getAlias('@app') . $model->{$typeImage});

        $model->{$typeImage} = null;
        $model->save();

        return true;
    }
}
