<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users_source`.
 */
class m180301_122524_create_users_source_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('users_source', [
            'id' => $this->primaryKey(),
            'company' => $this->string(),
            'username' => $this->string(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'job_title' => $this->string(),
            'office_no' => $this->string(),
            'country_dialing' => $this->string(),
            'mobile_no' => $this->string(),
            'email' => $this->string()->unique(),
            'access_level' => $this->string(),
            'user_role' => $this->string(),
            'status' => $this->string(),
            'company_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('users_source');
    }
}
