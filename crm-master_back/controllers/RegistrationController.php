<?php

namespace app\controllers;


use app\models\admin\dataselect\EmployeesQuantity;
use app\models\LoginForm;
use app\widgets\JavascriptConsole;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use Yii;
use app\models\registration\RegisterUserForm;
use app\models\registration\RegisterCompanyForm;
use app\models\User;
use app\models\Company;
use yii\web\IdentityInterface;


class RegistrationController extends Controller
{

    public $registerUserForm;
    public $registerCompanyForm;

    /**
     * @return null|string|\yii\web\Response
     * @throws Exception
     */
    public function actionSignupUser()
    {
        $this->layout = 'main-login';
        if(!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->registerUserForm = new RegisterUserForm();
        $post = Yii::$app->request->post();
        if ($this->registerUserForm->load($post)) {
                if (!$this->registerUserForm->registerUser()) {
                    $flash = Yii::$app->session->getFlash('registerFail');
                    if ($flash !== '' && $flash!== null) {
                        return $this->render('signup-user', ['model' => $this->registerUserForm]);
                    }
                }

                $user = User::findByEmail($post['RegisterUserForm']['username']);
                if ($identity = User::findIdentity($user->id)) {
                    $identity->setStatusActive();
                    Yii::$app->user->login($identity);
                    $this->redirect(['signup-company', 'username' => $post['RegisterUserForm']['username']]);
                }
        }
        return $this->render('signup-user', [
            'model' => $this->registerUserForm,
        ]);
    }

    public function actionConfirm()
    {
        $this->layout = 'main-login';
        return $this->render('confirm');
    }

    public function actionEmailConfirm()
    {
        $activation_key = Yii::$app->request->get('activation');//var_dump($activation_key);
        if (!$model = User::getByActivationKey($activation_key)) {
            return null;
        }
        $model->setStatusActive();
        return Yii::$app->user->login($model, 3600 * 24 * 30) ? $this->redirect(
            'http://'. SUBDOMAIN_NAME . Yii::$app->request->serverName .
                    '/web/registration/signup-company/?fl=' . $activation_key
        ) : null;
    }

    public function actionSignupCompany()
    {
        $model = new RegisterCompanyForm();
        if ($model->load(Yii::$app->request->post())) {
            $company = $model->registerCompany();
            if ($company = Company::findOne(['company_name' => $company->company_name])) {
                $company->setOwner(Yii::$app->user->getId());
                $this->redirect('http://' . $company->company_name . '.' .
                    Yii::$app->request->serverName . '/web/registration/first-login/');
            }
        }
        $query = ArrayHelper::map(
            EmployeesQuantity::find()
                ->all(), 'id', 'value'
        );
        $this->layout = 'main-login';
        return $this->render('signup-company', [
            'model' => $model,
            'dataProvider' => $query,
        ]);
    }

    public function actionFirstLogin()
    {
        if (Company::isSubdomainUsed() && Company::createViewPath()) {
            Yii::$app->controller->redirect('/login');
        }
        $this->layout = 'main-login';
        return $this->render('first-login');

    }
}