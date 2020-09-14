<?php
use yii\helpers\Html;
use app\classes\GridPanel;
use app\components\widgets\ListingsDealsIntSummaryWidget;
?>

<input type="hidden" id="flag-listing" value="">

<div id="customizing-block" class="container-fluid clearfix">


    <?= ListingsDealsIntSummaryWidget::widget([
        'model' => $mainModel,
    ])?>


    <div class="button-block first-block">
        <div style="display: inline-block;">
            <a class="btn" href="#" data-toggle="modal" data-target="#modal-advanced-search"><i class="fa fa-search"></i> Advanced Search</a>
        </div>
    </div>

    <div class="button-block second-block pull-right">
            <div class="display-inline-block">
                <a class="btn green-button" href="#" id="toggleActions">Actions<i class="fa fa-angle-down"></i></a>
                <div class="dropdown-custom" id="dropdown-actions">
                    <div>
                        <a href="">Add Event</a>
                    </div>
                </div>
            </div>
            <div class="display-inline-block">
                <a class="btn green-button" href="#" id="toggleView">View <i class="fa fa-angle-down"></i></a>
                <div class="dropdown-custom" id="dropdown-views">
                    <div>
<!--                        <a data-target="#modal-to-do-gridview" data-toggle="modal" href="#">To-Do(--><?//= $taskManagerDataProvider->getTotalCount()?><!--)</a>-->
                    </div>
                    <div>
                        <a href="#">Events()</a>
                    </div>
                    <div>
<!--                        <a href="#" data-target="#modal-leads-gridview" data-toggle="modal">Leads(--><?//= $leadsDataProvider->getTotalCount()?><!--)</a>-->
                    </div>
                    <div>
                        <a href="#">Deals()</a>
                    </div>
                    <div>
                        <a href="#">Owner()</a>
                    </div>
                </div>
            </div>
            <div class="display-inline-block">
                <a class="btn green-button" href="#" data-toggle="modal" data-target="#modal-columns-filter">Columns<i class="fa fa-angle-down"></i> </a>
            </div>
    </div>
</div>