<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\models\Accounts */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="accounts-form">
        <div class="row">
            <section class="col-lg-12">
                <div class="nav-tabs-custom" style="cursor: move;">
                <?= Tabs::widget([
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Login Details'),
                            'content' => Html::tag('div', $this->render(
                                'loginDetailsFields',
                                [
                                    'model' => $model,
                                    'form' => $form,
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
                            'label' => Yii::t('app', 'User Marketing Photos'),
                            'content' => Html::tag('div', $this->render(
                                'userMarketingPhotosFields',
                                [
                                    'model' => $model,
                                    'form' => $form,
                                    'modelImg' => $modelImg,
                                ]
                            ),
                                ['class' => 'col-md-12']
                            ),
                            'options' => [
                                'class' => 'chart',
                            ]
                        ],
                        [
                            'label' => Yii::t('app', 'User Listing Sharing'),
                            'content' => Html::tag('div', $this->render(
                                'userListingSharingFields',
                                [
                                    'model' => $model,
                                    'form' => $form
                                ]
                            ),
                                ['class' => 'col-md-12']
                            ),
                            'options' => [
                                'class' => 'chart',
                            ]
                        ],
                        [
                            'label' => Yii::t('app', 'User Screen Settings'),
                            'content' => Html::tag('div', $this->render(
                                'userScreenSettingsFields',
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
                        [
                            'label' => Yii::t('app', 'Import Email Leads'),
                            'content' => Html::tag('div', $this->render(
                                'ImportEmailLeadsFields',
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
                        [
                            'label' => Yii::t('app', 'Specialization'),
                            'content' => Html::tag('div', $this->render(
                                'specializationFields',
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
