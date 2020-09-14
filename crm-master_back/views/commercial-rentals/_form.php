<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\models\CommercialRentals */
/* @var $form yii\widgets\ActiveForm */

?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="commercial-rentals-form">
    <div class="row">
        <section class="col-lg-12">
            <div class="nav-tabs-custom" style="cursor: move;">

                <?= Tabs::widget([
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Property Address & Details'),
                            'content' => Html::tag('div', $this->render(
                                'propertyAddressDetailsFields',
                                [
                                    'model' => $model,
                                    'form' => $form,
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
                            'label' => Yii::t('app', 'Property Pricing'),
                            'content' => Html::tag('div', $this->render(
                                'propertyPricingFields',
                                [
                                    'model' => $model,
                                    'form' => $form,
                                ]
                            ),
                                ['class' => 'col-md-12']
                            ),
                            'options' => [
                                'class' => 'chart',
                            ]
                        ],
                        [
                            'label' => Yii::t('app', 'Marketing & Media'),
                            'content' => Html::tag('div', $this->render(
                                'marketingMediaFields',
                                [
                                    'model' => $model,
                                    'form' => $form,
                                    'modelImg' => $modelImg,
                                    'modelImgTwo' => $modelImgTwo,
                                ]
                            ),
                                ['class' => 'col-md-12']
                            ),
                            'options' => [
                                'class' => 'chart',
                            ]
                        ],
                        [
                            'label' => Yii::t('app', 'Additional Info'),
                            'content' => Html::tag('div', $this->render(
                                'additionalInfoFields',
                                [
                                    'model' => $model,
                                    'form' => $form,
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
