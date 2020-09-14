<?php

namespace app\controllers;

use app\components\AccessCheckBehavior;
use app\models\DocumentsGenerated;
use app\models\Viewings;
use yii\helpers\{ArrayHelper, Url, Json, FileHelper};
use kartik\mpdf\Pdf;
use app\models\EmailImportLead;
use app\models\TaskManager;
use app\modules\admin\import\models\InitImport;
use app\modules\admin\import\models\LeadsImport;
use app\modules\admin\Rbac;
use app\modules\lead\models\PropertyRequirement;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use Yii;
use app\models\RegistrationForm;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use app\models\LoginForm;
use app\models\admin\rights\AuthAssignment;
use app\models\TaskManagerSearch;
use app\models\MailerForm;
use app\components\ControllerHelper;
use app\modules\admin\import\models\Curl;
use app\models\Sale;
use app\models\Rentals;
use app\models\Company;
use app\models\User as UserModel;
use app\models\Reminder;
use app\modules\calendar\models\Event;
use yii\data\Pagination;
use yii\web\User;
use app\modules\profileCompany\models\ProfileCompany;
use yii\base\Security;

class SiteController extends Controller
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
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        Yii::$app->name = 'SystaVision CRM';
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $companyIdBySubdomain = Company::getCompanyIdBySubdomain();
        $salesByMonth = Sale::getSalesByMonth();
        $rentalsByMonth = Rentals::getRentalsByMonth();
        $sales['sale'] = ArrayHelper::map($salesByMonth, 'month', 'countByMonth');
        $rentals['rental'] = ArrayHelper::map($rentalsByMonth, 'month', 'countByMonth');
        $jsonSalesRentalsByMonth = json_encode(array_merge($sales, $rentals));

        $leadersSaleQuery = UserModel::find()
            ->select(['user.username AS username', 'COUNT(*) AS countDeals'])
            ->leftJoin('sale', 'user.id = sale.user_id')
            ->where(['sale.company_id' => $companyIdBySubdomain])
            ->andWhere(['user.company_id' => $companyIdBySubdomain])
            ->groupBy(['user.id'])
            ->orderBy(['countDeals' => SORT_DESC])
            ->limit(10);
        $leadersRentalsQuery = UserModel::find()
            ->select(['user.username AS username', 'COUNT(*) AS countDeals'])
            ->leftJoin('rentals', 'user.id = rentals.user_id')
            ->where(['rentals.company_id' => $companyIdBySubdomain])
            ->andWhere(['user.company_id' => $companyIdBySubdomain])
            ->groupBy(['user.id'])
            ->orderBy(['countDeals' => SORT_DESC])
            ->limit(10);

        $leaders = $leadersSaleQuery->union($leadersRentalsQuery)->all();
        $leaders = array_slice(ArrayHelper::map($leaders, 'username', 'countDeals'), 0, 10);

        $reminderQuery = Reminder::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->orderBy(['remind_at_time'=> SORT_DESC, 'created_at'=> SORT_DESC]);
        $reminderPages = new Pagination(['totalCount' => $reminderQuery->count(), 'pageSize' => 6]);
        $reminders = $reminderQuery->offset($reminderPages->offset)
            ->limit($reminderPages->limit)
            ->all();

        $daysStartEvents = [];
        
        // Event::find()
        //     ->select(['event.start'])
        //     ->leftJoin('user', 'user.id = event.owner_id')
        //     ->where(['user.company_id' => $companyIdBySubdomain])
        //     ->groupBy(['DATE(FROM_UNIXTIME(event.start))'])
        //     ->all();

        $taskQuery = TaskManagerSearch::getQueryByCompanyRolesGroups();
        $tasksCalendar = $taskQuery->all();
        $taskPages = new Pagination(['totalCount' => $taskQuery->count(), 'pageSize' => 8]);
        $tasks = $taskQuery->offset($taskPages->offset)
            ->limit($taskPages->limit)
            ->all();

        $viewingsCalendar = Viewings::getViewings();

        if (Yii::$app->request->get('new_design') == 1) {
            $this->layout = 'new_design/main.php';
        }
        $searchModel = new TaskManagerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $modelMailer = new MailerForm();

        if ($modelMailer->load(Yii::$app->request->post()) && $modelMailer->sendEmail()) {
            Yii::$app->session->setFlash('mailerFormSubmitted');
            return $this->refresh();
        }

        if (Yii::$app->user->isGuest) {
            $this->redirect(['login']);
        }
        echo Yii::$app->session->getFlash('devAssigned');

        return $this->render('index', [
            'searchModel'     => $searchModel,
            'dataProvider'    => $dataProvider,
            'modelMailer'     => $modelMailer,
            'jsonSalesRentalsByMonth' => $jsonSalesRentalsByMonth,
            'leadersJson'     => json_encode($leaders),
            'reminders'       => $reminders,
            'reminderPages'   => $reminderPages,
            'tasks'           => $tasks,
            'taskPages'       => $taskPages,
            'daysStartEvents' => $daysStartEvents,
            'tasksCalendar'   =>  $tasksCalendar,
            'viewingsCalendar' =>  $viewingsCalendar,
        ]);
    }

    /**
     * share preview brochure
     */
    public function actionShareBrochure()
    {
        $request  = Yii::$app->request;
        $postData = $request->post();
        $items    = json_decode($postData['items']);
        $email    = $postData['email'];

        if ($request->isPost) {
            foreach($items as $ref) {
                $model = Rentals::findOne(['ref' => $ref]);

                if (!$model) {
                    $model = Sale::findOne(['ref' => $ref]);
                    $type = Yii::t('app', 'Sale');
                } else {
                    $type = Yii::t('app', 'Rental');
                }

                $content = $this->render('/pdf/brochure', [
                    'model'        => $model,
                    'type'         => $type,
                    'user'         => UserModel::findOne(Yii::$app->user->id),
                    'agentDetails' => ''
                ]);

                $pdf = new Pdf([
                    // set to use core fonts only
                    'mode' => Pdf::MODE_CORE,
                    // A4 paper format
                    'format' => Pdf::FORMAT_A4,
                    // portrait orientation
                    'orientation' => Pdf::ORIENT_LANDSCAPE,
                    // stream to browser inline
                    'destination' => Pdf::DEST_DOWNLOAD,//DEST_BROWSER
                    // your html content input
                    //'content' => $content,
                    // format content from your own css file if needed or use the
                    // enhanced bootstrap css built by Krajee for mPDF formatting
                    'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
                    // any css to be embedded if required
                    'cssInline' => '',
                    // set mPDF properties on the fly
                    'options' => ['title' => ''],
                    // call mPDF methods on the fly
                    'methods' => [
                        'SetHeader'=>[''],
                        'SetFooter'=>['{PAGENO}'],
                    ]
                ]);

                $fileName   = "Brochure_" . $model->ref . "_" . uniqid() . ".pdf";
                $pathUpload = Yii::getAlias('@webroot') . '/files/generated/pdf/';
                FileHelper::createDirectory($pathUpload);

                $mpdf = $pdf->api;
                $mpdf->WriteHTML($content);
                $mpdf->Output($pathUpload . $fileName, 'F');
                $toZip[] = array(
                    'path' => $pathUpload,
                    'name' => $fileName
                );
            }

            if (count($toZip) > 0) {
                $zip        = new \ZipArchive();
                $zipName   = uniqid() . ".zip";
                $zipUpload = Yii::getAlias('@webroot') . '/files/generated/archive/';
                FileHelper::createDirectory($zipUpload);

                if ($zip->open($zipUpload . $zipName, \ZipArchive::CREATE) === TRUE) {
                    foreach($toZip as $tZ) {
                        $zip->addFile($tZ['path'] . $tZ['name'], $tZ['name']);
                    }

                    $zip->close();

                    foreach($toZip as $tZ) {
                        unlink($tZ['path'] . $tZ['name']);
                    }

                    DocumentsGenerated::add($zipName, Yii::getAlias('@web') . '/files/generated/archive/', Yii::$app->user->id);

                    Yii::$app->mailer->compose()
                        ->setFrom('no-reply@' . $_SERVER['SERVER_NAME'])
                        ->setTo($email)
                        ->setSubject(Yii::t('app', 'Pdf brochure'))
                        ->setHtmlBody("")
                        ->attach(Yii::getAlias('@webroot') . '/files/generated/archive/' . $zipName)
                        ->send();

                    unlink(Yii::getAlias('@webroot') . '/files/generated/archive/' . $zipName);
                }
            }
        }

        return $this->asJson([
            'msg' =>  Yii::t('app', 'Brochure send')
        ]);
    }

    public function actionResetPassword()
    {
        $data = Yii::$app->request->post();
        $user = UserModel::findOne(['username' => $data['username']]);

        if ($user) {
            $security = new Security();
            $password = $security->generateRandomString(6);

            $msg = $_SERVER['SERVER_NAME'] . "
            <br/>
            This user has requested a new password: " . $user->username . "
            <br/>
            The new password is: " . $password . "
            <br/>

            We wish you a great day,
            <br/>
            est8.world support team";

            Yii::$app->mailer->compose()
                ->setFrom('no-reply@' . $_SERVER['SERVER_NAME'])
                ->setTo('haider.ali@valorem.ae')
                ->setSubject(Yii::t('app', 'Reset password'))
                ->setHtmlBody($msg)
                ->send();


            $user->setPassword($password);
            $user->save();

            $msg = Yii::t('app', 'Password was reset');
        } else {
            $msg = Yii::t('app', 'Username does not exists');
        }



        return $this->asJson([
            'msg' => $msg
        ]);
    }

    /**
     * share preview links to listings
     */
    public function actionSharePreviewLinks()
    {
        $request      = Yii::$app->request;
        $postData     = $request->post();
        $items        = json_decode($postData['items']);
        $email        = $postData['email'];
        $baseUrl      = str_replace('/web', '', Url::base(true));
        $previewLinks = [];

        foreach ($items as $item) {
            $url = $baseUrl . Yii::$app->getUrlManager()->createUrl(['preview/' . $item]);
            array_push($previewLinks, "<a href='$url'>" . $item . "</a>");
        }

        Yii::$app->mailer->compose()
            ->setFrom('no-reply@' . $_SERVER['SERVER_NAME'])
            ->setTo($email)
            ->setSubject(Yii::t('app', 'Preview links'))
            ->setHtmlBody(implode(";", $previewLinks))
            ->send();

        return $this->asJson([
                'msg' => Yii::t('app', 'Preview links send')
        ]);
    }

    /**
     * @return string|Response
     * @throws \yii\base\Exception
     */
    public function actionLogin()
    {
        $statusDisabled = false;
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if (Yii::$app->request->get('status') == 2) {
            $statusDisabled = true;
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }
        $this->layout = 'main-login';
        return $this->render('login', [
            'model' => $model,
            'status' => $statusDisabled,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect('/login');
    }

    /**
     * @return string|Response
     */
    public function actionSignup()
    {
        $model = new RegistrationForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->register()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }
        $this->layout = 'main-login';
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionDevInit()
    {
        $controller = new ControllerHelper();
        $controller->setIgnoreItems(['test', 'devinit', 'site']);
        $controller->save();

        $assignment = AuthAssignment::findOne(['user_id' => 1]);
        if ($assignment->item_name !== Rbac::ROLE_DEVELOPER) {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole(Rbac::ROLE_DEVELOPER);
            if ($auth->assign($role, 1)) {
                echo 'Account assigned.';
                return;
            }
        }
        echo 'Account has been assigned already.';
        return;
    }

    public function actionTest()
    {
        echo date('Y-m');
        $task = TaskManager::findOne(1);
        echo date('Y-m', $task->deadline);
        $time = time();
        $specificTime = strtotime('today 17:34');
        if ($time>$specificTime) echo 'yessssssss'; else echo 'nooo';
    }
}