<?php

use yii\helpers\{Html, Url};
use yii\grid\GridView;
use yii\widgets\{ActiveForm, Pjax};
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', ucfirst(\app\models\Company::getCompanyName()) . ' user accounts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-content">
<?php Pjax::begin(['id' => 'result']); ?>

<?php echo Html::hiddenInput('userId', $model->id); ?>

<ul class="breadcrumb">
    <li><a href="/">Home</a></li>
    <li class="active">Users</li>
</ul>
<ul class="nav nav-tabs users-tabs">
    <li class="active"><a href="/web/users/user-settings">Manage Users</a></li>
    <?php if(Yii::$app->user->can('Owner') or Yii::$app->user->can('Admin')): ?> 
        <li class=""><a href="/web/users/user-settings/manage-role" >Manage Roles</a></li>
    <?php endif; ?>
    <?php if(Yii::$app->user->can('Owner') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Department Leader') or Yii::$app->user->can('Manager')): ?>
        <li class=""><a href="/web/users/user-settings/manage-group" >Manage Groups</a></li>
    <?php endif; ?>
</ul>
<div class="property-list">
    <div class="tab-content">
        <div class="top-contact-content users-top-content clearfix">
            <div class="tab-pane active" id="manage-users">
                <?= $this->render('_tabManageUsers', [
                    'model'            => $model,
                    'dataProvider'     => $dataProvider,
                    'searchModel'      => $searchModel,
                    'authItems'        => $authItems,
                    'propertyCategory' => $propertyCategory,
                    'disabled'         => $disabled, 
                    'modelRoleForm'    => $modelRoleForm,
                    'groupsItems'      => $groupsItems,
                    'formGroup'        => $formGroup,
                    'modelImg'         => $modelImg,
                    'modelImgPrew'     => $modelImgPrew,
                    'userStatuses'     => $userStatuses
                ])?>
            </div>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>
</div>

<?php $this->registerJsFile('@web/js/userSettings/userSettings.js', ['depends' => 'yii\web\JqueryAsset']);?>

