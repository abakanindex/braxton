<?php use yii\helpers\Html; ?>

<ul class="list-inline container-fluid">
    <?php 
        if (
            Yii::$app->controller->action->id === 'create' or 
            Yii::$app->controller->action->id === 'update'
        ): 
    ?>
    <li class="">
        <?= Html::button(
            '<i class="fa fa-check-circle"></i>' . Yii::t('app', ' Save'),
            [
                'class'     => 'btn red-button',
                'id'        => 'save-edit-element',
                'form'      => 'lead-form',
                'data-pjax' => '0',
            ]
        ) ?>
    </li>
    <li class="">
        <?= Html::a(
                '<i class="fa fa-times-circle"></i>'  . Yii::t('app', ' Cancel'),
                Yii::$app->request->referrer, 
                [
                    'id'    => 'cancel-edit-element',
                    'class' => 'btn gray-button',
                ]
            ) 
        ?>
    </li>
    <?php elseif(Yii::$app->controller->action->id === 'view-archive'): ?>
        <?php if(Yii::$app->user->can('leadsСreate') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>
            <li class="">
                <?= Html::a(
                        '<i class="fa fa-plus-circle"></i>New Lead',
                        '/web/leads/create', 
                        [
                            'id'    => 'add-new-element',
                            'class' => 'btn green-button',
                        ]
                    ) 
                ?>
            </li>
        <?php endif; ?>
        <?php elseif(empty($existRecord)): ?>
            <?php if(Yii::$app->user->can('leadsСreate') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>
                <li class="">
                    <?= Html::a(
                        '<i class="fa fa-plus-circle"></i>New Lead',
                        '/web/leads/create',
                        [
                            'id'    => 'add-new-element',
                            'class' => 'btn green-button',
                        ]
                    )
                    ?>
                </li> 
            <?php endif; ?>      
        <?php else:?>
        <?php if(Yii::$app->user->can('leadsСreate') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>
            <li class="">
                <?= Html::a(
                    '<i class="fa fa-plus-circle"></i>New Lead',
                    '/web/leads/create',
                    [
                        'id'    => 'add-new-element',
                        'class' => 'btn green-button',
                    ]
                )
                ?>
            </li>
        <?php endif; ?>
        <?php if(Yii::$app->user->can('leadsUpdate') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>
            <li class="">
                <?= Html::a(
                    '<i class="fa fa-pencil-square-o"></i>Edit Lead',
                    '/web/leads/update/' . $model->id,
                    [
                        'id'        => 'edit-element',
                        'class'     => 'btn red-button',
                        'data-pjax' => '1',
                    ]
                )
                ?>
            </li>
        <?php endif;?>
        <?php if(Yii::$app->user->can('leadsDelete') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>
            <li class="">
                <?= Html::a(
                    '<i class="glyphicon glyphicon-trash"></i>'  . Yii::t('app', ' Delete'),
                    ['delete', 'id' => $model->id],
                    [
                        'id'    => 'cancel-edit-element',
                        'class' => 'btn gray-button',
                        'data'  => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method'  => 'post',
                        ],
                    ]
                )
                ?>
            </li>
        <?php endif;?>
    <?php endif;?>
    <!-- <li class="pull-right">
        <a class="btn green-button" type="button" href="#">
            <i class="fa fa-dot-circle-o"></i>Match Leads
        </a>
    </li>
    <li class="pull-right">
        <a class="btn red-button" type="button" href="#">
            <i class="fa fa-eye"></i>Preview Listing
        </a>
    </li> -->
</ul>