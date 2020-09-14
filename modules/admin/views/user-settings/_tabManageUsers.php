<?php

use yii\helpers\{Html, Url};
use yii\grid\GridView;
use yii\widgets\{ActiveForm, Pjax};
?>
<div class="top-contact-content users-top-content clearfix">
    <!--  Top Contact Block -->
    <div class="head-contact-property container-fluid">
        <?= $this->render('_topButton', [
            'model' => $model
        ])?>
    </div>
    <div class="container-fluid content-contact-property">
        <?php $form = ActiveForm::begin([
            'options' => [
                'enctype' => 'multipart/form-data',
                'class' => 'form-horizontal',
                'data-pjax' => '1',
                'id' => 'user-form'
            ]
        ])?>
        <div class="container-fluid contact-left-block col-md-4"><!-- Left Contact part-->
            <?= $this->render('_userDetails', [
                'model'         => $model,
                'form'          => $form,
                'authItems'     => $authItems,
                'disabled'      => $disabled,
                'modelRoleForm' => $modelRoleForm,
                'groupsItems'   => $groupsItems,
                'formGroup'     => $formGroup,
                'userStatuses'  => $userStatuses
            ])?>
        </div><!-- /Left Contact part-->
        <div class="container-fluid contact-middle-block col-md-4"><!-- Middle Contact part-->
            <?= $this->render('_additionalData', [
                'model'            => $model,
                'form'             => $form,
                'propertyCategory' => $propertyCategory,
                'disabled'         => $disabled
            ])?>
        </div><!-- /Middle Contact part-->
        <div class="container-fluid col-md-4 notes-block"><!-- Right part-->
            <?= $this->render('_tabsData', [
                'model'    => $model,
                'form'     => $form,
                'disabled' => $disabled,
                'modelImg'     => $modelImg,
                'modelImgPrew' => $modelImgPrew
            ])?>
        </div><!-- /Right prt-->
        <?php ActiveForm::end();?>
    </div>
</div>
<div class="container-fluid  bottom-rentals-content clearfix"><!--    Bottom Rentals Block      -->
    <div id="listings-tab">

        <div class="tab-content ">
            <div class="tab-pane active" id="current-listings">
          
                <!-- BIG listings Table-->
                <div style="overflow-x: auto; padding-right: 0; padding-left: 0;" class=" container-fluid clearfix">
                    <?= $this->render('_grid', [
                        'dataProvider' => $dataProvider,
                        'searchModel'  => $searchModel,
                        'topModel'     => $model,
                        'userStatuses' => $userStatuses,
                        'authItems'    => $authItems
                    ])?>
                </div>
           

                <!-- /BIG listings Table-->
            </div>
            <!--
            <div class="tab-pane" id="archived-listings">
                <p style="font-size: 56px; color: red;">Put The Archived Listings Table HERE</p>
            </div>
            <div class="tab-pane" id="pending-listings">
                <p style="font-size: 56px; color: red;">Put The Pending Listings Table HERE</p>
            </div>
            -->
        </div>
    </div>

</div><!--    /Bottom Rentals Block      --> 