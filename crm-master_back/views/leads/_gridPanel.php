<?php
use yii\web\View;
use yii\helpers\{Html, Url};
use app\classes\GridPanel;
?>

<input type="hidden" id="flag-listing" value="<?= $flagListing?>">

<div id="customizing-block" class="container-fluid clearfix">
    <?= $this->render('@app/views/modals/gridPanel/_columnsFilter', [
        'columnsGrid'         => $columnsGrid,
        'model'               => $model,
        'urlSaveColumnFilter' => $urlSaveColumnFilter,
        'userColumns'         => $userColumns
    ])?>

    <?= $this->render('@app/views/modals/gridPanel/_advancedSearch', [
        'advancedSearchPath' => $advancedSearchPath,
        'searchModel'        => $searchModel
    ])?>

    <?= $this->render('@app/views/modals/gridPanel/_addToDo', [
        'model'               => $model,
        'ref'                 => $model->reference,
        'usersDataProvider'   => $usersDataProvider
    ])?>

    <?= $this->render('@app/views/modals/gridPanel/_toDoList', [
        'taskManagerDataProvider' => $taskManagerDataProvider
    ])?>

    <div class="button-block first-block">
        <?php if($flagListing == GridPanel::STATUS_CURRENT_LISTING):?>
            <div style="display: inline-block;">
                <a class="btn" href="#"><i class="fa fa-mobile"></i> Send SMS</a>
            </div>
        <?php endif;?>
        <div style="display: inline-block;">
            <div class="error-box" id="errorBoxSelectItem">
                <label class="title"><?= Yii::t('app', 'Please select at least one record');?></label>
                <div>
                    <input type="button" value="<?= Yii::t('app', 'Close')?>" class="btn pull-right close-error-box">
                </div>
            </div>
        </div>
        <div style="display: inline-block;">
            <a class="btn" href="#" data-toggle="modal" data-target="#modal-advanced-search"><i class="fa fa-search"></i> Advanced Search</a>
        </div>
    </div>
    <div class="button-block second-block pull-right">
        <?php if($flagListing == GridPanel::STATUS_CURRENT_LISTING):?>
            <div class="display-inline-block">
                <a class="btn green-button" href="#" id="toggleActions">Actions<i class="fa fa-angle-down"></i></a>
                <div class="dropdown-custom" id="dropdown-actions">
                    <div>
                        <?php
                            if ($model->id) {
                                echo Html::a(Yii::t('app', 'Add To-Do'), '#', [
                                    'data-target' => '#modal-add-to-do',
                                    'data-toggle' => 'modal',
                                ]);
                            } else {
                                echo Html::a(Yii::t('app', 'Add To-Do'), '#', [
                                    'onclick' => 'bootbox.alert("' . Yii::t('app', 'Create Lead First') . '"); return false;'
                                ]);
                            }
                        ?>
                    </div>
                    <div>
                        <a href="#">Add Event</a>
                    </div>
                    <div>
                        <a href="#">Add Deal</a>
                    </div>
                    <div>
                        <a href="#">Add Listing</a>
                    </div>
                    <div class="border-top-dotted-1"></div>
                    <div>
                        <a href="#" id="export-leads-to-pdf"><?= Yii::t('app', 'Export to PDF')?></a>
                    </div>
                    <div>
                        <?php if(Yii::$app->user->can('excelExport')):?><a href="#" id="export-leads-to-xls"><?= Yii::t('app', 'Export to Excel')?></a><?php endif;?>
                    </div>
                </div>
            </div>
            <div class="display-inline-block">
                <a class="btn green-button" href="#" id="toggleView">View <i class="fa fa-angle-down"></i></a>
                <div class="dropdown-custom" id="dropdown-views">
                    <div>
                        <a data-target="#modal-to-do-gridview" data-toggle="modal" href="#">To-Do(<?= $taskManagerDataProvider->getTotalCount()?>)</a>
                    </div>
                    <div>
                        <a href="#">Events()</a>
                    </div>
                </div>
            </div>
        <?php endif;?>
        <?php if($flagListing == GridPanel::STATUS_ARCHIVE_LISTING):?>
            <div class="display-inline-block">
                <a class="btn green-button" href="#" id="toggleActions">Actions<i class="fa fa-angle-down"></i></a>
                <div class="dropdown-custom" id="dropdown-actions">
                    <div>
                        <a href="#" id="unarchive-items">Unarchive</a>
                    </div>
                </div>
            </div>
        <?php endif;?>
        <div class="display-inline-block">
            <a class="btn green-button" href="#" data-toggle="modal" data-target="#modal-columns-filter">Columns<i class="fa fa-angle-down"></i> </a>
        </div>
    </div>


</div>
