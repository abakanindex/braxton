<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use lo\widgets\modal\ModalAjax;
use yii\grid\GridView;
use yii\bootstrap\{Tabs, Modal};
use rmrevin\yii\fontawesome\FA;
?>
<div id="viewing-container">
<h3><?= Yii::t('app', 'Viewings')?></h3>
<div class="tabs-block">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#viewings" data-toggle="tab"><?= Yii::t('app', 'New/Edit')?></a></li>
        <li><a href="#viewing-report" data-toggle="tab"><?= Yii::t('app', 'Reports')?></a></li>
    </ul>
    <div class="property-list">
        <div class="tab-content">
            <div class="tab-pane active" id="viewings">
                <div class="tab-header">
                    <h4><?= Yii::t('app', 'Put Viewing')?></h4>
<!--                    <a href="#" class="pull-right"><h4>--><?//= Yii::t('app', '')?><!--</h4></a>-->
                    <?php if(Yii::$app->user->can('viewingCreate')):?>
                        <?php $form = ActiveForm::begin([
                            'action' => ($model->id) ? Yii::$app->getUrlManager()->createUrl(['viewing/update', 'id' => $model->id]) : Url::to(['viewing/create']),
                            'options' => [
                                'class' => 'clearfix form-horizontal',
                                'id' => 'viewings-form'
                            ]
                        ])?>
                        <div class="form-group">
                            <label for="viewingsListing" class="col-sm-5 control-label"><?= Yii::t('app', 'Property')?></label>
                            <div class="col-sm-7">
                                <?= Html::a(
                                    ($model->listing_ref) ? $model->listing_ref : FA::icon('plus') . Yii::t('app', ' Select an existing listing'), '#', [
                                    'data-toggle' => 'modal',
                                    'data-target' => '#modal-viewing-listing',
                                    'id' => 'listingRefLink',
                                    'class' => 'no-margin'
                                ]);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="viewingsDate" class="col-sm-5 control-label"><?= Yii::t('app', 'Date')?></label>
                            <div class="col-sm-7">
                                <?= Html::activeInput('date', $model, 'date', [
                                    'id' => 'viewingsDate',
                                    'class' => 'form-control',
                                    'value' => ($model->date) ? date('Y-m-d', strtotime($model->date)) : false
                                ]) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="viewingsTime" class="col-sm-5 control-label"><?= Yii::t('app', 'Time')?></label>
                            <div class="col-sm-7">
                                <?= Html::activeInput('time', $model, 'time', [
                                    'id' => 'viewingsTime',
                                    'class' => 'form-control',
                                    'value' => ($model->date) ? date('H:i', strtotime($model->date)) : false
                                ]) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="viewingsAgent" class="col-sm-5 control-label"><?= Yii::t('app', 'Agent')?></label>
                            <div class="col-sm-7">
                                <?= $form->field($model, 'agent_id', [
                                    'template' => '{input}',
                                    'options' => [
                                        'tag' => false,
                                    ],
                                ])->dropDownList($agents, ['id' => 'viewingsAgent', 'prompt' => ''])?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="viewingsStatus" class="col-sm-5 control-label"><?= Yii::t('app', 'Status')?></label>
                            <div class="col-sm-7">
                                <?= $form->field($model, 'status', [
                                    'template' => '{input}',
                                    'options' => [
                                        'tag' => false,
                                    ]
                                ])->dropDownList($viewingsStatuses, ['id' => 'viewingsStatus', 'prompt' => '']);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="viewingsName" class="col-sm-5 control-label"><?= Yii::t('app', 'Client Name')?></label>

                            <div class="col-sm-7">
                                <?= $form->field($model, 'client_name')->textInput(['id' => 'viewingsName', 'value' => $modelLead->last_name . ' ' . $modelLead->first_name])->label(false)?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="viewingsRequest" class="col-sm-5 control-label"><?= Yii::t('app', '2nd Agent')?></label>
                            <div class="col-sm-7">
                                <?= $form->field($model, 'request_viewing_pack_id', [
                                    'template' => '{input}',
                                    'options' => [
                                        'tag' => false,
                                    ],
                                ])->dropDownList($agents2, ['id' => 'viewingsRequest', 'prompt' => ''])?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="viewingsNote" class="col-sm-5 control-label"><?= Yii::t('app', 'Note')?></label>
                            <div class="col-sm-7">
                                <?= $form->field($model, 'note', [
                                    'template' => '{input}',
                                    'options' => [
                                        'tag' => false
                                    ]
                                ])->textarea(['rows' => 2, 'id' => 'viewingsNote'])?>
                            </div>
                        </div>

                        <?= $form->field($model, 'ref', [
                            'template' => '{input}',
                            'options' => [
                                'tag' => false
                            ]
                        ])->hiddenInput(['value' => $modelLead->reference])?>

                        <?= $form->field($model, 'listing_ref', [
                            'template' => '{input}',
                            'options' => [
                                'tag' => false
                            ]
                        ])->hiddenInput(['id' => 'listingRef'])?>

                        <?= $form->field($model, 'type', [
                            'template' => '{input}',
                            'options' => [
                                'tag' => false
                            ]
                        ])->hiddenInput(['value' => $type])?>

                        <?= Html::submitButton(
                            Yii::t('app', 'Click to save Viewing'),
                            [
                                'class' => 'btn col-md-12'
                            ]
                        )?>
                        <?php $form = ActiveForm::end();?>
                    <?php endif;?>
                </div>
                <div class="tab-row">
                    <?php if(Yii::$app->user->can('viewingView')):?>
                        <ul class="viewings-list">
                            <?php foreach($viewings as $v) {?>
                                <li>
                                    <div class="pull-right">
                                        <?php if(Yii::$app->user->can('viewingUpdate')):?>
                                            <a href="<?= Yii::$app->getUrlManager()->createUrl(['viewing/load', 'id' => $v->id, 'ref' => $modelLead->reference, 'type' => $type])?>" class="viewing-edit" data-pjax="0">
                                                <?= Yii::t('app', 'Edit')?>
                                            </a>
                                        <?php endif;?>
                                    </div>
                                    <div class="viewing-item-block">
                                        <input type="button"
                                               value="<?= Yii::t('app', 'New Report')?>"
                                               class="new-report-for-viewing btn btn-success"
                                               data-url="<?= Url::toRoute(['/viewing/viewing-report-form'])?>"
                                               data-id="<?= $v->id?>">
                                        <p><span><?=Yii::t('app', 'Date')?>: </span><?=date("Y/m/d", strtotime($v->date))?></p>
                                        <p><span><?=Yii::t('app', 'Time')?>: </span><?=date("H:i A", strtotime($v->date))?><p>
                                        <p><span><?=Yii::t('app', 'Agent')?>: </span><?=$v->agent->username?></p>
                                        <p><span><?=Yii::t('app', 'Status')?>: </span><?=$viewingsStatuses[$v->status]?></p>
                                        <p><span><?=Yii::t('app', 'Client Name')?>: </span><?=$v->client_name?></p>
                                        <?php if ($v->request_viewing_pack_id) : ?>
                                            <p><span><?= Yii::t('app', '2nd Agent') ?>: </span><?= $v->requestViewingPack->username ?></p>
                                        <?php endif; ?>
                                        <p><span><?=Yii::t('app', 'Note')?>: </span><?=$v->note?></p>
                                    </div>
                                </li>
                            <?php }?>
                        </ul>
                    <?php endif;?>
                </div>
            </div>
            <div class="tab-pane" id="viewing-report">
                <?php foreach($viewingReports as $vReport):?>
                    <div class="viewing-item-report">
                        <p>
                            <?= Yii::t('app', 'Listing Ref')?>: <b><?= $vReport->listing_ref?></b>
                        </p>
                        <p>
                            <?= Yii::t('app', 'Report title')?>: <?= $vReport->report_title?>
                        </p>
                        <p>
                            <?= Yii::t('app', 'Report Description')?>: <?= $vReport->report_description?>
                        </p>
                    </div>
                <?php endforeach?>
            </div>
        </div>
    </div>
</div>

<?php
Modal::begin([
    'header' => '<h4>' . Yii::t('app', 'Select Listing') . '</h4>',
    'id'     => 'modal-viewing-listing',
    'size'   => 'modal-lg',
    'footer'   => '<button type="button" class="btn btn-default" data-dismiss="modal">'
        . Yii::t('app', 'OK')
        . '</button>',
]);
?>
<div class="container-fluid  bottom-rentals-content clearfix">
    <div style="overflow-x: auto; padding-right: 0; padding-left: 0;" class="container-fluid clearfix">
        <?= Tabs::widget([
            'items' => [
                [
                    'label' => Yii::t('app', 'Sales'),
                    'active' => true,
                    'content' => $this->render('parts/_gridSales', [
                            'saleDataProvider' => $saleDataProvider,
                            'saleSearchModel' => $saleSearchModel,
                            'model' => $model
                        ])
                ],
                [
                    'label' => Yii::t('app', 'Rentals'),
                    'content' => $this->render('parts/_gridRentals', [
                            'rentalDataProvider' => $rentalDataProvider,
                            'rentalSearchModel' => $rentalSearchModel,
                            'model' => $model
                        ])
                ]
            ]
        ])?>
    </div>
</div>
<?php
Modal::end();
?>
</div>
