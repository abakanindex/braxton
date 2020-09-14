<?php

use kartik\datetime\DateTimePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use yii\widgets\Breadcrumbs;

/**
 * @var $firstRecord
 * @var $existRecord
 * @var $disabledAttribute
 * @var $usersSearchModel
 * @var $usersDataProvider
 * @var $listingRefDataProvider
 * @var $leadRefDataProvider
 * @var $source
 * @var $agents
 * @var $unitModel
 * @var $category
 * @var $locationsAll
 * @var $emirates
 * @var $locationsCurrent
 * @var $locations
 * @var $subLocations
 * @var $assignedToUser
 * @var $assignedToBuyer
 * @var $assignedToSeller
 * @var $assignedToLead
 * @var $userColumns
 * @var $filteredColumns
 */

$this->title = Yii::t('app', 'Deals');
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

<?php Pjax::begin(['id' => 'result']); ?>
<div class="deals-index">
    <div class="container-fluid top-rentals-content clearfix">
        <div class="head-rentals-property container-fluid">
            <?= $this->render(
                'partials/topButton',
                [
                    'topModel' => $firstRecord,
                    'existRecord' => $existRecord,
                ]
            )
            ?>

        </div>

        <div class="container-fluid content-rentals-property" id="result" >
            <?php $form = ActiveForm::begin([
                'options' => [
                    'enctype'   => 'multipart/form-data',
                    'class'     => 'form-horizontal',
                    'id'        => 'dealsSave',
                    'data-pjax' => true
                ]
            ]); ?>
            <div class="container-fluid rentals-left-block col-md-3"><!-- Left part-->
                <?= $this->render(
                    'partials/informationFields',
                    [
                        'topModel'               => $firstRecord,
                        'form'                   => $form,
                        'assignedToUser'         => $assignedToUser,
                        'assignedToBuyer'        => $assignedToBuyer,
                        'assignedToSeller'       => $assignedToSeller,
                        'assignedToLead'         => $assignedToLead,
                        'disabledAttribute'      => $disabledAttribute,
                        'usersSearchModel'       => $usersSearchModel,
                        'usersDataProvider'      => $usersDataProvider,
                        'listingRefDataProvider' => $listingRefDataProvider,
                        'leadRefDataProvider'    => $leadRefDataProvider,
                        'source'                 => $source,
                        'unitModel'              => $unitModel,
                    ]
                ) ?>
            </div><!-- /Left part-->
            <div class="container-fluid col-md-6"><!-- Middle part-->
                <div class="row big-column-height">
                    <?= $this->render(
                        'partials/transactionCommissionFields',
                        [
                            'topModel'          => $firstRecord,
                            'form'              => $form,
                            'disabledAttribute' => $disabledAttribute,
                            'agents'            => $agents,
                            'unitModel'         => $unitModel,
                            'category'          => $category,
                            'locationsAll'      => $locationsAll,
                            'emirates'          => $emirates,
                            'locationsCurrent'  => $locationsCurrent,
                            'locations'         => $locations,
                            'subLocations'      => $subLocations,
                        ]
                    ) ?>
                </div>

            </div><!-- /Middle part-->
            <?php ActiveForm::end(); ?>
            <?= $this->render('partials/tabs', [
                'topModel'        => $firstRecord,
            ])
            ?>
        </div><!-- /Right part-->
    </div>
</div><!---     Content       -->

<!--    Bottom Deals Block      -->
<div class="container-fluid  bottom-rentals-content clearfix">
    <div id="listings-deals-tab" >
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#current-listings" data-toggle="tab" id="open-current-listings"><?= Yii::t('app', 'Deals Summary') ?></a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="clearfix"></div>

            <?= $this->render('partials/gridPanelDeals', [
                'model'         => $firstRecord,
                'userColumns'   => $userColumns,
                'mainModel'     => new \app\modules\deals\models\Deals,
            ])?>

            <div class="tab-pane tab-pane-grid active" id="current-listings">
                <!-- BIG listings Table-->
                <div style="overflow-x: auto; padding-right: 0; padding-left: 0;" class="replace-grid-listing container-fluid clearfix">
                    <?= $this->render('partials/gridTable', [
                        'dataProvider'     => $dataProvider,
                        'urlView'          => 'deals/deals-international/view',
                        'filteredColumns'  => $filteredColumns,
                        'topModel'         => $firstRecord,
                    ])?>
                </div>
            </div>
        </div>
    </div>
</div><!--    /Bottom Rentals Block      -->
<?php Pjax::end(); ?>
