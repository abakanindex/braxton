<?php

use yii\db\Migration;
use app\modules\lead\models\LeadType;

/**
 * Class m190124_152045_update_lead_type_data
 */
class m190124_152045_update_lead_type_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->insert(LeadType::tableName(), [
            'id'    => 9,
            'title' => 'Representative',
            'order' => 9
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->delete(LeadType::tableName(), ['id' => 9]);
    }
}
