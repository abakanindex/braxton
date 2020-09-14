<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use yii\jui\DatePicker;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Contacts */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="contacts-form">
     <div class="row">
        <section class="col-lg-12">
            <div class="nav-tabs-custom" style="cursor: move;">
               
                <?= Tabs::widget([
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Basic Detail'),
                            'content' => Html::tag('div', $this->render(
                                    'basicDetailsFields' ,
                                    [
                                        'model' => $model, 
                                        'form' => $form,
                                        'nationModel' => $nationModel,
                                        'titlesModel' => $titlesModel,
                                        'religionModel' => $religionModel,
                                        'modelImg' => $modelImg,
                                        'modelUser' => $modelUser,
                                    ]
                                ), 
                                ['class' => 'col-md-12']
                            ),
                            'active' => true,
                            'options' => [
                                'class' => 'chart',
                            ]
                        ],
                        [
                            'label' => Yii::t('app', 'Contact Details'),
                            'content' => Html::tag('div', $this->render(
                                'contactDetailsFields' ,
                                ['model' => $model, 'form' => $form]), 
                                ['class' => 'col-md-12']
                            ),
                            'options' => [
                                'class' => 'chart',
                            ]
                        ],
                        [
                            'label' => Yii::t('app', 'Social Media'),
                            'content' => Html::tag('div', $this->render(
                                'socialMediaFields' ,
                                ['model' => $model, 'form' => $form]), 
                                ['class' => 'col-md-12']
                            ),
                            'options' => [
                                'class' => 'chart',
                            ]
                        ],
                        [
                            'label' => Yii::t('app', 'Additional Information'),
                            'content' => Html::tag('div', $this->render(
                                'additionalInformationFields' ,
                                [
                                    'model' => $model,
                                    'form' => $form,
                                    'sourceModel' => $sourceModel,
                                ]), 
                                ['class' => 'col-md-12']
                            ),
                            'options' => [
                                'class' => 'chart',
                            ]
                        ],
                    ],
                    'options' => [
                        'class' => 'pull-left ui-sortable-handle',
                    ],

                ]);
                ?>
            </div>
        </section>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
