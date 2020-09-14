<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccountsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Accounts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounts-index">

<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Accounts'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'user_name',
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
            'avatar',
            'bio',
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
