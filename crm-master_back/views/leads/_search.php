<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Leads;
use yii\helpers\{ArrayHelper, Url, Json};

/* @var $this yii\web\View */
/* @var $model app\models\LeadsSearch */
/* @var $formSearch yii\widgets\ActiveForm */
?>

<div class="leads-search">

    <?php $formSearch = ActiveForm::begin([
        'action' => ['advanced-search'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
            'id'        => 'advanced-search-form'
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    <?= $searchModel->getAttributeLabel('type_id')?>
                </label>
                <div class="col-sm-6 float-right">
                    <?php
                    $types = \app\modules\lead\models\LeadType::find()->all();
                    $items = ArrayHelper::map($types, 'id', 'title');
                    ?>
                    <?= $formSearch->field($searchModel, 'type_id', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->dropDownList(
                            $items,
                            [
                                'class'    => 'form-control',
                                'prompt'   => ''
                            ]
                        )->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label>
                    <?= $searchModel->getAttributeLabel('status')?>
                </label>
                <div class="col-sm-6 float-right">
                    <?= $formSearch->field($searchModel, 'status', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->dropDownList(
                            [
                                Leads::STATUS_OPEN => Yii::t('app', 'Open'),
                                Leads::STATUS_CLOSED => Yii::t('app', 'Closed'),
                                Leads::STATUS_NOT_SPECIFIED => Yii::t('app', 'Not Specified')
                            ],
                            [
                                'class'    => 'form-control',
                                'prompt'   => ''
                            ]
                        )->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label>
                    <?= $searchModel->getAttributeLabel('sub_status_id')?>
                </label>
                <div class="col-sm-6 float-right">
                    <?php
                    $subStatuses = \app\modules\lead\models\LeadSubStatus::find()->all();
                    $items = ArrayHelper::map($subStatuses, 'id', 'title');
                    ?>
                    <?= $formSearch->field($searchModel, 'sub_status_id', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->dropDownList(
                            $items,
                            [
                                'class'    => 'form-control',
                                'prompt'   => ''
                            ]
                        )->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label>
                    <?= $searchModel->getAttributeLabel('priority')?>
                </label>
                <div class="col-sm-6 float-right">
                    <?= $formSearch->field($searchModel, 'priority', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->dropDownList(
                            [
                                Leads::PRIORITY_URGENT => Yii::t('app', 'Urgent'),
                                Leads::PRIORITY_HIGH => Yii::t('app', 'High'),
                                Leads::PRIORITY_NORMAL => Yii::t('app', 'Normal'),
                                Leads::PRIORITY_LOW => Yii::t('app', 'Low'),
                            ],
                            [
                                'class'    => 'form-control',
                                'prompt'   => ''
                            ]
                        )->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label>
                    <?= $searchModel->getAttributeLabel('category_id')?>
                </label>
                <div class="col-sm-6 float-right">
                    <?php
                    $categories = \app\models\reference_books\PropertyCategory::find()->all();
                    $items = ArrayHelper::map($categories, 'id', 'title');
                    ?>
                    <?= $formSearch->field($searchModel, 'category_id', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->dropDownList(
                            $items,
                            [
                                'class'    => 'form-control',
                                'prompt'   => ''
                            ]
                        )->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label>
                    <?= $searchModel->getAttributeLabel('finance_type')?>
                </label>
                <div class="col-sm-6 float-right">
                    <?= $formSearch->field($searchModel, 'finance_type', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->dropDownList(
                            [
                                Leads::FINANCE_TYPE_CASH => Yii::t('app', 'Cash'),
                                Leads::FINANCE_TYPE_LOAN_APPROVED => Yii::t('app', 'Loan (approved)'),
                                Leads::FINANCE_TYPE_LOAN_NOT_APPROVED => Yii::t('app', 'Loan (not approved)'),
                            ],
                            [
                                'class'    => 'form-control',
                                'prompt'   => ''
                            ]
                        )->label(false); ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    <?= $searchModel->getAttributeLabel('min_beds')?>
                </label>
                <div class="col-sm-6 float-right">
                    <?= $formSearch->field($searchModel, 'min_beds', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control', 'maxlength' => true])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label>
                    <?= $searchModel->getAttributeLabel('max_beds')?>
                </label>
                <div class="col-sm-6 float-right">
                    <?= $formSearch->field($searchModel, 'max_beds', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control', 'maxlength' => true])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label>
                    <?= $searchModel->getAttributeLabel('min_price')?>
                </label>
                <div class="col-sm-6 float-right">
                    <?= $formSearch->field($searchModel, 'min_price', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control', 'maxlength' => true])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label>
                    <?= $searchModel->getAttributeLabel('max_price')?>
                </label>
                <div class="col-sm-6 float-right">
                    <?= $formSearch->field($searchModel, 'max_price', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control', 'maxlength' => true])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label>
                    <?= $searchModel->getAttributeLabel('min_area')?>
                </label>
                <div class="col-sm-6 float-right">
                    <?= $formSearch->field($searchModel, 'min_area', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control', 'maxlength' => true])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label>
                    <?= $searchModel->getAttributeLabel('max_area')?>
                </label>
                <div class="col-sm-6 float-right">
                    <?= $formSearch->field($searchModel, 'max_area', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control', 'maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary', 'id' => 'btn-submit-advanced-search']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
