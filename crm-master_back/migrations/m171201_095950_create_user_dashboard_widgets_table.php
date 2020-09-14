<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_widgets`.
 */
class m171201_095950_create_user_dashboard_widgets_table extends Migration
{

    public function up()
    {
        $this->createTable('user_dashboard_widgets', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'widget' => $this->integer()->notNull(),
            'order' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-user_dashboard_widgets-user_id',
            'user_dashboard_widgets',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user_dashboard_widgets-user_id',
            'user_dashboard_widgets',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-user_dashboard_widgets-user_id',
            'user_dashboard_widgets'
        );

        $this->dropIndex(
            'idx-user_dashboard_widgets-user_id',
            'user_dashboard_widgets'
        );

        $this->dropTable('user_dashboard_widgets');
    }
}
