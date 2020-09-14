<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use rmrevin\yii\fontawesome\FA;
use app\models\TaskManager;
use yii\widgets\Pjax;

/**
 * @var array $tasks
 * @var int $taskPages
 */
?>
<?php Pjax::begin(['id' => 'resultTaskManager']); ?>
<div class="box box-primary">
    <div class="box-header">
        <i class="fa fa-user-o"></i>
        <h3 class="box-title"><?php echo Yii::t('app', 'Task Manager')?></h3>
        <div class="box-tools pull-right">
            <?php
            echo LinkPager::widget([
                'pagination' => $taskPages,
                'options' => [
                    'class' => 'pagination pagination-sm inline',
                ],
            ]);
            ?>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <?php if (!empty($tasks)) : ?>
        <ul class="todo-list">
            <?php foreach ($tasks as $task) : ?>
                <li>
                    <!-- drag handle -->
                    <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                    </span>
                    <span class="text">
                        <?= Html::a($task->title,
                            Url::to(['/task-manager/view', 'id' => $task->id]),
                            ['target' => '_blank', 'data-pjax' => '0'])
                        ?>
                    </span>
                    <!-- Emphasis label -->
                    <small class="label label-<?php
                    switch ($task->priority) {
                        case TaskManager::PRIORITY_HIGH:
                            echo 'danger';
                            break;
                        case TaskManager::PRIORITY_MEDIUM:
                            echo 'warning';
                            break;
                        case TaskManager::PRIORITY_LOW:
                            echo 'success';
                            break;
                        default:
                            echo 'info';
                    }
                    ?>">
                        <?php
                        if ($task->deadline) {
                            echo '<i class="fa fa-clock-o"></i>&nbsp;', date('F j, Y, H:i', strtotime($task->deadline));
                        } else {
                            echo Yii::t('app', 'No date settled');
                        }
                        ?>
                    </small>
                    <!-- General tools such as edit or delete-->
                    <div class="tools">
                        <i class="fa fa-edit task-edit" data-href="<?= Url::to(['/task-manager/update', 'id' => $task->id]) ?>"></i>
                        <i class="fa fa-trash-o task-delete"
                           data-href="<?= Url::to(['/task-manager/delete', 'id' => $task->id]) ?>"
                           data-id="<?= $task->id ?>"
                           data-confirm="Are you sure you want to delete this item?"
                        >
                        </i>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php else : ?>
            <?php echo Yii::t('app', 'No Data') ?>
        <?php endif; ?>
    </div>
    <div class="box-footer clearfix no-border">
        <?php echo Html::a(
            FA::icon('plus') . ' ' . Yii::t('app', 'Add item'),
            Url::to(['/task-manager/create']),
            [
                'id'    => 'add-new-element',
                'class' => 'btn btn-default pull-right',
            ]
        )
        ?>
    </div>
</div>
<?php Pjax::end(); ?>
<?php
$confirmText = Yii::t('app', 'Are you sure you want to delete this item?');
$script = <<<JS
$('.task-edit').on('click', function (e) {
    "use strict";
    var href = $(this).attr('data-href');
    $(location).attr('href', href);
});

$('.task-delete').on('click', function (e) {
    "use strict";
    if (confirm('$confirmText')) { 
        var that = $(this);
        $.ajax({
            type: 'post',
            url: that.attr('data-href'),
            data: that.attr('data-id'),
            success: function(response) {
                location.reload();
            }
        })
    }
    
    return false;
});

JS;
$this->registerJs($script, yii\web\View::POS_READY);
