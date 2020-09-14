<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AccountsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accounts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_name') ?>

    <?= $form->field($model, 'password') ?>

    <?= $form->field($model, 'user_role') ?>

    <?= $form->field($model, 'first_name') ?>

    <?php // echo $form->field($model, 'last_name') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'mobile_number') ?>

    <?php // echo $form->field($model, 'job_title') ?>

    <?php // echo $form->field($model, 'department') ?>

    <?php // echo $form->field($model, 'office_tel') ?>

    <?php // echo $form->field($model, 'hobbies') ?>

    <?php // echo $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'rera_brn') ?>

    <?php // echo $form->field($model, 'rental_comm') ?>

    <?php // echo $form->field($model, 'sales_comm') ?>

    <?php // echo $form->field($model, 'languages_spoken') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'avatar') ?>

    <?php // echo $form->field($model, 'bio') ?>

    <?php // echo $form->field($model, 'edit_other_managers') ?>

    <?php // echo $form->field($model, 'permissions') ?>

    <?php // echo $form->field($model, 'excel_export') ?>

    <?php // echo $form->field($model, 'sms_allowed') ?>

    <?php // echo $form->field($model, 'listing_detail') ?>

    <?php // echo $form->field($model, 'can_assign_leads') ?>

    <?php // echo $form->field($model, 'show_owner') ?>

    <?php // echo $form->field($model, 'delete_data') ?>

    <?php // echo $form->field($model, 'edit_published_listings') ?>

    <?php // echo $form->field($model, 'access_time') ?>

    <?php // echo $form->field($model, 'hr_manager') ?>

    <?php // echo $form->field($model, 'agent_type') ?>

    <?php // echo $form->field($model, 'contact_lookup_broad_search') ?>

    <?php // echo $form->field($model, 'user_listing_sharing') ?>

    <?php // echo $form->field($model, 'user_screen_settings') ?>

    <?php // echo $form->field($model, 'enabled') ?>

    <?php // echo $form->field($model, 'imap') ?>

    <?php // echo $form->field($model, 'import_email_leads_email') ?>

    <?php // echo $form->field($model, 'import_email_leads_password') ?>

    <?php // echo $form->field($model, 'import_email_leads_port') ?>

    <?php // echo $form->field($model, 'categories') ?>

    <?php // echo $form->field($model, 'locations') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
