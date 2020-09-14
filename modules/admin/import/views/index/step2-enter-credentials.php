<?php $this->title = Yii::t('app', 'Import - enter credentials');
$this->params['breadcrumbs'][] = $this->title; ?>

<?php
$loadingScript = <<<JS
    loading = $('#loadingDiv').hide();
    $('#getInfo').click(function() {
        loading.show();
        $.ajax({
            type: 'GET',
            url:  'get-info',
            data: { link: '' },
            dataType: 'script',
            success: function(response) {
                        loading.hide();
                        console.log(response.data)
        }
    })
    });
JS;
$loadingCss = <<<CSS
    #loadingDiv {
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
        position: relative;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
CSS;
?>

<?php $this->registerCss($loadingCss); ?>
<?php $this->registerJs($loadingScript) ?>

<?php $form = \yii\widgets\ActiveForm::begin(); ?>
<?= $form->field($model, 'clientId')
    ->textInput(['type' => 'integer', 'placeholder' => 'Client id'])
    ->label('Propspace client id') ?>
<?= $form->field($model, 'username')
    ->textInput(['placeholder' => 'Username'])
    ->label('Propspace username') ?>
<?= $form->field($model, 'password')
    ->textInput(['placeholder' => 'Password', 'type' => 'password'])
    ->label('Propspace password') ?>

<?= \yii\helpers\Html::submitButton('Get my info', ['class' => 'btn btn-primary', 'id' => 'getInfo']) ?>
<?php \yii\widgets\ActiveForm::end() ?>

<div id="loadingDiv"></div>