<div class="margin-bottom-15 margin-top-15">
    <?= Yii::t('app', 'Send Pdf brochure')?>
</div>

<div class="margin-bottom-15">
    <input type="text" value="<?= $model->email?>" class="form-control" id="matching-brochure-receiver-email">
</div>

<div>
    <input type="button" class="btn btn-success" value="<?= Yii::t('app', 'Send')?>" id="btn-send-matching-brochure">
</div>