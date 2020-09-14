<?php
use yii\helpers\{Html, Url};
use yii\widgets\Pjax;
use yii\grid\GridView;

?>
<div id="listings-tab">
    <ul class="nav nav-tabs">
        <li class="active">
            <a  href="#current-listings" data-toggle="tab" id="open-current-listings">Current Listings</a>
        </li>
        <li><a href="#archived-listings" data-toggle="tab" id="open-archived-listings">Archived Listings<span class="badge"><?=$contactsArchiveDataProvider->getTotalCount()?></span></a>
        </li>
    </ul>

    <div class="tab-content ">
        <div class="pane-header container-fluid clearfix"></div>
        <?php Pjax::begin(['id' => 'pjax-grid-panel']); ?>
        <?= $this->render('@app/views/contacts/_gridPanel', [
            'flagListing'         => \app\classes\GridPanel::STATUS_CURRENT_LISTING,
            'filteredColumns'     => $filteredColumns,
            'userColumns'         => $userColumns,
            'columnsGrid'         => $columnsGrid,
            'model'               => $model,
            'urlSaveColumnFilter' => Url::to(['contact/save-column-filter'])
        ])?>
        <?php Pjax::end(); ?>
        <div class="tab-pane active" id="current-listings">
            <div style="overflow-x: auto; padding-right: 0; padding-left: 0;" class=" container-fluid clearfix">
                <?= $this->render('_gridTable', [
                    'urlView' => 'contacts/view',
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'titleModel' => $titleModel,
                    'nationModel' => $nationModel,
                    'religionModel' => $religionModel,
                    'contactSourceModel' => $contactSourceModel,
                    'agents' => $agents,
                    'titles' => $titles,
                    'nationalities' => $nationalities,
                    'religions' => $religions,
                    'sources' => $sources,
                    'contactType' => $contactType,
                    'genderList' => $genderList,
                    'filteredColumns'  => $filteredColumns,
                    'topModel' => $model
                ])?>
            </div>
        </div>

        <div class="tab-pane" id="archived-listings">
            <?= $this->render('_gridTable', [
                'urlView' => 'contacts/view',
                'dataProvider' => $contactsArchiveDataProvider,
                'searchModel' => $contactsArchiveSearch,
                'titleModel' => $titleModel,
                'nationModel' => $nationModel,
                'religionModel' => $religionModel,
                'contactSourceModel' => $contactSourceModel,
                'agents' => $agents,
                'titles' => $titles,
                'nationalities' => $nationalities,
                'religions' => $religions,
                'sources' => $sources,
                'contactType' => $contactType,
                'genderList' => $genderList,
                'filteredColumns'  => $filteredColumns,
                'topModel' => $model
            ])?>
        </div>

    </div>
</div>