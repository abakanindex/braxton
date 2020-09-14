<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use rmrevin\yii\fontawesome\FA;
use app\models\Reminder;
use yii\widgets\Pjax;

/**
 * @var array $reminders
 * @var int $reminderPages
 */
?>
<?php Pjax::begin(['id' => 'resultReminder']); ?>
<?php $reminderUrl = Url::to(['/reminder/index']); ?>
<div class="box box-info">
    <div class="box-header with-border">
        <i class="fa fa-bell"></i>
        <h3 class="box-title"><?php echo Yii::t('app', 'My Reminders') ?></h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i>
            </button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table class="table no-margin">
                <?php if (!empty($reminders)) : ?>
                <thead>
                <tr>
                    <th><?php echo Yii::t('app', 'Time') ?></th>
                    <th><?php echo Yii::t('app', 'Item') ?></th>
                    <th><?php echo Yii::t('app', 'Status') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($reminders as $reminder) : ?>
                    <tr>
                        <td>
                            <?php
                            $time = $reminder->remind_at_time ?? $reminder->created_at;
                            echo date('F j, Y, H:i', $time)
                            ?>
                        </td>
                        <td>
                            <a href="<?= $reminderUrl ?>">
                                <?php echo $reminder->key, '. ', $reminder->description ?>
                            </a>
                        </td>
                        <td>
                            <?php
                            switch ($reminder->status) {
                                case Reminder::STATUS_ACTIVE:
                                    echo '<span class="label label-success">'
                                        . Yii::t('app', 'Active')
                                        . '</span>';
                                    break;
                                case Reminder::STATUS_NOT_ACTIVE:
                                    echo '<span class="label label-default">'
                                        . Yii::t('app', 'Inactive')
                                        . '</span>';
                                    break;
                                default:
                                    echo '<span class="label label-info">'
                                        . Yii::t('app', 'Indefinite')
                                        . '</span>';
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php else: ?>
                    <?php echo Yii::t('app', 'No Data') ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php echo LinkPager::widget([
            'pagination' => $reminderPages,
            'options' => [
                'class' => 'pagination pagination-sm pull-right',
            ],
        ]);
        ?>
        <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
        <?php
        echo Html::a(
            Yii::t('app', 'View All Reminders'),
            Url::to(['/reminder/index']),
            ['class' => 'btn btn-default btn-info pull-right']
//            ['class' => 'btn btn-default btn-info pull-left']
        );
//        echo Html::a(
//            FA::icon('plus') . ' ' . Yii::t('app', 'Add Reminder'),
//            Url::to(['/leads/index']),
//            ['class' => 'btn btn-default pull-right']
//        );
        ?>
    </div>
    <!-- /.box-footer -->
</div>
<?php Pjax::end(); ?>