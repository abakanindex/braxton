<?php

use app\models\Reminder;
use app\widgets\ReminderWidget;
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model app\models\Contacts */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contacts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contacts-view">

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
        <?= ReminderWidget::widget(['keyId' => $model->id, 'keyType' => Reminder::KEY_TYPE_CONTACTS]) ?>
    </p>

    <label class="control-label">Avatar</label><br/>
    <img src="<?= '/web/images/img/' . $model->avatar ?>" style="width: 200px;
    border-radius: 111px;">     
    <br/>

    <label class="control-label">Assigned To</label>
    <br/>
    <?php 
        echo 'Name: '. $modelUser->username .'<br/>';
     ?>
    <br/>

    <?php

        $nationModel;
        $religionModel;
        $ContactSoursModel;
        $titleModel;

    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ref',
            [
                'label' => 'title',
                'value' => function () use ($titleModel) {
                    return $titleModel;
                },
            ],
            'first_name',
            'last_name',
            'gender',
            'date_of_birth',
            [
                'label' => 'nationalities',
                'value' => function () use ($nationModel) {
                    return $nationModel;
                },
            ],
            [
                'label' => 'religion',
                'value' => function () use ($religionModel) {
                    return $religionModel;
                },
            ],
            'languagesd',
            'hobbies',
            'mobile',
            'phone',
            'email:email',
            'address',
            'fb',
            'tw',
            'linkedin',
            'skype',
            'googlplus',
            'wechat',
            'in',
            [
                'label' => 'contact_source',
                'value' => function () use ($ContactSoursModel) {
                    return $ContactSoursModel;
                },
            ],
            'company_name',
            'designation',
            'contact_type',
            'created_by',
            'notes:html',
            'documents',
        ],
    ]) ?>
<script>
;
</script>
</div>
