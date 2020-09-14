<?php
use yii\helpers\Html;
use app\classes\GridPanel;
use app\components\widgets\ListingsSummaryWidget;
?>

<input type="hidden" id="flag-listing" value="<?= $flagListing?>">

<div id="customizing-block" class="container-fluid clearfix">
    <?= $this->render('@app/views/modals/gridPanel/_downloadPdf', [])?>

    <?= $this->render('@app/views/modals/gridPanel/_downloadPoster', [])?>

    <?= $this->render('@app/views/modals/gridPanel/_downloadBrochure', [])?>

    <?= $this->render('@app/views/modals/gridPanel/_leadsList', [
        'leadsDataProvider' => $leadsDataProvider
    ])?>

    <?= $this->render('@app/views/modals/gridPanel/_toDoList', [
        'taskManagerDataProvider' => $taskManagerDataProvider
    ])?>

    <?= $this->render('@app/views/modals/gridPanel/_addLead', [
        'model' => $model
    ])?>

    <?= $this->render('@app/views/modals/gridPanel/_addDeal', [
        'model' => $model,
        'ownerRecord' => $ownerRecord,
        'categories' => $category,
        'emiratesDropDown' => $emiratesDropDown,
        'locationDropDown' => $locationDropDown,
        'subLocationDropDown' => $subLocationDropDown,
    ])?>

    <?= $this->render('@app/views/modals/gridPanel/_addToDo', [
        'model'               => $model,
        'ref'                 => $model->ref,
        'usersDataProvider'   => $usersDataProvider
    ])?>

    <?= $this->render('@app/views/modals/gridPanel/_columnsFilter', [
        'columnsGrid'         => $columnsGrid,
        'model'               => $model,
        'urlSaveColumnFilter' => $urlSaveColumnFilter,
        'userColumns'         => $userColumns
    ])?>

    <?= $this->render('@app/views/modals/gridPanel/_advancedSearch', [
        'advancedSearchPath' => $advancedSearchPath,
        'searchModel'        => $searchModel,
        'source'             => $source,
        'portalsItems'       => $portalsItems,
        'featuresItems'      => $featuresItems,
        'agentUser'          => $agentUser,
        'owner'              => $owner,
        'category'           => $category,
        'flagListing'        => $flagListing
    ])?>

    <?= $this->render('@app/views/modals/gridPanel/_bulkUpdate', [
        'emirates'           => $emirates,
        'source'             => $source,
        'portalsItems'       => $portalsItems,
        'featuresItems'      => $featuresItems,
        'agentUser'          => $agentUser,
        'owner'              => $owner,
        'category'           => $category
    ])?>

    <?php if($flagListing == GridPanel::STATUS_CURRENT_LISTING || $flagListing == GridPanel::STATUS_PENDING_LISTING):?>
        <div class="button-block first-block">
            <div style="display: inline-block;">
                <a class="btn" id="publishRecords" href="#"><i class="fa fa-check-circle"></i> Published</a>
                <a class="btn red-button" id="unPublishRecords" href="#"><i class="fa fa-times-circle"></i> Unpublished</a>
                <div class="error-box" id="errorBoxSelectItem">
                    <label class="title"><?= Yii::t('app', 'Please select at least one record');?></label>
                    <div>
                        <input type="button" value="<?= Yii::t('app', 'Close')?>" class="btn pull-right close-error-box">
                    </div>
                </div>
            </div>
            <div style="display: inline-block;">
                <a class="btn" href="#" id="toggleShareOptions"><i class="fa fa-cloud-download"></i> Share Options</a>
                <div class="error-box" id="shareOptionsBox">
                    <div>
                        <i class="fa fa-file-pdf-o"></i>
                        <a href="#" data-toggle="modal" data-target="#modal-download-brochure">
                            <?= Yii::t('app', 'Download  selected listing as PDF brochure');?>
                        </a>
                    </div>
                    <div>
                        <i class="fa fa-file-pdf-o"></i>
                        <a href="#" data-toggle="modal" data-target="#modal-download-poster">
                            <?= Yii::t('app', 'Download  selected listing as A3 poster');?>
                        </a>
                    </div>
                    <div>
                        <i class="fa fa-file-pdf-o"></i>
                        <a href="#" id="download-listing-as-pdf-table">
                            <?= Yii::t('app', 'Download selected listing(s) as PDF table');?>
                        </a>
                    </div>
                    <div class="border-top-dotted-1"></div>
                    <div>
                        <a data-target="#modal-send-links-to-preview-page" data-toggle="modal"
                           href="#"><?= Yii::t('app', 'Send links to preview pages')?></a>
                    </div>
                    <div>
                        <a data-target="#modal-send-links-to-preview-page" data-toggle="modal"
                           href="#"><?= Yii::t('app', 'Send Pdf brochure')?></a>
                    </div>
                    <div>
                        <input type="button" value="<?= Yii::t('app', 'Close')?>" class="btn pull-right close-error-box">
                    </div>
                </div>
                <a class="btn" href="#" data-toggle="modal" data-target="#modal-advanced-search"><i class="fa fa-search"></i> Advanced Search</a>
            </div>
            <div style="display: inline-block;">
                <?php if(Yii::$app->user->can('smsAllowed')):?><a class="btn" href="#"><i class="fa fa-mobile"></i> Send SMS</a><?php endif;?>
                <a class="btn" href="#" id="bulkUpdate"><i class="fa fa-th-list"></i> Bulk Update</a>
            </div>
        </div>
    <?php endif;?>

    <?php if ($flagListing == GridPanel::STATUS_ARCHIVE_LISTING):?>
        <div class="button-block first-block">
            <div style="display: inline-block;">
                <div class="error-box" id="errorBoxSelectItem">
                    <label class="title"><?= Yii::t('app', 'Please select at least one record');?></label>
                    <div>
                        <input type="button" value="<?= Yii::t('app', 'Close')?>" class="btn pull-right close-error-box">
                    </div>
                </div>
                <a class="btn" href="#" data-toggle="modal" data-target="#modal-advanced-search"><i class="fa fa-search"></i> Advanced Search</a>
            </div>
        </div>
    <?php endif;?>


    <div class="button-block second-block pull-right">
        <?php if($flagListing == GridPanel::STATUS_CURRENT_LISTING || $flagListing == GridPanel::STATUS_PENDING_LISTING):?>
            <div class="display-inline-block">
                <a class="btn green-button" href="#" id="toggleActions">Actions<i class="fa fa-angle-down"></i></a>
                <div class="dropdown-custom" id="dropdown-actions">
                    <div>
                        <a href="" data-target="#modal-add-to-do" data-toggle="modal">Add To-Do</a>
                    </div>
                    <div>
                        <a href="">Add Event</a>
                    </div>
                    <div>
                        <a href="#" data-target="#modal-add-lead" data-toggle="modal">Add Lead</a>
                    </div>
                    <div>
                        <a href="#" data-target="#modal-add-deal" data-toggle="modal">Add Deal</a>
                    </div>
                    <div class="dropdown-separator"></div>
                    <div>
                        <a href="#">Copy Listing</a>
                    </div>
                    <div class="dropdown-separator"></div>
                    <div>
                        <?= Html::a(
                            Yii::t('app', ' Archive'),
                            ['archive', 'id' => $model->id],
                            [
                                'data'  => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to archive this item?'),
                                    'method'  => 'post',
                                ],
                                'data-pjax' => true
                            ]
                        )
                        ?>
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
                        <a href="#">Events</a>
                    </div>
                    <div>
                        <a href="#" data-target="#modal-leads-gridview" data-toggle="modal">Leads(<?= $leadsDataProvider->getTotalCount()?>)</a>
                    </div>
                    <div>
                        <a href="#">Deals</a>
                    </div>
                    <div>
                        <a href="#" id="grid-redirect-to-owner-page">Owner</a>
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
                <a class="btn green-button" href="#" id="toggleView">View <i class="fa fa-angle-down"></i></a>
                <div class="dropdown-custom" id="dropdown-views">
                    <div>
                        <a data-target="#modal-to-do-gridview" data-toggle="modal" href="#">To-Do(<?= $taskManagerDataProvider->getTotalCount()?>)</a>
                    </div>
                    <div>
                        <a href="#">Events()</a>
                    </div>
                    <div>
                        <a href="#" data-target="#modal-leads-gridview" data-toggle="modal">Leads(<?= $leadsDataProvider->getTotalCount()?>)</a>
                    </div>
                    <div>
                        <a href="#">Deals()</a>
                    </div>
                    <div>
                        <a href="#">Owner()</a>
                    </div>
                </div>
            </div>
        <?php endif;?>
    </div>
</div>



