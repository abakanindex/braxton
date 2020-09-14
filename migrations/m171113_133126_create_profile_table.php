<?php

use yii\db\Migration;

/**
 * Handles the creation of table `profile`.
 */
class m171113_133126_create_profile_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('profile', [
            'id' => $this->primaryKey(),
            'owner_user_id' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('profile');
    }
}
