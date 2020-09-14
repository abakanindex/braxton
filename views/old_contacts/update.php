<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use mihaildev\ckeditor\CKEditor;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\Contacts */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Update Contacts: {nameAttribute}', [
    'nameAttribute' => $model->last_name . " " . $model->first_name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contacts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->last_name . " " . $model->first_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<!-- /Top Contact Block -->


<?php
$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
?>

<div class="container-fluid top-contact-content clearfix"><!--  Top Contact Block -->
<div class="head-contact-property container-fluid">
    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => Yii::t('app', 'Home'), 'url' => '/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <h2><?=Html::encode($this->title)?></h2>
    <ul class="list-inline container-fluid">
        <li class="">
            <?= Html::submitButton('<i class="fa fa-check-circle"></i>' . Yii::t('app', 'Save'), ['class' => 'btn green-button']) ?>
        </li>
    </ul>
</div>

<div class="container-fluid content-contact-property">
<div class="form-horizontal">

    <div class="container-fluid contact-left-block col-md-4"><!-- Left Contact part-->
        <div class="contact-top-column-height">

            <div class="contact-big-block"><!-- Owner -->
                <!--<h3>Contact</h3>-->
                <div class="owner-head">
                    <!--<img alt="user image" class="owner-image img-circle " src="img/user3-128x128.jpg">-->
                    <div class="owner-name">
                        <h4 id="head-info-full-name"></h4>
                        <p><?=Yii::t('app', 'Contact')?></p>
                    </div>
                </div>
                <div class="owner-property property-list">
                    <p><i class="fa fa-mobile"></i><?=$model->mobile?></p>
                    <p><i class="fa fa-phone"></i><?=$model->phone?></p>
                    <p><i class="fa fa-envelope"></i><?=$model->email?></p>

                </div>
            </div><!--/Owner-->

        </div>
        <div class="contact-bottom-column-height">

            <div class="contact-small-block"><!--Additional Information-->
                <h3>Contact information</h3>
                <div class="property-list">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Assigned To')?></label>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'assigned_to', [
                                    'template' => '{input}', // Leave only input (remove label, error and hint)
                                    'options' => [
                                        'tag' => false, // Don't wrap with "form-group" div
                                    ],
                                ])->dropDownList($users)->label(false)?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Ref')?></label>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'ref', [
                                    'template' => '{input}', // Leave only input (remove label, error and hint)
                                    'options' => [
                                        'tag' => false, // Don't wrap with "form-group" div
                                    ],
                                ])->textInput(['disabled' => false])->label(false) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Title')?></label>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'title', [
                                    'template' => '{input}', // Leave only input (remove label, error and hint)
                                    'options' => [
                                        'tag' => false, // Don't wrap with "form-group" div
                                    ],
                                ])->dropDownList($titles)->label(false);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'First Name')?></label>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'first_name', [
                                    'template' => '{input}', // Leave only input (remove label, error and hint)
                                    'options' => [
                                        'tag' => false, // Don't wrap with "form-group" div
                                    ],
                                ])->textInput(['maxlength' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Last Name')?></label>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'last_name', [
                                    'template' => '{input}', // Leave only input (remove label, error and hint)
                                    'options' => [
                                        'tag' => false, // Don't wrap with "form-group" div
                                    ],
                                ])->textInput(['maxlength' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Gender')?></label>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'gender', [
                                    'template' => '{input}', // Leave only input (remove label, error and hint)
                                    'options' => [
                                        'tag' => false, // Don't wrap with "form-group" div
                                    ],
                                ])->dropDownList([
                                    '0'      => Yii::t('app', 'Select'),
                                    'Male'   => Yii::t('app', 'Male'),
                                    'Female' => Yii::t('app', 'Female'),
                                ])->label(false)
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Date of Birth')?></label>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'date_of_birth', [
                                    'template' => '{input}', // Leave only input (remove label, error and hint)
                                    'options' => [
                                        'tag' => false, // Don't wrap with "form-group" div
                                    ],
                                ])->widget(
                                    yii\jui\DatePicker::className(),
                                    [
                                        'model'         => $model,
                                        'attribute'     => 'available',
                                        'language'      => 'en',
                                        'dateFormat'    => 'dd-MM-yyyy',
                                        'clientOptions' => ['defaultDate' => '01-01-2017', ],
                                        'options'       => ['class'=>'form-control', ],
                                    ]
                                )->label(false);
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Nationalities')?></label>
                            <div class="col-sm-6">
                                <?=  $form->field($model, 'nationalities', [
                                    'template' => '{input}', // Leave only input (remove label, error and hint)
                                    'options' => [
                                        'tag' => false, // Don't wrap with "form-group" div
                                    ],
                                ])->dropDownList($nationalities)->label(false);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Religion')?></label>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'religion', [
                                    'template' => '{input}', // Leave only input (remove label, error and hint)
                                    'options' => [
                                        'tag' => false, // Don't wrap with "form-group" div
                                    ],
                                ])->dropDownList($religions)->label(false);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Language')?></label>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'languagesd', [
                                    'template' => '{input}', // Leave only input (remove label, error and hint)
                                    'options' => [
                                        'tag' => false, // Don't wrap with "form-group" div
                                    ],
                                ])->textInput(['maxlength' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Hobbies')?></label>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'hobbies', [
                                    'template' => '{input}', // Leave only input (remove label, error and hint)
                                    'options' => [
                                        'tag' => false, // Don't wrap with "form-group" div
                                    ],
                                ])->textInput(['maxlength' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Created By')?></label>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'created_by', [
                                    'template' => '{input}', // Leave only input (remove label, error and hint)
                                    'options' => [
                                        'tag' => false, // Don't wrap with "form-group" div
                                    ],
                                ])->textInput(['maxlength' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Contact Source')?></label>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'contact_source', [
                                    'template' => '{input}', // Leave only input (remove label, error and hint)
                                    'options' => [
                                        'tag' => false, // Don't wrap with "form-group" div
                                    ],
                                ])->dropDownList($sources)->label(false);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Contact Type')?></label>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'contact_type', [
                                    'template' => '{input}', // Leave only input (remove label, error and hint)
                                    'options' => [
                                        'tag' => false, // Don't wrap with "form-group" div
                                    ],
                                ])->dropDownList($contactType)->label(false);
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Company Name')?></label>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'company_name', [
                                    'template' => '{input}', // Leave only input (remove label, error and hint)
                                    'options' => [
                                        'tag' => false, // Don't wrap with "form-group" div
                                    ],
                                ])->textInput(['maxlength' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Designation')?></label>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'designation', [
                                    'template' => '{input}', // Leave only input (remove label, error and hint)
                                    'options' => [
                                        'tag' => false, // Don't wrap with "form-group" div
                                    ],
                                ])->textInput(['maxlength' => true])->label(false) ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div><!-- /Additional Information-->

        </div>

    </div><!-- /Left Contact part-->
</div>
<div class="form-horizontal">
    <div class="container-fluid contact-middle-block col-md-4"><!-- Middle Contact part-->

        <div class="content-left-block"><!--Property Address & Detalis-->
            <h3>Contact Details</h3>
            <div class="property-list">
                <div class="form-group">
                    <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Mobile Personal')?></label>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'mobile', [
                            'template' => '{input}', // Leave only input (remove label, error and hint)
                            'options' => [
                                'tag' => false, // Don't wrap with "form-group" div
                            ],
                        ])->textInput(['maxlength' => true])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Phone Personal')?></label>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'phone', [
                            'template' => '{input}', // Leave only input (remove label, error and hint)
                            'options' => [
                                'tag' => false, // Don't wrap with "form-group" div
                            ],
                        ])->textInput(['maxlength' => true])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Email Personal')?></label>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'email', [
                            'template' => '{input}', // Leave only input (remove label, error and hint)
                            'options' => [
                                'tag' => false, // Don't wrap with "form-group" div
                            ],
                        ])->textInput(['maxlength' => true])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Address Personal')?></label>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'address', [
                            'template' => '{input}', // Leave only input (remove label, error and hint)
                            'options' => [
                                'tag' => false, // Don't wrap with "form-group" div
                            ],
                        ])->textInput(['maxlength' => true])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Facebook')?></label>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'fb', [
                            'template' => '{input}', // Leave only input (remove label, error and hint)
                            'options' => [
                                'tag' => false, // Don't wrap with "form-group" div
                            ],
                        ])->textInput(['maxlength' => true])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Twitter')?></label>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'tw', [
                            'template' => '{input}', // Leave only input (remove label, error and hint)
                            'options' => [
                                'tag' => false, // Don't wrap with "form-group" div
                            ],
                        ])->textInput(['maxlength' => true])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'LinkedIn')?></label>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'linkedin', [
                            'template' => '{input}', // Leave only input (remove label, error and hint)
                            'options' => [
                                'tag' => false, // Don't wrap with "form-group" div
                            ],
                        ])->textInput(['maxlength' => true])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Google+')?></label>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'googlplus', [
                            'template' => '{input}', // Leave only input (remove label, error and hint)
                            'options' => [
                                'tag' => false, // Don't wrap with "form-group" div
                            ],
                        ])->textInput(['maxlength' => true])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Instagram')?></label>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'in', [
                            'template' => '{input}', // Leave only input (remove label, error and hint)
                            'options' => [
                                'tag' => false, // Don't wrap with "form-group" div
                            ],
                        ])->textInput(['maxlength' => true])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'WeChat')?></label>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'wechat', [
                            'template' => '{input}', // Leave only input (remove label, error and hint)
                            'options' => [
                                'tag' => false, // Don't wrap with "form-group" div
                            ],
                        ])->textInput(['maxlength' => true])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Skype')?></label>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'skype', [
                            'template' => '{input}', // Leave only input (remove label, error and hint)
                            'options' => [
                                'tag' => false, // Don't wrap with "form-group" div
                            ],
                        ])->textInput(['maxlength' => true])->label(false) ?>
                    </div>
                </div>
            </div>
        </div><!-- /Property Address & Detalis-->

    </div><!-- /Middle Contact part-->
</div>


<div class="container-fluid col-md-4 notes-block"><!-- Right part-->
<div id="notes-tab" >
<ul class="nav nav-tabs">
    <li class="active"><a  href="#notes" data-toggle="tab">Notes</a></li>
    <li><a href="#viewings" data-toggle="tab">Viewings</a></li>
    <li><a href="#documents" data-toggle="tab">Documents</a></li>
    <li><a href="#history" data-toggle="tab">History</a></li>
</ul>
<div class="property-list">
    <div class="tab-content ">
        <div class="tab-pane active" id="notes">
            <div class="tab-header">
                <h4>Put Note</h4>
                <a href="#" class="pull-right"><h4></h4></a>
                <div id="notes-form" class="form clearfix">
                    <div class="form-group">
                        <textarea rows="4" class="form-control" id="note" placeholder=""></textarea>
                    </div>
                    <button type="submit" class="btn col-md-12">Click to add your note</button>
                </div>
            </div>
            <div class="tab-row">
                <ul>
                    <li><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et</p></li>
                    <li><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et</p></li>
                    <li><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et</p></li>
                    <li><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et</p></li>
                    <li><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et</p></li>
                    <li><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et</p></li>
                </ul>

            </div>
        </div>
        <div class="tab-pane" id="viewings">
            <div class="tab-header">
                <h4>Put Viewing</h4>
                <a href="#" class="pull-right"><h4></h4></a>
                <div id="viewings-form" class="form-horizontal clearfix">
                    <div class="form-group">
                        <label for="viewingsListing" class="col-sm-5 control-label">Listing</label>
                        <div class="col-sm-7">
                            <select class="form-control" id="viewingsListing">
                                <option>Select</option>
                                <option>Option 2</option>
                                <option>Option 3</option>
                                <option>Option 4</option>
                                <option>Option 5</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="viewingsDate" class="col-sm-5 control-label">Date</label>
                        <div class="col-sm-7">
                            <input type="date" class="form-control" id="viewingsDate" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="viewingsTime" class="col-sm-5 control-label">Time</label>
                        <div class="col-sm-7">
                            <input type="time" class="form-control" id="viewingsTime" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="viewingsAgent" class="col-sm-5 control-label">Agent</label>
                        <div class="col-sm-7">
                            <select class="form-control" id="viewingsAgent">
                                <option>Select</option>
                                <option>Option 2</option>
                                <option>Option 3</option>
                                <option>Option 4</option>
                                <option>Option 5</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="viewingsStatus" class="col-sm-5 control-label">Status</label>
                        <div class="col-sm-7">
                            <select class="form-control" id="viewingsStatus">
                                <option>Select</option>
                                <option>Option 2</option>
                                <option>Option 3</option>
                                <option>Option 4</option>
                                <option>Option 5</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="viewingsName" class="col-sm-5 control-label">Client Name</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="viewingsName" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="viewingsRequest" class="col-sm-5 control-label">Request</label>
                        <div class="col-sm-7">
                            <select class="form-control" id="viewingsRequest">
                                <option>Select</option>
                                <option>Option 2</option>
                                <option>Option 3</option>
                                <option>Option 4</option>
                                <option>Option 5</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="viewingsNote" class="col-sm-5 control-label">Note</label>
                        <div class="col-sm-7">
                            <textarea rows="2" class="form-control" id="viewingsNote" placeholder=""></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn col-md-12">Click to add Viewing</button>
                </div>
            </div>
            <div class="tab-row">
                <ul class="viewings-list">
                    <li>
                        <div>
                            <p><span>Date: </span>20/13/2018</p>
                            <p><span>Time: </span>02:20 PM<p>
                            <p><span>Agent: </span>Angelica Gozum</p>
                            <p><span>Status: </span>Scheduled</p>
                            <p><span>Client Name: </span>Abdul Aziz</p>
                            <p><span>Request: </span>Waqas Ahmed</p>
                            <p><span>Note: </span>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.</p>
                        </div>
                    </li>
                    <li>
                        <div>
                            <p><span>Date & Time: </span>20/13/2018</p>
                            <p><span>Time: </span>02:20 PM<p>
                            <p><span>Agent: </span>Angelica Gozum</p>
                            <p><span>Status: </span>Scheduled</p>
                            <p><span>Client Name: </span>Abdul Aziz</p>
                            <p><span>Request: </span>Waqas Ahmed</p>
                            <p><span>Note: </span>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.</p>
                        </div>
                    </li>
                    <li>
                        <div>
                            <p><span>Date & Time: </span>20/13/2018</p>
                            <p><span>Time: </span>02:20 PM<p>
                            <p><span>Agent: </span>Angelica Gozum</p>
                            <p><span>Status: </span>Scheduled</p>
                            <p><span>Client Name: </span>Abdul Aziz</p>
                            <p><span>Request: </span>Waqas Ahmed</p>
                            <p><span>Note: </span>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-pane" id="documents">
            <div class="tab-header clearfix">
                <h4>Put Document</h4>
                <a href="#" class="pull-right"><h4></h4></a>
                <div>
                    <div class="form-group">
                        <label for="documentsFile" class=" control-label">Document</label>
                        <div class="">
                            <input type="file" class="form-control" id="documentsFile" placeholder="">
                        </div>
                    </div>
                    <button type="submit" class="btn col-md-12">Click to add Document</button>
                </div>
            </div>
            <div class="tab-row">
                <ul>
                    <li>Document 1</li>
                    <li>Document 2</li>
                    <li>Document 3</li>
                    <li>Document 4</li>
                    <li>Document 5</li>
                    <li>Document 6</li>
                    <li>Document 7</li>
                    <li>Document 8</li>
                    <li>Document 9</li>
                    <li>Document 10</li>
                    <li>Document 11</li>
                    <li>Document 12</li>
                </ul>
            </div>
        </div>
        <div class="tab-pane" id="history">
            <div class="tab-header">
                <h4>History List</h4>
                <a href="#" class="pull-right"><h4></h4></a>
            </div>

            <div class="tab-row">
                <ul>
                    <li>History 1</li>
                    <li>History 2</li>
                    <li>History 3</li>
                    <li>History 4</li>
                    <li>History 5</li>
                    <li>History 6</li>
                    <li>History 7</li>
                    <li>History 8</li>
                    <li>History 9</li>
                    <li>History 10</li>
                    <li>History 11</li>
                    <li>History12</li>
                </ul>
            </div>
        </div>
    </div>
</div>

</div>

</div><!-- /Right part-->

</div>

</div><!-- /Top Contact Block -->




<?php ActiveForm::end(); ?>

<!--<div class="container-fluid create-content"></div>-->
