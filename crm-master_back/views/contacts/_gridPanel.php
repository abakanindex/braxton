<?php
use yii\helpers\Html;
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
    </div>
    <div class="button-block second-block pull-right">
        <?php if($flagListing == GridPanel::STATUS_CURRENT_LISTING):?>
            <div class="display-inline-block">
                <a class="btn green-button" href="#" id="toggleView">View <i class="fa fa-angle-down"></i></a>
                <div class="dropdown-custom" id="dropdown-views">
                    <div>
                        <a href="#">Properties()</a>
                    </div>
                    <div>
                        <a href="#">Deals()</a>
                    </div>
                </div>
            </div>
            <div class="display-inline-block">
                <a class="btn green-button" href="#" data-toggle="modal" data-target="#modal-columns-filter">Columns<i class="fa fa-angle-down"></i> </a>
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
            <div class="display-inline-block">
                <a class="btn green-button" href="#" data-toggle="modal" data-target="#modal-columns-filter">Columns<i class="fa fa-angle-down"></i> </a>
            </div>
        <?php endif;?>
    </div>
</div>