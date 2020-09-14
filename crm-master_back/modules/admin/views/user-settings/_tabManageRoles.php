<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\{Url, ArrayHelper};


?>

<div class="top-contact-content users-top-content clearfix"><!--  Top Contact Block -->
<div class="head-contact-property container-fluid">

        <?= $this->render('_topButtonRole', [
            'model'     => $model,
            'modelRole' => $topModel
        ])?>
</div>

<div class="container-fluid content-contact-property">
    <?php 
        $form = ActiveForm::begin([
            'id'    => 'role-form',
            'class' => 'form-horizontal'
        ]); 
    ?>
    <div class="container-fluid contact-left-block col-md-4"><!-- Left Contact part-->

        <div class="contact-bottom-column-height">

            <div class="contact-small-block role-left-block"><!--User Details-->

                <div class="property-list">
                    <h4>Description</h4>
                    <div class="form-group">
                        <label for="inputRoleName" class="col-sm-6 control-label">Role Name</label>
                        <div class="col-sm-6">
                            <?= $form->field($modelRoleForm, 'name')->textInput(['disabled' => $disabled, 'class' => 'form-control'])->label(false); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputRoleDescription" class="col-sm-6 control-label">Description</label>
                        <div class="col-sm-6">
                            <?= $form->field($modelRoleForm, 'description')->textArea(['disabled' =>  $disabled, 'class' => 'form-control'])->label(false); ?>
                        </div>
                    </div>
                </div>
            </div><!-- /User Details-->

        </div>

    </div><!-- /Left Contact part-->
    <div class="container-fluid contact-middle-block  role-left-block col-md-4"><!-- Middle Contact part-->

        <div class="content-left-block"><!--Property Address & Detalis-->

            <div class="property-list role-middle-block" style='width:103%;'>
                <label for="inputRoleGroups" class="col-sm-6 control-label">Permission</label>
                <br/>
                <br/>
                <div>
                    Sms allowed
                    <?= $form->field($modelRoleForm, 'smsallowed', ['template' => "{input}\n{label}",])->checkbox(['value' => 'smsAllowed', 'disabled' =>  $disabled], false)->label('') ?>
                </div>
                <div>
                    Excel Export
                    <?= $form->field($modelRoleForm, 'excelexport', ['template' => "{input}\n{label}",])->checkbox(['value' => 'excelExport', 'disabled' =>  $disabled], false)->label('') ?>
                </div>
                <div>
                    Can assign Lead
                    <?= $form->field($modelRoleForm, 'canassignlead', ['template' => "{input}\n{label}",])->checkbox(['value' => 'canAssignLead', 'disabled' =>  $disabled], false)->label('') ?>
                </div>
                <table>
                    <tr>
                        <th>#</th>
                        <th>create &nbsp;</th>
                        <th>delete &nbsp;</th>
                        <th>update &nbsp;</th>
                        <th>view   &nbsp;</th>
                    </tr>
                    <tr>
                        <td>Leads</td>
                        
                        <td><?= $form->field($modelRoleForm, 'leadscreate', ['template' => "{input}\n{label}",])->checkbox(['value' => 'leadsСreate', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'leadsdelete', ['template' => "{input}\n{label}",])->checkbox(['value' => 'leadsDelete', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'leadsupdate', ['template' => "{input}\n{label}",])->checkbox(['value' => 'leadsUpdate', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'leadsview', ['template' => "{input}\n{label}",])->checkbox(['value' => 'leadsView', 'disabled' =>  $disabled], false)->label('') ?></td>
                    </tr>
                    <tr>
                        <td>Contacts</td>
                        <td><?= $form->field($modelRoleForm, 'contactscreate', ['template' => "{input}\n{label}",])->checkbox(['value' => 'contactsCreate', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'contactsdelete', ['template' => "{input}\n{label}",])->checkbox(['value' => 'contactsDelete', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'contactsupdate', ['template' => "{input}\n{label}",])->checkbox(['value' => 'contactsUpdate', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'contactsview', ['template' => "{input}\n{label}",])->checkbox(['value' => 'contactsView', 'disabled' =>  $disabled], false)->label('') ?></td>
                    </tr>
                    <tr>
                        <td>Sale</td>
                        <td><?= $form->field($modelRoleForm, 'salecreate', ['template' => "{input}\n{label}",])->checkbox(['value' => 'saleCreate', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'saledelete', ['template' => "{input}\n{label}",])->checkbox(['value' => 'saleDelete', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'saleupdate', ['template' => "{input}\n{label}",])->checkbox(['value' => 'saleUpdate', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'saleview', ['template' => "{input}\n{label}",])->checkbox(['value' => 'saleView', 'disabled' =>  $disabled], false)->label('') ?></td>
                    </tr>
                    <tr>
                        <td>Rentals</td>
                        <td><?= $form->field($modelRoleForm, 'rentalscreate', ['template' => "{input}\n{label}",])->checkbox(['value' => 'rentalsCreate', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'rentalsdelete', ['template' => "{input}\n{label}",])->checkbox(['value' => 'rentalsDelete', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'rentalsupdate', ['template' => "{input}\n{label}",])->checkbox(['value' => 'rentalsUpdate', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'rentalsview', ['template' => "{input}\n{label}",])->checkbox(['value' => 'rentalsView', 'disabled' =>  $disabled], false)->label('') ?></td>
                    </tr>
                    <tr>
                        <td>Contracts</td>
                        <td><?= $form->field($modelRoleForm, 'contractscreate', ['template' => "{input}\n{label}",])->checkbox(['value' => 'contractsCreate', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'contractsdelete', ['template' => "{input}\n{label}",])->checkbox(['value' => 'contractsDelete', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'contractsupdate', ['template' => "{input}\n{label}",])->checkbox(['value' => 'contractsUpdate', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'contractsview', ['template' => "{input}\n{label}",])->checkbox(['value' => 'contractsView', 'disabled' =>  $disabled], false)->label('') ?></td>
                    </tr>
                    <tr>
                        <td>Deals</td>
                        <td><?= $form->field($modelRoleForm, 'dealscreate', ['template' => "{input}\n{label}",])->checkbox(['value' => 'dealsCreate', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'dealsdelete', ['template' => "{input}\n{label}",])->checkbox(['value' => 'dealsDelete', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'dealsupdate', ['template' => "{input}\n{label}",])->checkbox(['value' => 'dealsUpdate', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'dealsview', ['template' => "{input}\n{label}",])->checkbox(['value' => 'dealsView', 'disabled' =>  $disabled], false)->label('') ?></td>
                    </tr>
                    <tr>
                        <td>Calendar</td>
                        <td><?= $form->field($modelRoleForm, 'calendarview', ['template' => "{input}\n{label}",])->checkbox(['value' => 'calendarView', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <!-- <tr>
                        <td>Commercial Sales</td>
                        <td><?= $form->field($modelRoleForm, 'commercialsalescreate', ['template' => "{input}\n{label}",])->checkbox(['value' => 'commercialsalesCreate', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'commercialsalesdelete', ['template' => "{input}\n{label}",])->checkbox(['value' => 'commercialsalesDelete', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'commercialsalesupdate', ['template' => "{input}\n{label}",])->checkbox(['value' => 'commercialsalesUpdate', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'commercialsalesview', ['template' => "{input}\n{label}",])->checkbox(['value' => 'commercialsalesView', 'disabled' =>  $disabled], false)->label('') ?></td>
                    </tr>
                    <tr>
                        <td>Commercial Rentals</td>
                        <td><?= $form->field($modelRoleForm, 'commercialrentalscreate', ['template' => "{input}\n{label}",])->checkbox(['value' => 'commercialrentalsCreate', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'commercialrentalsdelete', ['template' => "{input}\n{label}",])->checkbox(['value' => 'commercialrentalsDelete', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'commercialrentalsupdate', ['template' => "{input}\n{label}",])->checkbox(['value' => 'commercialrentalsUpdate', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'commercialrentalsview', ['template' => "{input}\n{label}",])->checkbox(['value' => 'commercialrentalsView', 'disabled' =>  $disabled], false)->label('') ?></td>
                    </tr> -->
                    <tr>
                        <td>Reports</td>
                        <td><?= $form->field($modelRoleForm, 'reportscreate', ['template' => "{input}\n{label}",])->checkbox(['value' => 'reportsCreate', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td></td>
                        <td></td>
                        <td><?= $form->field($modelRoleForm, 'reportsview', ['template' => "{input}\n{label}",])->checkbox(['value' => 'reportsView', 'disabled' =>  $disabled], false)->label('') ?></td>
                    </tr>
                    <tr>
                        <td>Viewings</td>
                        <td><?= $form->field($modelRoleForm, 'viewingcreate', ['template' => "{input}\n{label}",])->checkbox(['value' => 'viewingCreate', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'viewingdelete', ['template' => "{input}\n{label}",])->checkbox(['value' => 'viewingDelete', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'viewingupdate', ['template' => "{input}\n{label}",])->checkbox(['value' => 'viewingUpdate', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'viewingview', ['template' => "{input}\n{label}",])->checkbox(['value' => 'viewingView', 'disabled' =>  $disabled], false)->label('') ?></td>
                    </tr>
                    <tr>
                        <td>Task manager</td>
                        <td><?= $form->field($modelRoleForm, 'taskmanagercreate', ['template' => "{input}\n{label}",])->checkbox(['value' => 'taskmanagerCreate', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'taskmanagerdelete', ['template' => "{input}\n{label}",])->checkbox(['value' => 'taskmanagerDelete', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'taskmanagerupdate', ['template' => "{input}\n{label}",])->checkbox(['value' => 'taskmanagerUpdate', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td><?= $form->field($modelRoleForm, 'taskmanagerview', ['template' => "{input}\n{label}",])->checkbox(['value' => 'taskmanagerView', 'disabled' =>  $disabled], false)->label('') ?></td>
                    </tr>
                    <tr>
                        <td>My Reminders</td>
                        <td><?= $form->field($modelRoleForm, 'myremindersview', ['template' => "{input}\n{label}",])->checkbox(['value' => 'myremindersView', 'disabled' =>  $disabled], false)->label('') ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>                  
            </div>
        </div><!-- /Property Address & Detalis-->

    </div><!-- /Middle Contact part-->


<div class="container-fluid col-md-4 notes-block role-left-block"><!-- Right part-->
    <div class="property-list role-middle-block">

    </div>

</div><!-- /Right part-->
<?php ActiveForm::end(); ?>
</div>

</div><!-- /Top Contact Block -->


<div class="container-fluid  bottom-rentals-content clearfix"><!--    Bottom Rentals Block      -->
    <div >

        <div class="tab-content ">
            <div class="tab-pane active" >

                <!-- BIG listings Table-->
                <div style="overflow-x: auto; padding-right: 0; padding-left: 0;" class=" container-fluid clearfix">
                    <?= GridView::widget([
                        'dataProvider' => $roleDdataProvider,
                        'layout' => "{items}\n{pager}",
                        'tableOptions' => [
                            'class' => 'table table-bordered listings_row',
                        ],
                        'columns' => [

                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'class'  => 'yii\grid\ActionColumn',
                                'buttons'=>[
                                    'view'=>function ($url, $modelRole) use ($urlView, $topModel) {
                                            $url = Yii::$app->getUrlManager()->createUrl([
                                                '/users/user-settings/view-role',
                                                'name'   => $modelRole->name,
                                            ]);
                                            return \yii\helpers\Html::a(
                                                ($topModel->name == $modelRole->name) ? '<i class="fa fa-eye active"></i>' : '<i class="fa fa-eye"></i>',
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
                            'name',
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