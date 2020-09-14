<?php
use yii\helpers\{Html, Url};
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
                'form'      => 'saleSave',
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
        <?php if(Yii::$app->user->can('saleCreate') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>
            <li class="">
                <?= Html::a(
                        '<i class="fa fa-plus-circle"></i>New Listing',
                        Url::toRoute(['/sales/sale/create']),
                        [
                            'id'    => 'add-new-element',
                            'class' => 'btn green-button',
                        ]
                    ) 
                ?>
            </li>
        <?php endif; ?>
    <?php elseif(empty($existRecord)): ?>
        <?php if(Yii::$app->user->can('saleCreate') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>
            <li class="">
                <?= Html::a(
                    '<i class="fa fa-plus-circle"></i>New Listing',
                    Url::toRoute(['/sales/sale/create']),
                    [
                        'id'    => 'add-new-element',
                        'class' => 'btn green-button',
                    ]
                )
                ?>
            </li>
        <?php endif; ?>       
    <?php else:?>
        <?php if(Yii::$app->user->can('saleCreate') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>
            <li class="">
                <?= Html::a(
                    '<i class="fa fa-plus-circle"></i>New Listing',
                    Url::toRoute(['/sales/sale/create']),
                    [
                        'id'    => 'add-new-element',
                        'class' => 'btn green-button',
                    ]
                )
                ?>
            </li>
        <?php endif; ?>
        <?php if(Yii::$app->user->can('saleUpdate') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>
            <li class="">
                <?= Html::a(
                    '<i class="fa fa-pencil-square-o"></i>Edit Listing',
                    Url::toRoute(['/sales/sale/update', 'id' => $topModel->id]),
                    [
                        'id'        => 'edit-element',
                        'class'     => 'btn red-button',
                        'data-pjax' => '1',
                    ]
                )
                ?>
            </li>
        <?php endif; ?>
        <?php if(Yii::$app->user->can('saleDelete') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>
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
    <?php endif;?>
    <li class="pull-right">
        <?php
        if(Yii::$app->controller->action->id === 'create' || !$topModel->id):
            $optionsLink = [
                'data-toggle' => 'modal',
                'data-target' => '#modal-create-first',
                'class' => 'btn gray-button show-modal-create-first'
            ];
        else:
            $optionsLink = [
                'data-toggle' => 'modal',
                'data-target' => '#modal-matching-leads',
                'class' => 'btn green-button'
            ];
        endif;
        ?>

        <?=Html::a(
            '<i class="fa fa-dot-circle-o"></i>' . Yii::t('app', 'Match Leads'),
            '#',
            $optionsLink
        )?>
    </li>
    <li class="pull-right">
        <?php if($topModel->id) {?>
            <?=Html::a(
                '<i class="fa fa-eye"></i>' . Yii::t('app', 'Preview Listing'),
                Yii::$app->getUrlManager()->createUrl(['/preview/' . $topModel->ref]),
                ['class' => 'btn red-button', 'target' => '_blank', 'data-pjax' => '0']
            )?>
        <?php } else {?>
            <button class="btn gray-button show-modal-create-first"><?=Yii::t('app', 'Preview Listing')?></button>
        <?php }?>
    </li>
</ul>