<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\LoginForm */

echo $this->render('@app/views/modals/_forgotPassword');

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-eye-open form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>SystaVision</b>CRM</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Enter your username and password to start session</p>
        <?php IF ($status == true) {
            echo '<p style="color: red">Sorry. Your account must be activated by manager before you can log in.</p>';
        } ?>
        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>

        <!--div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in
                using Facebook</a>
            <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign
                in using Google+</a>
        </div>
        <!-- /.social-auth-links -->

        <!--a href="#">I forgot my password</a><br-->
        <?= Html::a('Register new account', ['/registration/signup-user'], ['class' => 'text-center']) ?>
        <br/>
        <?= Html::a('Forgot password', '#', ['data-toggle' => 'modal', 'data-target' => '#modal-forgot-password']) ?>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
<style>
    .glyphicon-eye-open {
        pointer-events: auto;
        cursor: pointer;
    }
</style>

<?php
$script = <<<JS
    var pass = $('#loginform-password');
    $('.glyphicon-eye-open').click(function() {
        pass.attr('type', pass.attr('type') === 'password' ? 'text' : 'password');
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY);