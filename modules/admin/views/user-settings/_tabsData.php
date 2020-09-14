<?php
use yii\bootstrap\Carousel;
use mihaildev\ckeditor\CKEditor;
?>
<div id="notes-tab">
<ul class="nav nav-tabs">
    Marketing Photos
</ul>
<div class="property-list">
<div class="tab-content ">


<div class="tab-pane active" id="marketing-photos">
    <div class="tab-header">

    </div>

    <div class="tab-row user-row">
        <div class="bordered-property-block">
            <h4>User Marketing Photos</h4>
            <div id="media-tab">
                <div class="property-list">
                    <?php if (
                        Yii::$app->controller->action->id === 'create' or
                        Yii::$app->controller->action->id === 'update'
                    ) {?>
                        <?php
                        $this->registerCss(
                            'button.moreinfo {
                                margin: 0 auto;
                                display: block;
                                z-index: 99999;
                            }

                            .top-rentals-content div.carousel {
                                height: 61px !important;
                            }
                            '
                        );
                        yii\bootstrap\Modal::begin(
                            [
                                'header'       => '<h2>Edit / Add Photo</h2>',
                                'toggleButton' => [
                                    'label' => '<i class="fa fa-check-circle"></i> Edit / Add Photo',
                                    'class' => 'btn red-button',
                                    'id'    => 'addPhoto',
                                ],
                                'clientEvents' => [
                                    'shown.bs.modal' => "function() {
                                                var kvPreviewThumb = $('.kv-preview-thumb');

                                                kvPreviewThumb.find('.kv-file-remove').click(function(){
                                                    $.ajax({
                                                        url: '/web/users/user-settings/drop-img',
                                                        type: 'POST',
                                                        data: {userId : $('input[name=userId]').val()},
                                                        success: function(){
                                                        },
                                                        error: function(){
                                                        }
                                                    });
                                                    kvPreviewThumb.remove();
                                                });
                                            }",
                                    'hidden.bs.modal' => "function() { $('#addPhotoOKBtn').hide(); }",
                                ],
                                'footer' => '<button type="button" style="display: none;" id="addPhotoOKBtn" class="btn btn-default" data-dismiss="modal">'
                                    . Yii::t('app', 'OK')
                                    . '</button>',
                            ]
                        );
                        echo kartik\file\FileInput::widget([
                            'model'     => $modelImg,
                            'attribute' => 'imageFiles[]',
                            'language'  => 'en',
                            'options' => [
                                'accept'   => 'image/*',
                                'multiple' => false,
                            ],
                            'pluginOptions' => [
                                'showPreview'          => true,
                                'initialPreviewAsData' => true,
                                'overwriteInitial'     => true,
                                'showUpload'           => false,
                                'initialPreview'       => [$modelImgPrew],
                                'showCaption'          => false,
                                'showRemove'           => false,
                                'browseClass'          => 'btn btn-primary btn-block',
                                'browseIcon'           => '<i class="glyphicon glyphicon-camera" ></i> ',
                                'browseLabel'          => 'Select Photo',
//                                        'uploadUrl'            => \yii\helpers\Url::to(['/site/file-upload']),
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
                                'fileloaded' => "function() {
                                            $('#addPhotoOKBtn').fadeIn('slow');
                                        }",
                            ]
                        ]);

                        yii\bootstrap\Modal::end();
                        ?>
                    <?php } else {?>
                        <a href='<?=$modelImgPrew?>'  data-lightbox='gal1'><br><img class="img-responsive" src="<?=$modelImgPrew?>" style="" /></a>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="bordered-property-block">
            <h4><?= $model->getAttributeLabel('agent_bio')?></h4>
            <div id="bio-user-form" class="form clearfix">
                <?= $form->field($model, 'agent_bio')->widget(CKEditor::className(), [
                    'editorOptions' => [
                        'preset' => 'standard',
                        'language' => 'en',
                        'readOnly' => $disabled
                    ],
                ])->label(false)?>

            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>