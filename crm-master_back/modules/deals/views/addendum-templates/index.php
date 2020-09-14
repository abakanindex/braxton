<?php

use kartik\datetime\DateTimePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\Breadcrumbs;
use dosamigos\tinymce\TinyMce;
use app\modules\deals\models\Templates;

/**
 * @var $firstRecord
 * @var $existRecord
 * @var bool $disabledAttribute
 */

$this->title = Yii::t('app', 'Addendum Templates');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('deals-head-block'); ?>
<?= Breadcrumbs::widget([
    'homeLink' => ['label' => Yii::t('app', 'Home'), 'url' => '/'],
    'links'    => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>
<h2><?= Html::encode($this->title) ?></h2>
<br>
<?php $this->endBlock(); ?>
<?php //Pjax::begin(['id' => 'result']); ?>
<div class="deals-index">
    <div class="container-fluid top-rentals-content clearfix">
        <div class="head-rentals-property container-fluid">
            <?= $this->render(
                'partials/topButton',
                [
                    'firstRecord' => $firstRecord,
                    'existRecord' => $existRecord,
                ]
            )
            ?>
        </div>

        <div class="container-fluid content-rentals-property" id="result" >
            <?php $form = ActiveForm::begin([
                'options' => [
                    'enctype'   => 'multipart/form-data',
                    'method' => 'post',
                    'class'     => 'form-horizontal',
                    'id'        => 'templatesSave',
//                    'data-pjax' => true
                ]
            ]); ?>

            <div class="container-fluid rentals-left-block col-md-4"><!-- Left part-->
                <div class="content-left-block">
                    <div class="property-list">
                        <div class="form-group">
                            <label for="inputRef" class="col-sm-3 control-label"><?= Yii::t('app', 'Template Type') ?></label>
                            <div class="col-sm-6">
                                <?= $form->field($firstRecord, 'type')->dropDownList(
                                    Templates::getTypes(),
                                    [
                                        'prompt'   => Yii::t('app', 'Select'),
                                        'disabled' => $disabledAttribute,
                                        'class'    => 'form-control'
                                    ]
                                )->label(false); ?>
                            </div>
                        </div>
                        <br/>
                        <br/>
                        <div class="form-group">
                            <label for="inputRef" class="col-sm-3 control-label"><?= Yii::t('app', 'Template Title') ?></label>
                            <div class="col-sm-6">
                                <?= $form->field($firstRecord, 'title')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /Left part-->

            <div class="container-fluid rentals-left-block col-md-8"><!-- Right part-->
                <div class="content-left-block">
                    <div class="property-list">
                        <div class="form-group">
<!--                            <label for="inputRef" class="col-sm-3 control-label">--><?//= Yii::t('app', 'Content') ?><!--</label>-->
                            <div class="col-sm-12">
                                <?= $form->field($firstRecord, 'content')->widget(TinyMce::class, [
                                    'options' => ['rows' => 6],
                                    'language' => 'en',
                                    'clientOptions' => [
                                        'plugins' => [
                                            "advlist autolink lists link charmap print preview anchor",
                                            "searchreplace visualblocks code fullscreen",
                                            "insertdatetime media table contextmenu paste"
                                        ],
                                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                                    ]
                                ]);?>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /Right part-->
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div><!---     Content       -->

<!--    Bottom Deals Block      -->
<div class="container-fluid  bottom-rentals-content clearfix">
<!--    <div id="listings-deals-tab" >-->
<!--        <div class="tab-content">-->
            <div class="clearfix"></div>
            <div class="tab-pane tab-pane-grid active" id="current-listings">
                <!-- BIG listings Table-->
                <div style="overflow-x: auto; padding-right: 0; padding-left: 0;" class="replace-grid-listing container-fluid clearfix">
                    <?= $this->render('partials/gridTable', [
                        'dataProvider'     => $dataProvider,
                        'urlView'          => 'deals/addendum-templates/view',
                        'filteredColumns'  => $filteredColumns,
                        'topModel'         => $firstRecord
                    ])?>
                </div>
            </div>
<!--        </div>-->
<!--    </div>-->
</div><!--    /Bottom Rentals Block      -->

<?php //Pjax::end(); ?>