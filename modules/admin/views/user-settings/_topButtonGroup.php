<?php use yii\helpers\{Html, Url}; ?>

<ul class="list-inline container-fluid">
    <?php
    if (
        Yii::$app->controller->action->id === 'create-group' or
        Yii::$app->controller->action->id === 'update-group'
    ):
        ?>
        <li class="">
            <?= Html::submitButton(
                '<i class="fa fa-check-circle"></i>' . Yii::t('app', ' Save'),
                [
                    'class'     => 'btn red-button',
                    'id'        => 'save-edit-element',
                    'data-pjax' => '1',
                    'onclick'   => "document.getElementById('group-form').submit();"
                ]
            ) ?>
        </li>
        <li class="">
            <?= Html::a(
                '<i class="fa fa-times-circle"></i>'  . Yii::t('app', ' Cancel'),
                Yii::$app->request->referrer,
                [
                    'id'        => 'cancel-edit-element',
                    'class'     => 'btn gray-button',
                    'data-pjax' => '1'
                ]
            )
            ?>
        </li>
    <?php else:?>
        <li class="">
            <?= Html::a(
                '<i class="fa fa-plus-circle"></i>New Group',
                ['create-group'],
                [
                    'id'        => 'add-new-element',
                    'class'     => 'btn green-button',
                    'data-pjax' => '1'
                ]
            )
            ?>
        </li>
        <?php if($modelManageGroup->group_name):?>
            <li class="">
                <?= Html::a(
                    '<i class="fa fa-pencil-square-o"></i>Edit Group',
                    ['update-group', 'name' => $modelManageGroup->group_name],
                    [
                        'id'        => 'edit-element',
                        'class'     => 'btn red-button',
                        'data-pjax' => '1',
                    ]
                )
                ?>
            </li>
            <li class="">
                <?= Html::a(
                    '<i class="glyphicon glyphicon-trash"></i>'  . Yii::t('app', ' Delete'),
                    ['delete-group', 'name' => $modelManageGroup->group_name],
                    [
                        'class'     => 'btn gray-button',
                        'data-pjax' => '1',
                        'data'      => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method'  => 'post',
                        ],
                    ]
                )
                ?>
            </li>
        <?php endif;?>
    <?php endif;?>
</ul>