<?php

use app\models\Reminder;

?>
<div class="reminder_block" style="margin-top: 10px">
    <h4><?= Yii::t('app', 'Reminder Info') ?></h4>
    <table class="table table-striped table-bordered detail-view">
        <tr>
            <th><?= Yii::t('app', 'Inteval Time') ?></th>
            <td style="width: 50%" class="interval_time">
                <?php if ($reminder->time) echo $reminder->time; ?>
            </td>
        </tr>
        <tr>
            <th><?= Yii::t('app', 'Inteval') ?></th>
            <td class="interval">
                <?php if ($reminder->interval_type) echo Reminder::getIntervalType($reminder->interval_type); ?>
            </td>
        </tr>
        <tr>
            <th><?= Yii::t('app', 'Notification Time') ?></th>
            <td class="notification">
                <?php
                if ($reminder->remind_at_time) echo date('Y-m-d H:i', $reminder->remind_at_time);
                ?>
            </td>
        </tr>
        <tr>
            <th><?= Yii::t('app', 'Status') ?></th>
            <td class="status">
                <?php
                if ($reminder && !$reminder->isNewRecord) {
                    if ($reminder->status == Reminder::STATUS_ACTIVE)
                        echo Yii::t('app', 'Active');
                    else
                        echo Yii::t('app', 'Not Active');
                }
                ?>
            </td>
        </tr>
        <tr>
            <th><?= Yii::t('app', 'Note') ?></th>
            <td class="note">
                <?php
                if ($reminder->description) echo nl2br($reminder->description);
                ?>
            </td>
        </tr>
    </table>
</div>