<?php

use yii\db\Migration;
use app\models\Reminder;

/**
 * Class m190419_151454_add_field_reminder
 */
class m190419_151454_add_field_reminder extends Migration
{
    public function up()
    {
        $this->addColumn(Reminder::tableName(), 'subject', $this->string());
    }

    public function down()
    {
        $this->dropColumn(Reminder::tableName(), 'subject');
    }
}
