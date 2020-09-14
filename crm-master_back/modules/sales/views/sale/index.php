<?php

use yii\helpers\{
    Html, Url
};
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use app\components\widgets\MatchLeadsWidget;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SaleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Sales');
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('@app/views/modals/_createFirst', [
    'message' => Yii::t('app', 'Create listing first')
]);
$this->registerJsFile('@web/js/show-modal-create-first.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>


<?= $this->render('@app/views/modals/shareOptions/_sendData', [
    'contactsDataProvider' => $contactsDataProvider,
    'contactsSearchModel'  => $contactsSearchModel,
    'myLeadsDataProvider'  => $myLeadsDataProvider,
    'leadsSearchModel'     => $leadsSearchModel
])?>

<?php
echo $drop;
echo $this->render('@app/views/modals/_usersList', [
    'usersDataProvider' => $usersDataProvider,
    'usersSearchModel'  => $usersSearchModel,
    'gridVersion'       => '@app/views/modals/partsUsersList/_gridVersionOne'
]);
echo $this->render('@app/views/modals/_ownerList', [
    'contactsDataProvider' => $contactsDataProvider,
    'contactsSearchModel' => $contactsSearchModel
]);
echo $this->render('@app/views/modals/_listingDescription', [
    'model' => $firstRecord
]);
echo $this->render('@app/views/modals/_viewingReportForm');
?>
<?php //Pjax::begin(['id' => 'result']); ?>
    <div class="sale-index">
        <?= MatchLeadsWidget::widget(['record' => $firstRecord]) ?>
        <!--    Top Rentals Block     -->
        <div class="container-fluid top-rentals-content clearfix">
            <div class="head-rentals-property container-fluid">
                <?= Breadcrumbs::widget([
                    'homeLink' => ['label' => Yii::t('app', 'Home'), 'url' => '/'],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <h2><?= Html::encode($this->title) ?></h2>
                <?= $this->render(
                    '_topButton',
                    [
                        'topModel' => $firstRecord,
                        'existRecord' => $existRecord,
                    ]
                )
                ?>
            </div>

            <div class="container-fluid content-rentals-property" id="result">
                <?php $form = ActiveForm::begin([
                    'options' => [
                        'enctype' => 'multipart/form-data',
                        'class' => 'form-horizontal',
                        'id' => 'saleSave',
                        'data-pjax' => true
                    ]
                ]); ?>
                <div class="container-fluid rentals-left-block col-md-3"><!-- Left part-->
                    <?= $this->render(
                        '_propertyAddressDetailsFields',
                        [
                            'topModel' => $firstRecord,
                            'form' => $form,
                            'agentUser' => $agentUser,
                            'owner' => $owner,
                            'category' => $category,
                            'disabledAttribute' => $disabledAttribute,
                            'usersSearchModel' => $usersSearchModel,
                            'usersDataProvider' => $usersDataProvider,
                            'assignedToUser' => $assignedToUser,
                            'emirates' => $emirates,
                            'locations' => $locations,
                            'subLocations' => $subLocations,
                            'locationsCurrent' => $locationsCurrent,
                            'subLocationsCurrent' => $subLocationsCurrent,
                            'locationsAll' => $locationsAll
                        ]
                    ) ?>
                </div><!-- /Left part-->
                <div class="container-fluid col-md-6"><!-- Middle part-->
                    <div class="row big-column-height">
                        <?= $this->render(
                            '_marketingMediaFields',
                            [
                                'topModel' => $firstRecord,
                                'form' => $form,
                                'owner' => $owner,
                                'disabledAttribute' => $disabledAttribute,
                                'modelImg' => $modelImg,
                                'modelImgPrew' => $modelImgPrew,
                                'ownerRecord' => $ownerRecord,
                                'portalsItems' => $portalsItems,
                                'featuresItems' => $featuresItems,
                            ]
                        ) ?>
                    </div>
                    <?= $this->render(
                        '_additionalInfoFields',
                        [
                            'topModel' => $firstRecord,
                            'form' => $form,
                            'source' => $source,
                            'disabledAttribute' => $disabledAttribute,
                        ]) ?>

                </div><!-- /Middle part-->
                <?php ActiveForm::end(); ?>
                <?= $this->render('_tabs', [
                    'topModel' => $firstRecord,
                    'historyProperty' => $historyProperty
                ])
                ?>
            </div><!-- /Right part-->


        </div><!--    /Top Rentals Block      -->

    </div><!---     Content       -->

    <!--    Bottom Rentals Block      -->
    <div class="container-fluid  bottom-rentals-content clearfix">
        <div id="listings-tab">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#current-listings" data-toggle="tab" id="open-current-listings">Current Listings</a>
                </li>
                <li><a href="#archived-listings" data-toggle="tab" id="open-archived-listings">Archived Listings<span
                                class="badge"><?= $saleArchiveDataProvider->getTotalCount() ?></span></a>
                </li>
                <li><a href="#pending-listings" data-toggle="tab" id="open-pending-listings">Pending Listings<span
                                class="badge"><?= $salePendingDataProvider->getTotalCount() ?></span></a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="clearfix"></div>
                <?php Pjax::begin(['id' => 'pjax-grid-panel']); ?>
                <?= $this->render('@app/views/parts/_gridPanelSaleRental', [
                    'flagListing' => \app\classes\GridPanel::STATUS_CURRENT_LISTING,
                    'emirates' => $emirates,
                    'locations' => $locations,
                    'subLocations' => $subLocations,
                    'source' => $source,
                    'portalsItems' => $portalsItems,
                    'featuresItems' => $featuresItems,
                    'agentUser' => $agentUser,
                    'owner' => $owner,
                    'ownerRecord' => $ownerRecord,
                    'category' => $category,
                    'searchModel' => $advancedSearch,
                    'advancedSearchPath' => '/sale/_search',
                    'columnsGrid' => $columnsGrid,
                    'model' => $firstRecord,
                    'urlSaveColumnFilter' => Url::toRoute(['/sales/sale/save-column-filter']),
                    'userColumns' => $userColumns,
                    'leadsDataProvider' => $leadsDataProvider,
                    'usersDataProvider' => $usersDataProvider,
                    'taskManagerDataProvider' => $taskManagerDataProvider,
                    'mainModel' => new \app\models\Sale(),
                    'archiveModel' => new \app\models\SaleArchive(),
                    'pendingModel' => new \app\models\SalePending(),
                    'emiratesDropDown' => $emirates,
                    'locationDropDown' => $locationDropDown,
                    'subLocationDropDown' => $subLocationDropDown,
                ]) ?>
                <?php Pjax::end(); ?>
                <div class="tab-pane tab-pane-grid active" id="current-listings">
                    <!-- BIG listings Table-->
                    <div style="overflow-x: auto; padding-right: 0; padding-left: 0;"
                         class="replace-grid-listing container-fluid clearfix">
                        <?= $this->render('_gridTable', [
                            'dataProvider'        => $dataProvider,
                            'searchModel'         => $searchModel,
                            'model'               => $model,
                            'urlView'             => 'sales/sale/view',
                            'filteredColumns'     => $filteredColumns,
                            'category'            => $category,
                            'emiratesDropDown'    => $emirates,
                            'locationDropDown'    => $locationDropDown,
                            'subLocationDropDown' => $subLocationDropDown,
                            'topModel'            => $firstRecord,
                            'locationsSearch'     => $locationsSearch,
                            'subLocationsSearch'  => $subLocationsSearch,
                            'sales'               => $sales
                        ])?>
                    </div>
                </div>
                <div class="tab-pane tab-pane-grid" id="archived-listings">
                    <div style="overflow-x: auto; padding-right: 0; padding-left: 0;"
                         class="replace-grid-listing container-fluid clearfix">
                        <?= $this->render('_gridTable', [
                            'dataProvider'        => $saleArchiveDataProvider,
                            'searchModel'         => $saleArchiveSearch,
                            'model'               => $model,
                            'urlView'             => 'sales/sale/view',
                            'filteredColumns'     => $filteredColumns,
                            'category'            => $category,
                            'emiratesDropDown'    => $emirates,
                            'locationDropDown'    => $locationDropDown,
                            'subLocationDropDown' => $subLocationDropDown,
                            'topModel'            => $firstRecord,
                            'locationsSearch'     => $locationsSearch,
                            'subLocationsSearch'  => $subLocationsSearch,
                            'sales'               => $sales
                        ])?>
                    </div>
                </div>
                <div class="tab-pane tab-pane-grid" id="pending-listings">
                    <div style="overflow-x: auto; padding-right: 0; padding-left: 0;"
                         class="replace-grid-listing container-fluid clearfix">
                        <?= $this->render('_gridTable', [
                            'dataProvider'        => $salePendingDataProvider,
                            'searchModel'         => $salePendingSearch,
                            'model'               => $model,
                            'urlView'             => 'sales/sale/view',
                            'filteredColumns'     => $filteredColumns,
                            'category'            => $category,
                            'emiratesDropDown'    => $emirates,
                            'locationDropDown'    => $locationDropDown,
                            'subLocationDropDown' => $subLocationDropDown,
                            'topModel'            => $firstRecord,
                            'locationsSearch'     => $locationsSearch,
                            'subLocationsSearch'  => $subLocationsSearch,
                            'sales'               => $sales
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

    </div><!--    /Bottom Rentals Block      -->

<?php //Pjax::end(); ?>

<?php
echo $this->render('@app/views/scripts/_gridPanelSaleRental', [
    'urlMakePublished' => Url::toRoute(['/sales/sale/make-published']),
    'urlMakeUnPublished' => Url::toRoute(['/sales/sale/make-unpublished']),
    'urlBulkUpdate' => Url::toRoute(['/sales/sale/bulk-update']),
    'locations' => $locations,
    'subLocations' => $subLocations,
    'urlGridPanelArchive' => Url::toRoute(['/sales/sale/grid-panel-archive']),
    'urlGridPanelCurrent' => Url::toRoute(['/sales/sale/grid-panel-current']),
    'urlGridPanelPending' => Url::toRoute(['/sales/sale/grid-panel-pending']),
    'urlUnArchive' => Url::toRoute(['/sales/sale/unarchive']),
    'urlDownloadListingAsPdfTable' => Url::toRoute(['/sales/sale/generate-pdf-table']),
    'urlGeneratePoster' => Url::toRoute(['/sales/sale/generate-poster']),
    'urlGenerateBrochure' => Url::toRoute(['/sales/sale/generate-brochure']),
    'urlGetContact' => Url::toRoute(['/contact/get-by-ref']),
    'urlGetLead'    => Url::toRoute(['/lead/get-by-ref']),
    'urlSharePreviewLinks' => Url::toRoute(['/site/share-preview-links']),
    'urlShareBrochure'     => Url::toRoute(['/site/share-brochure']),
    'page' => (empty(Yii::$app->request->get('page')) ? '1' : Yii::$app->request->get('page')),
    'urlGetListOwners' => Url::toRoute(['/sales/sale/get-list-owners'])
]);

?>





<?php
$script = <<<JS
    $('.file-actions').append('<p class="watermark">Watermark on/off</p><label class="switch"><input type="checkbox" name="" ><span class="slider round"></span></label>');
    
    $(document).on('pjax:send', function() {
        startLoadingProcess();
    });
    
    $(document).on('pjax:success', function(e) {
        finishLoadingProcess();
        if (typeof e.relatedTarget !== "undefined" && e.relatedTarget.className == 'view-contact') {
            $('html, body').animate({ scrollTop: 0 }, 1000);
        }
    });
    
    var urlImg = [];

    $('.kv-preview-thumb img').each(function(index) {
        urlImg[index] = $(this).attr('src');

    });

  
    
    $('.kv-preview-thumb .kv-file-remove').each(function(index) {
        $(this).attr('data-url', urlImg[index]);
        $(this).attr('index', index);
    });
    
    $('.kv-preview-thumb .kv-file-remove').click(function(){
        var url = $(this).attr('data-url');
        var index = $(this).attr('index');
        $.ajax({
            url: '/web/sales/drop-img',
            type: 'POST',
            data: {url : url, ref : '$firstRecord->ref' },
            success: function(){
            },
            error: function(){
            }
        });
        
        $('[data-fileindex=\"init_' + index + '\"]').remove();
    });
            
    $('body').on('beforeSubmit', 'form#note-form', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();   
        var form = $(this);
        if (form.find('.has-error').length) {
            return false;
        }
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (response) {
                $('#create-note-modal').modal('hide');
                $.pjax.reload({container: '#notes-pa-list', timeout: 2000}); 
            }
        });
        return false;              
    });
JS;
$this->registerJs($script, View::POS_READY);

$this->registerJsFile(
    '@web/js/for-listings.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);
?>



<script>
    window.onload = function() {
    var imgExist = [
            <?php
                $carousel = [];
                for ($i = 0; $i < count($modelImgPrew); $i++) {
                    if(
                        file_exists(
                            '../'.str_replace(
                                '/web/images/img/'. $firstRecord->ref .'/', 
                                '/web/images/img/' . $firstRecord->ref . '/watermark/' ,
                                $modelImgPrew[$i]
                            )
                        )
                    ) {
                        echo '"';
                        echo str_replace(
                            '/web/images/img/'. $firstRecord->ref .'/', 
                            '/web/images/img/' . $firstRecord->ref . '/watermark/' ,
                            $modelImgPrew[$i]
                        );
                        echo '",';
                    } 
                }
            ?>
        ];
        
        var urlImg = [];

        $('.kv-preview-thumb img').each(function(index) {
            urlImg[index] = $(this).attr('src');

        });

        $('.kv-preview-thumb input').each(function(index) { 
            if(
                imgExist[index] == urlImg[index].replace(
                    '/web/images/img/<?php echo $firstRecord->ref; ?>/'
                    ,'/web/images/img/<?php echo $firstRecord->ref; ?>/watermark/'
                )
            ) {
                console.log(urlImg[index]);
                $(this).attr('checked', true);
            }          
            $(this).attr('name', 'checimg["' + urlImg[index] + '"]');
           
        });
        
    }

   
</script>