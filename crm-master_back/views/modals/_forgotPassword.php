<?php
use yii\bootstrap\Modal;
use yii\web\View;
use yii\helpers\{
    Html, Url
};

$urlResetPassword = Url::to(['/site/reset-password']);

Modal::begin([
    'id'     => 'modal-forgot-password',
    'header' => '<h4>' . Yii::t('app', 'Forgot password') . '</h4>'
]);
?>
<div class="form-group">
    <?= Html::input('text', '', '', ['id' => 'forgot-password-username', 'class' => 'form-control', 'placeholder' => 'Username'])?>
</div>
<div class="form-group">
    <?= Html::button('Reset', ['class' => 'btn btn-success', 'id' => 'btn-reset-password'])?>
</div>
<?php
Modal::end();

$script = <<<js
$(document).ready(function() {
    var urlResetPassword = "$urlResetPassword";

    $('body').on('click', '#btn-reset-password', function() {
        var username = $('#forgot-password-username').val();

        if (!username) {
            alert('Enter username');
            return false;
        }

        $.ajax({
            url: urlResetPassword,
            type: 'POST',
            data: {
                username: username
            },
            beforeSend: function() {
                startLoadingProcess();
            },
            complete: function() {
                finishLoadingProcess();
            },
            success: function(response) {
                alert(response.msg)
            }
        })
    })
})
js;

$this->registerJs($script, View::POS_READY);
?>
