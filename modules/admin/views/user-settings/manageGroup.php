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


<ul class="breadcrumb">
    <li><a href="/">Home</a></li>
    <li class="active">Users</li>
</ul>
<ul class="nav nav-tabs users-tabs">
    <li class=""><a href="/web/users/user-settings" >Manage Users</a></li>
    <?php if(Yii::$app->user->can('Owner') or Yii::$app->user->can('Admin')): ?> 
        <li class=""><a href="/web/users/user-settings/manage-role">Manage Roles</a></li>
    <?php endif; ?>
    <?php if(Yii::$app->user->can('Owner') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Department Leader') or Yii::$app->user->can('Manager')): ?>
        <li class="active"><a href="/web/users/user-settings/manage-group" >Manage Groups</a></li>
    <?php endif; ?>
</ul>
<div class="property-list">
<div class="tab-content ">

    <?php if(Yii::$app->user->can('Owner') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Department Leader') or Yii::$app->user->can('Manager')): ?>
        <div class="tab-pane active" id="manage-groups">
            <div class="top-contact-content users-top-content clearfix">
                <?= $this->render('_tabManageGroups', [
                    'model'                 => $model,
                    'dataProvider'          => $dataProvider,
                    'searchModel'           => $searchModel,
                    'authItems'             => $authItems,
                    'propertyCategory'      => $propertyCategory,
                    'disabled'              => $disabledGroup, 
                    'manageGroupProvider'   => $manageGroupProvider,
                    'modelManageGroup'      => $modelManageGroup,
                    'modelManageGroupChild' => $modelManageGroupChild,
                ])?>
            </div>
        </div>
    <?php endif; ?>

</div>
</div>
</div>

<?php $this->registerJsFile('@web/js/userSettings/userSettings.js', ['depends' => 'yii\web\JqueryAsset']);?>

