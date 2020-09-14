<?php
use yii\bootstrap\Carousel;
use yii\helpers\{Url, Html, ArrayHelper};
?>

<?php if (Yii::$app->controller->action->id === 'create' or Yii::$app->controller->action->id === 'update') : ?>
    <div class="col-md-6 rentals-big-block"><!-- Owner -->
        <h3><?= Yii::t('app', 'Owner')?></h3>
        <?= Html::input('text', '', $ownerRecord->last_name . " " . $ownerRecord->first_name, [
            'data-toggle'             => 'modal',
            'data-target'             => '#contacts-gridview',
            'data-url-search-handler' => Url::toRoute(['/contacts/search-handler']) . '/',
            'search-text-default'     => Yii::t('app', 'No results'),
            'class'                   => 'form-control cursor-pointer',
            'id'                      => 'change-landlord-id',
            'disabled'                => $disabledAttribute,
            'autocomplete'            => "off",
        ])?>
        <?= $form->field($topModel, 'landlord_id', [
            'template' => '{input}',
            'options'  => [
                'tag' => false,
            ],
        ])->hiddenInput(['id' => 'landlordId'])->label(false);?>
        <div class="owner-property property-list">
            <p><i class="fa fa-mobile"></i>
                <span id="owner-mobile">
                    <?= $ownerRecord->work_mobile
                        ? $ownerRecord->work_mobile
                        : $ownerRecord->personal_mobile; ?>
                </span>
            </p>
            <p><i class="fa fa-envelope"></i>
                <span id="owner-email">
                    <?= $ownerRecord->work_email
                        ? $ownerRecord->work_email
                        : $ownerRecord->personal_email; ?>
                </span>
            </p>
        </div>

        <div class="rentals-small-block"><!-- Information check-->
            <div id="portal-tab" >
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#portal1" data-toggle="tab">Portals</a>
                    </li>
                    <li><a href="#portal2" data-toggle="tab">Features</a>
                    </li>
                </ul>
                <div class="property-list">
                    <div class="tab-content ">
                        <div class="tab-pane active" id="portal1">
                            <input type="checkbox" id="deselect-portals"><label><?= Yii::t('app', 'Deselect all')?></label>
                            <br/>
                            <?php
                            $topModel->portals = (Yii::$app->controller->action->id == 'create')
                                ? array_keys($portalsItems)
                                : ArrayHelper::map($topModel->portalListing, 'portal_id', 'portal_id');
                            ?>
                            <?= $form->field($topModel, 'portals')->CheckBoxList($portalsItems, ['itemOptions' => ['class' => 'height-auto portal-item-checkbox']])->label(false);?>
                        </div>
                        <div class="tab-pane" id="portal2">
                            <br/>
                            <?php $topModel->features = ArrayHelper::map($topModel->featureListing, 'feature_id', 'feature_id');  ?>
                            <?= $form->field($topModel, 'features')->CheckBoxList($featuresItems, ['itemOptions' => ['class' => 'height-auto']])->label(false);?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /Information check-->
    </div><!--/Owner-->
<?php else: ?>
    <div class="col-md-6 rentals-big-block"><!-- Owner -->
        <h3><?= Yii::t('app', 'Owner')?></h3>
        <?= Html::a(
            $ownerRecord->last_name . " " . $ownerRecord->first_name,
            Url::toRoute(['/contacts/view', 'id' => $ownerRecord->id]),
            ['target' => '_blank', 'data-pjax' => '0']
        ) ?>
        <div class="owner-property property-list">
            <p><i class="fa fa-mobile"></i>
                <span id="owner-mobile">
                    <?= $ownerRecord->work_mobile
                        ? $ownerRecord->work_mobile
                        : $ownerRecord->personal_mobile; ?>
                </span>
            </p>
            <p><i class="fa fa-envelope"></i>
                <span id="owner-email">
                    <?= $ownerRecord->work_email
                        ? $ownerRecord->work_email
                        : $ownerRecord->personal_email; ?>
                </span>
            </p>
        </div>

        <div class="rentals-small-block"><!-- Information check-->
            <div id="portal-tab" >
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#portal1" data-toggle="tab">Portals</a>
                    </li>
                    <li><a href="#portal2" data-toggle="tab">Features</a>
                    </li>
                </ul>
                <div class="property-list">
                    <div class="tab-content ">
                        <div class="tab-pane active" id="portal1">
                            <br/>
                            <?php  $topModel->portals = (Yii::$app->controller->action->id == 'create')
                                ? array_keys($portalsItems)
                                : ArrayHelper::map($topModel->portalListing, 'portal_id', 'portal_id'); ?>
                            <?= $form->field($topModel, 'portals')->CheckBoxList($portalsItems, ['itemOptions' => ['class' => 'height-auto']])->label(false);?>
                        </div>
                        <div class="tab-pane" id="portal2">
                            <br/>
                            <?php $topModel->features = ArrayHelper::map($topModel->featureListing, 'feature_id', 'feature_id');  ?>
                            <?= $form->field($topModel, 'features')->CheckBoxList($featuresItems, ['itemOptions' => ['class' => 'height-auto']])->label(false);?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /Information check-->
    </div><!--/Owner-->
<?php endif; ?>

    <div class="col-md-6 rentals-big-block"><!--Marketing & Media-->
        <h3>Marketing & Media</h3>
        <div id="media-tab">
            <ul class="nav nav-tabs">
                <li class="active"><a  href="#media1" data-toggle="tab">Photos</a></li>
<!--                <li><a href="#media2" data-toggle="tab">Plans</a></li>
                <li><a href="#media3" data-toggle="tab">Other</a></li>-->
            </ul>
            <div class="property-list">
                <div class="tab-content ">
                    <div class="tab-pane active" id="media1">
                        
                    <?php
                    if (
                        Yii::$app->controller->action->id === 'create' or
                        Yii::$app->controller->action->id === 'update'
                    ):
                        ?>
                        <?php
                        $this->registerCss(
                            'button.moreinfo {
                                margin: 0 auto;
                                display: block;
                                z-index: 99999;
                            }
                            .modal-content {
                                width: 618px;
                            }

                            .top-rentals-content div.carousel {
                                height: 61px !important;
                            }
                            '
                        );
                        yii\bootstrap\Modal::begin(
                            [
                                'header' => '<h2>Add Photo</h2>',
                                'toggleButton' => [
                                    'label' => '<i class="fa fa-check-circle"></i> Edit / Add Photos',
                                    'class' => 'btn red-button',
                                    'id' => 'addPhoto',
                                ],
                                'clientEvents' => [
                                    'hidden.bs.modal' => "function() { $('#addPhotoOKBtn').hide(); }",
                                ],
                                'footer' => '<button type="button" style="display: none;" id="addPhotoOKBtn" class="btn btn-default" data-dismiss="modal">'
                                    . Yii::t('app', 'OK')
                                    . '</button>',
                            ]
                        );
                        
                        echo kartik\file\FileInput::widget([
                            'model' => $modelImg,
                            'attribute' => 'imageFiles[]',
                            'language' => 'en',
                            'options' => [
                                'class'    => 'upload-auto',
                                'accept'   => 'image/*',
                                'multiple' => true,
                            ],
                            'pluginOptions' => [
                                'showPreview' => true,
                                'initialPreviewAsData' => true,
                                'overwriteInitial' => false,
                                'showUpload' => false,
                                'initialPreview' => $modelImgPrew,
                                'previewFileType' => 'any',
                                'showCaption' => false,
                                'showRemove' => false,
                                'showDrag'    => true,
                                'browseClass' => 'btn btn-primary btn-block',
                                'browseIcon' => '<i class="glyphicon glyphicon-camera" ></i> ',
                                'browseLabel' => 'Select Photo',
//                                'uploadUrl' => \yii\helpers\Url::toRoute(['/sale/upload/' . $topModel->id]),
                            ],
                            'pluginEvents' => [
                                'change' => "function() { 
                                    $('#addPhotoOKBtn').fadeIn('slow');
                                }",
                                'filesorted' => "function() { 
                                    $('#addPhotoOKBtn').fadeIn('slow'); 
                                }",
                                'filezoomshow' => "function() { 
                                    $('#addPhotoOKBtn').fadeIn('slow'); 
                                }",
                                'fileclear' => "function() { 
                                    $('#addPhotoOKBtn').fadeIn('slow'); 
                                }",
                                'fileremoved' => "function() { $('#addPhotoOKBtn').fadeIn('slow');}",
                                'fileloaded' => "function(event, file, previewId, index, reader) {
                                    $('#'+ previewId + ' .file-actions').append('<p class=\"watermark\">Watermark on/off</p><label class=\"switch\"><input type=\"checkbox\" name=\"checimg[\%22/web/images/img/". $topModel->ref ."/'+ file.name +'\%22]\" ><span class=\"slider round\"></span></label>');
                                    $('#'+ previewId + ' .file-actions').after('<span class=\"file-drag-handle drag-handle-init text-info\" title=\"Move / Rearrange\"><i class=\"glyphicon glyphicon-move\"></i></span>');
                                    $('#'+ previewId).removeClass();
                                    $('#'+ previewId).addClass('file-preview-frame krajee-default  file-preview-initial file-sortable kv-preview-thumb');
                                   
                                    $('#addPhotoOKBtn').fadeIn('slow');
                                }",
                            ]
                        ]);

                        yii\bootstrap\Modal::end();
                        ?>
                    <?php else: ?>
                    
                        <?php
                        $carousel = [];
                        for ($i = 0; $i < count($modelImg); $i++) {
                            if(
                                file_exists(
                                    '../'.str_replace(
                                        '/web/images/img/'. $topModel->ref .'/', 
                                        '/web/images/img/' . $topModel->ref . '/watermark/' ,
                                         $modelImg[$i]
                                    )
                                )
                            ) {
                                $carousel[$i]['content'] = "<a href='" . str_replace(
                                    '/web/images/img/'. $topModel->ref .'/', 
                                    '/web/images/img/' . $topModel->ref . '/watermark/' ,
                                     $modelImg[$i]
                                ) . "'  data-lightbox='gal1'>" . '<img src="' . str_replace(
                                    '/web/images/img/'. $topModel->ref .'/', 
                                    '/web/images/img/' . $topModel->ref . '/watermark/' ,
                                     $modelImg[$i]
                                ) . '" />' . "</a>";
                            } else {
                                $carousel[$i]['content'] = "<a href='" . $modelImg[$i] . "'  data-lightbox='gal1'>" . '<img src="' . $modelImg[$i] . '" />' . "</a>";
                            }
                            
                        }

                        echo Carousel::widget([
                            'items' => $carousel,
                            'options' => ['class' => 'carousel slide', 'data-interval' => '12000'],
                            'controls' => [
                                '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>',
                                '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>'
                            ]
                        ]);
                        ?>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/Marketing & Media-->
<?php

//echo '<label class="control-label">Photos</label>';
//echo kartik\file\FileInput::widget([
//    'model'     => $modelImg,
//    'attribute' => 'imageFiles[]',
//    'language'  => 'en',
//    'options'   => [
//        'accept'   => 'image/*',
//        'multiple' => true,
//    ],
//    'pluginOptions' => [
//        'showPreview'          => true,
//        'initialPreviewAsData' => true,
//        'overwriteInitial'     => true,
//        'showUpload'           => false,
//        // 'initialPreview' => $model->imgUrl($modelImgTwo->imageFilesTwo),
//        'showCaption'          => false,
//        'showRemove'           => false,
//        'browseClass'          => 'btn btn-primary btn-block',
//        'browseIcon'           => '<i class="glyphicon glyphicon-camera"></i> ',
//        'browseLabel'          => 'Select Photo',
//        'uploadUrl'            => \yii\helpers\Url::toRoute(['/site/file-upload']),
//    ]
//]);
?>




