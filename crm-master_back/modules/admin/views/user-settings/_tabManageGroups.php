<?php

use yii\helpers\{Html, Url};
use yii\grid\GridView;
use yii\widgets\{ActiveForm, Pjax};
?>
<div class="top-contact-content users-top-content clearfix"><!--  Top Contact Block -->
    <div class="head-contact-property container-fluid">
        <?= $this->render('_topButtonGroup', [
            'modelManageGroup' => $modelManageGroup
        ])?>
    </div>

    <div class="container-fluid content-contact-property">
    <?php 
        $form = ActiveForm::begin([
            'method'    => 'get',
            'options' => [
                'enctype'   => 'multipart/form-data',
                'class'     => 'form-horizontal',
                'id'        => 'group-form',
            ]
        ]); 
    ?>

    <div class="container-fluid contact-left-block col-md-4"><!-- Left Contact part-->

        <div class="contact-bottom-column-height">

            <div class="contact-small-block role-left-block"><!--User Details-->

                <div class="property-list">
                    <h4>Group</h4>
                    <div class="form-group">
                        <label for="inputGroupName" class="col-sm-6 control-label">Group Name</label>
                        <div class="col-sm-6">
                        <?= $form->field($modelManageGroup, 'group_name')->textInput(['disabled' => $disabled, 'class' => 'form-control'])->label(false); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputRoleDescription" class="col-sm-6 control-label">Description</label>
                        <div class="col-sm-6">
                            <?= $form->field($modelManageGroup, 'description')->textArea(['disabled' =>  $disabled, 'class' => 'form-control'])->label(false); ?>
                        </div>
                    </div>
                </div>
            </div><!-- /User Details-->

        </div>

    </div><!-- /Left Contact part-->
    <div class="container-fluid contact-left-block col-md-6"><!-- Left Contact part-->
        <div style="overflow-x: auto; padding-right: 0; padding-left: 0;" class=" container-fluid clearfix">
            <?= $this->render('_groupGrid', [
                'dataProvider'          => $dataProvider,
                'modelManageGroup'      => $modelManageGroup,
                'searchModel'           => $searchModel,
                'modelManageGroupChild' => $modelManageGroupChild,
                'disabled'              => $disabled

            ])?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- /Top Contact Block -->


<div class="container-fluid  bottom-rentals-content clearfix"><!--    Bottom Rentals Block      -->
    <div >

        <div class="tab-content ">
            <div class="tab-pane active" >

                <div style="overflow-x: auto; padding-right: 0; padding-left: 0;" class=" container-fluid clearfix">
                    <?= GridView::widget([
                        'dataProvider' => $manageGroupProvider,
                        'layout' => "{items}\n{pager}",
                        'tableOptions' => [
                            'class' => 'table table-bordered listings_row',
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'class'  => 'yii\grid\ActionColumn',
                                'buttons'=>[
                                    'view'=>function ($url, $manageGroupProvider) use ($urlView, $modelManageGroup) {
                                        $url = Yii::$app->getUrlManager()->createUrl([
                                            '/users/user-settings/view-group',
                                            'name'   => $manageGroupProvider->group_name,
                                        ]);
                                        return \yii\helpers\Html::a(
                                            ($modelManageGroup->group_name == $manageGroupProvider->group_name) ? '<i class="fa fa-eye active"></i>' : '<i class="fa fa-eye"></i>',
                                            $url,
                                            [
                                                'title'     => Yii::t('app', 'View'),
                                                'data-pjax' => '1',
                                                'pjax'      => '#result',
                                                'class'     => 'view-contact'
                                            ]
                                        );
                                    }
                                ],
                                'template'=>'{view}',
                            ],
                            'group_name',
                            'description',
                        ],
                    ]); 
                    ?>
                </div>
                <!-- /BIG listings Table-->
            </div>

        </div>
    </div>

</div><!--    /Bottom Rentals Block      -->