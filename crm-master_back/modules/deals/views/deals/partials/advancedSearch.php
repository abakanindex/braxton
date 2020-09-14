<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\deals\models\Deals;
use yii\helpers\{ArrayHelper, Url, Json};
use kartik\date\DatePicker;

/**
 * @var $this yii\web\View
 * @var $model app\models\LeadsSearch
 * @var $formSearch yii\widgets\ActiveForm
 * @var $searchModel
 */
?>

<div class="deals-search">

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
                    <?= Yii::t('app', 'Listing Ref')?>
                </label>
                <div class="col-sm-6 float-right">
                    <?= $formSearch->field($searchModel, 'ref', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->textInput(['class' => 'form-control'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label>
                    <?= Yii::t('app', 'Unit')?>
                </label>
                <div class="col-sm-6 float-right">
                    <?= $formSearch->field($searchModel, 'unit', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->textInput(['class' => 'form-control'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label>
                    <?= Yii::t('app', 'Street No')?>
                </label>
                <div class="col-sm-6 float-right">
                    <?= $formSearch->field($searchModel, 'street_no', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->textInput(['class' => 'form-control'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label>
                    <?= Yii::t('app', 'Deal Date')?>
                </label>
                <div class="col-sm-6 float-right">
                    <?= DatePicker::widget([
                        'name' => 'DealsSearch[actual_date]',
                        'type' => DatePicker::TYPE_INPUT,
                        'id' => 'dealssearch-actual_date',
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'dd-mm-yyyy'
                        ]
                    ]);?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>
                    <?= Yii::t('app', 'Bedrooms')?>
                </label>
                <div class="col-sm-6 float-right">
                    <?= $formSearch->field($searchModel, 'beds', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->dropDownList(
                        [
                            '1'  => Yii::t('app', '1'),
                            '2'  => Yii::t('app', '2'),
                            '3'  => Yii::t('app', '3'),
                            '4'  => Yii::t('app', '4'),
                            '5'  => Yii::t('app', '5'),
                            '6'  => Yii::t('app', '6'),
                            '7'  => Yii::t('app', '7'),
                            '8'  => Yii::t('app', '8'),
                            '9'  => Yii::t('app', '9'),
                            '10' => Yii::t('app', '10'),
                            '11' => Yii::t('app', '11'),
                            '12' => Yii::t('app', '12'),
                            '13' => Yii::t('app', '13'),
                            '14' => Yii::t('app', '14'),
                            '15' => Yii::t('app', '15'),
                            '16' => Yii::t('app', '16'),
                        ],
                        [
                            'class'    => 'form-control',
                            'prompt'   => ''
                        ]

                    )->label(false);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label>
                    <?= Yii::t('app', 'Unit Type')?>
                </label>
                <div class="col-sm-6 float-right">
                    <?= $formSearch->field($searchModel, 'unit_type', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->textInput(['class' => 'form-control'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label>
                    <?= Yii::t('app', 'Floor No')?>
                </label>
                <div class="col-sm-6 float-right">
                    <?= $formSearch->field($searchModel, 'floor_no', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->textInput(['class' => 'form-control'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label>
                    <?= Yii::t('app', 'Created By')?>
                </label>
                <div class="col-sm-6 float-right">
                    <?= $formSearch->field($searchModel, 'created_by', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->textInput(['class' => 'form-control'])->label(false); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary', 'id' => 'btn-submit-advanced-search']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
