<div class="margin-bottom-15 margin-top-15">
    <?= Yii::t('app', 'Send links to the listing preview page')?>
</div>
<div class="row margin-bottom-15">
    <div class="col-md-4">
        <input type='checkbox' class="height-auto" id="matching-send-links-by-email" checked><?= Yii::t('app', 'By email')?>
    </div>
    <div class="col-md-8">
        <input type="text" value="<?= $model->email?>" class="form-control" id="matching-receiver-email">
    </div>
</div>

<div class="row margin-bottom-15">
    <div class="col-md-4">
        <input type='checkbox' class="height-auto" id="matching-send-links-by-sms" disabled><?= Yii::t('app', 'By SMS')?>
    </div>
    <div class="col-md-8">
        <input type="text" value="<?= $model->mobile_number ?>" class="form-control" disabled>
    </div>
</div>


<div>
    <input type="button" class="btn btn-success" value="<?= Yii::t('app', 'Send')?>" id="btn-send-matching-preview-links">
</div>