<?php

use app\components\widgets\PersonalAssistantWidget;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'SystaVision CRM';
?>
<!--    Info Blocks      -->
<!-- <div class="container-fluid content">
    <div class="col-xs-11 col-sm-5 col-md-5 col-lg-3 info-block ">
        <div class="icon-info-block">
            <i class="fa fa-archive" aria-hidden="true"></i>
        </div>
        <div class="data-info-block">
            <p class="info-block-count">150</p>
            <p class="info-block-text">New Property</p>
            <a href="#">More info <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
        </div>
    </div>

    <div class="col-xs-11 col-sm-5 col-md-5 col-lg-3 info-block">
        <div class="icon-info-block">
            <i class="fa fa-users" aria-hidden="true"></i>

        </div>
        <div class="data-info-block">
            <p class="info-block-count">44</p>
            <p class="info-block-text">User Registration</p>
            <a href="#">More info <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
        </div>
    </div>

    <div class="col-xs-11 col-sm-5 col-md-5 col-lg-3 info-block">
        <div class="icon-info-block">
            <i class="fa fa-comment-o" aria-hidden="true"></i>

        </div>
        <div class="data-info-block">
            <p class="info-block-count">65</p>
            <p class="info-block-text">Messages</p>
            <a href="#">More info <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
        </div>
    </div>
</div>   /Info Blocks      -->
<div class="container-fluid content" style="margin-top: 40px">
    <?= PersonalAssistantWidget::widget() ?>
</div>
<!--    Action Blocks      -->
<div class="container-fluid content">

    <!--    Tasks Block      -->
    <div class="col-xs-11 col-sm-5 col-md-5 action-block">
        <div class="headline">
            <a class="btn btn-default pull-right" type="button" href="/web/task-manager/create"><i
                        class="fa fa-plus"></i> Add task</a>
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'title',
                'deadline',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update}',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a(
                                '<i class="fa fa-eye"></i>',
                                '/web/task-manager/view?id=' . $model->id
                            );
                        },
                        'update' => function ($url, $model, $key) {
                            return Html::a(
                                '<i class="fa fa-pencil"></i>',
                                '/web/task-manager/update?id=' . $model->id
                            );
                        },
                    ],
                ],
            ],
        ]); ?>

    </div><!--    /Tasks Block      -->

    <!--    Email Block      -->
    <div class="col-xs-11 col-sm-5 col-md-5 action-block">
        <div class="headline">
            <div>Quick Email</div>
            <a class="pull-right" href="#"><i class="fa fa-times"></i></a>
        </div>
        <?php $form = ActiveForm::begin(['id' => 'mailer-form']); ?>
        <div class="form-group">
            <?= $form->field($modelMailer, 'fromName') ?>
        </div>
        <div class="form-group col-xs-6 padding-right">
            <?= $form->field($modelMailer, 'fromEmail') ?>
        </div>
        <div class="form-group col-xs-6 padding-left">
            <?= $form->field($modelMailer, 'toEmail') ?>
        </div>
        <div class="form-group">
            <?= $form->field($modelMailer, 'subject') ?>
        </div>
        <div class="form-group">
            <?= $form->field($modelMailer, 'body')->textArea(['rows' => 6]) ?>
        </div>
        <?= Html::submitButton('Submit', ['class' => 'btn btn-default pull-right', 'name' => 'contact-button']) ?>
        <?php ActiveForm::end(); ?>
    </div><!--    /Email Blocks      -->

</div><!--    /Action Blocks      -->
