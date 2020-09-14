<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserProfile */

$this->title = $model->first_name . ' ' . $model->last_name . ' ' . Yii::t('app', ' Profile');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Profiles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-view">
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => Yii::$app->user->getId()],
            ['class' => 'btn btn-primary']) ?>
    </p>
    <label class="control-label">Watermark</label><br/>
    <img src="<?= '/web/images/img/' . $model->watermark ?>" style="width: 200px;
    border-radius: 111px;">     
    <br/>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'first_name',
            'last_name',
            'accost_id',
            'company_id',
            'rental_comm',
            'sales_comm',
            'rera_brn',
            'mobile_number',
            'job_title',
            'Department',
            'office_tel',
        ],
    ]) ?>

</div>
