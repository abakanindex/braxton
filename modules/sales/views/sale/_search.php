<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\classes\GridPanel;
use app\models\Sale;
/* @var $this yii\web\View */
/* @var $model app\models\SaleSearch */
/* @var $form yii\widgets\ActiveForm */

switch($flagListing) {
    case GridPanel::STATUS_ARCHIVE_LISTING:
        $searchModel->status = Sale::STATUS_UNPUBLISHED;
        break;
    case GridPanel::STATUS_PENDING_LISTING:
        $searchModel->status = Sale::STATUS_PENDING;
        break;
    case GridPanel::STATUS_CURRENT_LISTING:
    default:
    $searchModel->status = Sale::STATUS_PUBLISHED;
        break;
}
?>

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
                <?= $searchModel->getAttributeLabel('completion_status')?>
            </label>
            <div class="col-sm-6 float-right">
                <?= $formSearch->field($searchModel, 'completion_status', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->dropDownList(
                        [
                            'Completed Property' => Yii::t('app', 'Completed Property'),
                            'Off-plan'           => Yii::t('app', 'Off-plan')
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
                <?= $searchModel->getAttributeLabel('category')?>
            </label>
            <div class="col-sm-6 float-right">
                <?= $formSearch->field($searchModel, 'category_id', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->dropDownList(
                        $category,
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
                <?= $searchModel->getAttributeLabel('beds')?>
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
                <?= $searchModel->getAttributeLabel('baths')?>
            </label>
            <div class="col-sm-6 float-right">
                <?= $formSearch->field($searchModel, 'baths', [
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
                <?= $searchModel->getAttributeLabel('rera_permit')?>
            </label>
            <div class="col-sm-6 float-right">
                <?= $formSearch->field($searchModel, 'rera_permit', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label>
                <?= $searchModel->getAttributeLabel('tenure')?>
            </label>
            <div class="col-sm-6 float-right">
                <?= $formSearch->field($searchModel, 'tenure', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->dropDownList(
                        [
                            'Freehold'  => Yii::t('app', 'Freehold'),
                            'Leasehold' => Yii::t('app', 'Leasehold'),
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
                <?= $searchModel->getAttributeLabel('unit')?>
            </label>
            <div class="col-sm-6 float-right">
                <?= $formSearch->field($searchModel, 'unit', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label>
                <?= $searchModel->getAttributeLabel('unit_type')?>
            </label>
            <div class="col-sm-6 float-right">
                <?= $formSearch->field($searchModel, 'unit_type', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label>
                <?= $searchModel->getAttributeLabel('floor_no')?>
            </label>
            <div class="col-sm-6 float-right">
                <?= $formSearch->field($searchModel, 'floor_no', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>
                <?= $searchModel->getAttributeLabel('size')?>
            </label>
            <div class="col-sm-6 float-right">
                <?= $formSearch->field($searchModel, 'size', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label>
                <?= $searchModel->getAttributeLabel('plot_size')?>
            </label>
            <div class="col-sm-6 float-right">
                <?= $formSearch->field($searchModel, 'plot_size', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label>
                <?= $searchModel->getAttributeLabel('view_id')?>
            </label>
            <div class="col-sm-6 float-right">
                <?= $formSearch->field($searchModel, 'view_id', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label>
                <?= $searchModel->getAttributeLabel('furnished')?>
            </label>
            <div class="col-sm-6 float-right">
                <?= $formSearch->field($searchModel, 'furnished', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->dropDownList(
                        [
                            'Furnished'        => Yii::t('app', 'Furnished'),
                            'Unfurnished'      => Yii::t('app', 'Unfurnished'),
                            'Partly Furnished' => Yii::t('app', 'Partly Furnished'),
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
                            'Published'   => Yii::t('app', 'Published'),
                            'Unpublished' => Yii::t('app', 'Unpublished'),
                            'Draft'       => Yii::t('app', 'Draft'),
                            'Pending'     => Yii::t('app', 'Pending')
                        ],
                        [
                            'class'    => 'form-control',
                            'prompt'   => '',
                            'disabled' => 'disabled'
                        ]

                    )->label(false);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label>
                <?= $searchModel->getAttributeLabel('prop_status')?>
            </label>
            <div class="col-sm-6 float-right">
                <?= $formSearch->field($searchModel, 'prop_status', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->dropDownList(
                        [
                            'Available' => Yii::t('app', 'Available'),
                            'Off-Plan'  => Yii::t('app', 'Off-Plan'),
                            'Pending'   => Yii::t('app', 'Pending'),
                            'Reserved'  => Yii::t('app', 'Reserved'),
                            'Sold'      => Yii::t('app', 'Sold'),
                            'Upcoming'  => Yii::t('app', 'Upcoming'),
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
                <?= $searchModel->getAttributeLabel('source_of_listing')?>
            </label>
            <div class="col-sm-6 float-right">
                <?= $formSearch->field($searchModel, 'source_of_listing', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->dropDownList(
                        $source,
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
                <?= $searchModel->getAttributeLabel('featured')?>
            </label>
            <div class="col-sm-6 float-right">
                <?= $formSearch->field($searchModel, 'featured', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->dropDownList(
                        [
                            'Yes' => Yii::t('app', 'Yes'),
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
                <?= $searchModel->getAttributeLabel('managed')?>
            </label>
            <div class="col-sm-6 float-right">
                <?= $formSearch->field($searchModel, 'managed', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->dropDownList(
                        [
                            'No'  => Yii::t('app', 'No'),
                            'Yes' => Yii::t('app', 'Yes'),
                        ],
                        [
                            'class'    => 'form-control',
                            'prompt'   => ''
                        ]

                    )->label(false);
                ?>
            </div>
        </div>
    </div>
    </div>
    <div class="pull-right">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary', 'id' => 'btn-submit-advanced-search']) ?>
    </div>
    <div class="clearfix"></div>

<?php $formSearch = ActiveForm::end(); ?>