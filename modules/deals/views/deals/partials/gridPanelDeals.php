<?php
use yii\helpers\{Html, Url};
use app\classes\GridPanel;
use app\components\widgets\ListingsDealsSummaryWidget;

/**
 * @var $mainModel
 * @var $searchModel
 * @var $userColumns
 * @var $columnsGrid
 * @var string $urlSaveColumnFilter
 */
?>

<input type="hidden" id="flag-listing" value="">

<div id="customizing-block" class="container-fluid clearfix">

    <?php
        echo $this->render('@app/views/modals/gridPanel/_columnsFilter', [
            'columnsGrid'         => $columnsGrid,
            'model'               => $model,
            'urlSaveColumnFilter' => $urlSaveColumnFilter,
            'userColumns'         => $userColumns
        ]);
        echo $this->render('@app/views/modals/gridPanel/_advancedSearch', [
        'advancedSearchPath' => '@app/modules/deals/views/deals/partials/advancedSearch',
        'searchModel'        => $searchModel,
        ]);
        echo $this->render('@app/views/modals/eventForm');
    ?>

    <?php
//    echo ListingsDealsSummaryWidget::widget([
//        'model' => $mainModel,
//    ])
    ?>

    <div class="button-block first-block">
        <div style="display: inline-block;">
            <a class="btn" href="#" data-toggle="modal" data-target="#modal-advanced-search"><i class="fa fa-search"></i><?php echo ' ', Yii::t('app', 'Advanced Search')?></a>
        </div>
    </div>

    <div class="button-block second-block pull-right">
        <div class="display-inline-block">
            <a class="btn green-button" href="#" id="toggleActions"><?= Yii::t('app', 'Actions'), ' '?><i class="fa fa-angle-down"></i></a>
            <div class="dropdown-custom" id="dropdown-actions">
                <div>
                    <a href="#" id="addEventDeal">
                        <?= Yii::t('app', 'Add Event')?>
                    </a>
                </div>
            </div>
        </div>
        <div class="display-inline-block">
            <a class="btn green-button" href="#" id="toggleView"><?= Yii::t('app', 'View'), ' '?><i class="fa fa-angle-down"></i></a>
            <div class="dropdown-custom" id="dropdown-views">
                <div>
                    <a href="#">Events()</a>
                </div>
            </div>
        </div>
        <div class="display-inline-block">
            <a class="btn green-button" href="#" data-toggle="modal" data-target="#modal-columns-filter"><?= Yii::t('app', 'Columns'), ' '?><i class="fa fa-angle-down"></i> </a>
        </div>
    </div>
</div>