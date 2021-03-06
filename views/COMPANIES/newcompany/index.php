<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'SystaVision CRM';
?>
 <!--    Info Blocks      -->
    <div class="container-fluid content">
        <div class="col-xs-11 col-sm-5 col-md-5 col-lg-3 info-block " >
            <div class="icon-info-block">
                <i class="fa fa-archive" aria-hidden="true"></i>
            </div>
            <div class="data-info-block">
                <p class="info-block-count">150</p>
                <p class="info-block-text">New Property</p>
                <a href="#">More info <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>

        <div class="col-xs-11 col-sm-5 col-md-5 col-lg-3 info-block" >
            <div class="icon-info-block">
                <i class="fa fa-users" aria-hidden="true"></i>

            </div>
            <div class="data-info-block">
                <p class="info-block-count">44</p>
                <p class="info-block-text">User Registration</p>
                <a href="#">More info <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>

        <div class="col-xs-11 col-sm-5 col-md-5 col-lg-3 info-block" >
            <div class="icon-info-block">
                <i class="fa fa-comment-o" aria-hidden="true"></i>

            </div>
            <div class="data-info-block">
                <p class="info-block-count">65</p>
                <p class="info-block-text">Messages</p>
                <a href="#">More info <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>
    </div><!--    /Info Blocks      -->


    <!--    Action Blocks      -->
    <div class="container-fluid content">

        <!--    Tasks Block      -->
        <div class="col-xs-11 col-sm-5 col-md-5 action-block" >
                <div class="headline">
                    <a class="btn btn-default pull-right" type="button" href="/web/task-manager/create"><i class="fa fa-plus"></i> Add task</a>
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
                                'view' => function ($url,$model,$key) {
                                    return Html::a(
                                        '<i class="fa fa-eye"></i>', 
                                        '/web/task-manager/view?id=' . $model->id
                                    );
                                },
                                'update' => function ($url,$model,$key) {
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
        <div class="col-xs-11 col-sm-5 col-md-5 action-block" >
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


    <!--    Chat Block      -->
    <div class="container-fluid content">
        <div class="col-xs-11 col-sm-10 col-md-10 chat-block" >
            <div class="headline">
                <div>Quick Email</div>
                <a class="pull-right" href="#"><i class="fa fa-times"></i></a>
            </div>
            <div class="box-body chat" id="chat-box">
                <!-- chat item -->
                <div class="item">
                    <img alt="user image" class="online img-circle" src="<?= Url::to('@web/new-design/img/user3-128x128.jpg') ?>">
                    <div class="message">
                        <a class="name" href="#"> Mike Doe<small class="text-muted"> 2:15</small></a>
                        <p> I would like to meet you to discuss the latest news about the arrival of the new theme. They say it is going to be one the best themes on the market</p>

                        <!-- attachment -->
                        <div class="attachment">
                            <h4>Attachments:</h4>
                            <p class="filename">Theme-thumbnail-image.jpg</p>
                            <div class="pull-right">
                                <button class="btn btn-primary btn-sm btn-flat" type="button">Open</button>
                            </div>
                        </div><!-- /attachment -->
                    </div>
                </div><!-- /item -->

                <!-- chat item -->
                <div class="item">
                    <img alt="user image" class="online img-circle" src="<?= Url::to('@web/new-design/img/user3-128x128.jpg') ?>">
                    <div class="message">
                        <a class="name" href="#"> Mike Doe<small class="text-muted"> 2:15</small></a>
                        <p> I would like to meet you to discuss the latest news about the arrival of the new theme. They say it is going to be one the best themes on the market</p>

                    </div>
                </div><!-- /item -->

                <!-- chat item -->
                <div class="item">
                    <img alt="user image" class="online img-circle" src="<?= Url::to('@web/new-design/img/user3-128x128.jpg') ?>">
                    <div class="message">
                        <a class="name" href="#"> Mike Doe<small class="text-muted"> 2:15</small></a>
                        <p> I would like to meet you to discuss the latest news about the arrival of the new theme. They say it is going to be one the best themes on the market</p>

                    </div>
                </div><!-- /item -->
            </div>
            <form id="chat-message" class="">
                <div class="form-group">
                    <textarea rows="3" class="form-control" id="chat-message-text" placeholder="Type message"></textarea>
                </div>
                <button type="submit" class="btn btn-default pull-right">Send</button>
            </form>
        </div>
    </div><!--    /Chat Block      -->