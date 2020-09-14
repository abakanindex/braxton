<?php
use app\modules\lead\models\LeadSocialMediaContact;
use yii\helpers\Html;

if ($formLeadSocialMediaContact) {
    $type = $formLeadSocialMediaContact['type'];
    $link = $formLeadSocialMediaContact['link'];
}
?>

<div class="row social-media-contact-item" style="margin-bottom:10px">
    <div class="col-sm-3">
        <label for="social-media-contact" class="sr-only"></label>
        <?= Html::dropDownList('social-media-contact-type', $type, LeadSocialMediaContact::getTypes(), ['class' => 'form-control social-media-contact-type']); ?>
    </div>
    <div class="col-sm-7">
        <?= Html::textInput('social-media-contact-link', $link, ['class' => 'form-control social-media-contact-link','placeholder'=>Yii::t('app', 'Enter link...')]); ?>
    </div>
    <div class="col-sm-2">
        <?= Html::a('<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>', '#', ['class' => "btn-danger remove-social-media-contact btn"]) ?>
    </div>
</div>
