<?php
use yii\helpers\{Html, Url};

/**
 * @var $topModel
 */
?>

<ul class="list-inline container-fluid">
    <?php
    if (
        Yii::$app->controller->action->id === 'create' or
        Yii::$app->controller->action->id === 'update'
    ):
        ?>
        <li class="">
            <?= Html::submitButton(
                '<i class="fa fa-check-circle"></i>' . Yii::t('app', ' Save'),
                [
                    'class'     => 'btn red-button',
                    'id'        => 'save-edit-element',
                    'form'      => 'dealsSave',
                    'data-pjax' => '1',
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
    <?php elseif(Yii::$app->controller->action->id === 'view-archive'):?>
        <li class="">
            <?= Html::a(
                '<i class="fa fa-plus-circle"></i>' . Yii::t('app', 'New Deal'),
                '/web/deals/deals-international/create',
                [
                    'id'    => 'add-new-element',
                    'class' => 'btn green-button',
                ]
            )
            ?>
        </li>
    <?php elseif(empty($existRecord)): ?>
        <li class="">
            <?= Html::a(
                '<i class="fa fa-plus-circle"></i>' . Yii::t('app', 'New Deal'),
                '/web/deals/deals-international/create',
                [
                    'id'    => 'add-new-element',
                    'class' => 'btn green-button',
                ]
            )
            ?>
        </li>
    <?php else:?>
        <li class="">
            <?= Html::a(
                '<i class="fa fa-plus-circle"></i>' . Yii::t('app', 'New Deal'),
                '/web/deals/deals-international/create',
                [
                    'id'    => 'add-new-element',
                    'class' => 'btn green-button',
                ]
            )
            ?>
        </li>
        <li class="">
            <?= Html::a(
                '<i class="fa fa-pencil-square-o"></i>' . Yii::t('app', 'Edit Deal'),
                ['update', 'id' => $topModel->id],
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
                ['delete', 'id' => $topModel->id],
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
</ul>