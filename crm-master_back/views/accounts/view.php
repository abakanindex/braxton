<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Accounts */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounts-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <label class="control-label">avatar</label>
    <br/>
    <?php echo  Html::img('@web/images/img/' . $model->avatar, ['class' => 'avatar']); ?>
    <br/>
    <br/>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_name',
            'password',
            'user_role',
            'first_name',
            'last_name',
            'email:email',
            'mobile_number',
            'job_title',
            'department',
            'office_tel',
            'hobbies',
            'mobile',
            'phone',
            'rera_brn',
            'rental_comm',
            'sales_comm',
            'languages_spoken',
            'status',
            'bio:html',
            'edit_other_managers',
            'permissions',
            'excel_export',
            'sms_allowed',
            'listing_detail',
            'can_assign_leads',
            'show_owner',
            'delete_data',
            'edit_published_listings',
            'access_time',
            'hr_manager',
            'agent_type',
            'contact_lookup_broad_search',
            'user_listing_sharing',
            'user_screen_settings',
            'enabled',
            'imap',
            'import_email_leads_email:email',
            'import_email_leads_password:email',
            'import_email_leads_port:email',
            'categories',
            'locations',
        ],
    ]) ?>

</div>
