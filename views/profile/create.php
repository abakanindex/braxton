<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UserProfile */

$this->title = Yii::t('app', Yii::$app->user->identity->username . ' Profile');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Profiles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
