<?php

use yii\db\Migration;
use app\modules\lead\models\LeadSubStatus;

/**
 * Class m190401_122931_update_lead_sub_status
 */
class m190401_122931_update_lead_sub_status extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->delete(LeadSubStatus::tableName());
        Yii::$app->db->createCommand()->batchInsert(LeadSubStatus::tableName(), ['id', 'title', 'order'], [
            [1, 'Not contacted', 1],
            [2, 'In progress', 2],
            [3, 'Successfull', 3],
            [4, 'Unsuccessfull', 4],
            [5, 'Called no reply', 5],
            [6, 'Follow up', 6],
            [7, 'Viewing arranged', 7],
            [8, 'Not specified', 8],
            [9, 'Offer made', 9],
            [10, 'Needs more info', 10],
            [11, 'Budget differs', 11],
            [12, 'Needs time', 12],
        ])->execute();
    }

    public function down()
    {
        $this->delete(LeadSubStatus::tableName());
    }
}
