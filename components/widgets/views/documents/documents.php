<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<div class="tab-header clearfix">
    <?php if(Yii::$app->user->can('contractsCreate')):?>
        <?php $form = ActiveForm::begin([
            'action' => $urlForm,
            'options' => [
                'enctype' => 'multipart/form-data',
                'id' => 'documents-form',
            ]
        ]);?>
        <div class="form-group">
            <label for="documentsFile" class="control-label"><?= Yii::t('app', 'Document')?></label>
            <div class="">
                <?= $form->field($model, 'files[]', [
                    'template' => '{input}',
                    'options' => [
                        'tag' => false,
                    ],
                ])->fileInput(['multiple' => false, 'id' => 'document-files-widget'])?>
            </div>
        </div>
        <div class="form-group">
            <?= $form->field($model, 'name', [
                'template' => '{input}',
                'options' => [
                    'tag' => false,
                ]
            ])->textInput(['placeholder' => Yii::t('app', 'Document name. Without extension')]);?>
        </div>
        <div class="form-group">
            <?= $form->field($model, 'category')->dropDownList($documentCategories, ['prompt' => Yii::t('app', 'Select category')])->label(false)?>
        </div>
        <div class="form-group">
            <?= $form->field($model, 'ref', [
                'template' => '{input}',
                'options' => [
                    'tag' => false,
                ],
            ])->textInput(['value' => $ref, 'class' => 'hidden'])?>
        </div>
        <?= Html::hiddenInput('keyType', $keyType)?>
        <?= Html::submitButton(
            Yii::t('app', 'Click to add Document'),
            [
                'class' => 'btn col-md-12'
            ]
        )?>
        <?php $form = ActiveForm::end()?>
    <?endif;?>
</div>
<div class="tab-row">
    <?php if(Yii::$app->user->can('contractsView')) ?>
        <?php foreach($documents as $doc) {?>
            <div class="border-bottom-dotted-1">
                <div>
                    <b><?= Yii::t('app', 'User:')?></b><?= $doc->user->username?>
                </div>
                <div>
                    <b><?= Yii::t('app', 'Category:')?></b><?= $documentCategories[$doc->category]?>
                </div>
                <div>
                    <b><?= Yii::t('app', 'Document:')?></b><?= Html::a($doc->name, Url::to(['documents/download', 'id' => $doc->id]), ['target' => '_blank', 'data-pjax' => '0'])?>
                </div>
            </div>
        <?php }?>
    <?php endif;?>
</div>