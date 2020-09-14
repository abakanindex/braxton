<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m170919_162253_create_user_table extends Migration
{
    public $path;
    
    public function up()
    {
        $tableOptions = null;

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'job_title' => $this->string(),
            'office_no' => $this->string(),
            'country_dialing' => $this->string(),
            'mobile_no' => $this->string(),
            'auth_key' => $this->string(32),
            'password_hash' => $this->string(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->unique(),
            'role' => $this->string(),
            'status' => $this->smallInteger(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'activation' => $this->string(255),
            'phone_number' => $this->bigInteger(),
            'country' => $this->string(255),
            'company_id' => $this->integer(),
            'create_by_user_id' => $this->integer(),
            'department' => $this->string(255),
            'rera' => $this->string(),
            'rental_commission' => $this->float(),
            'sales_commission' => $this->float(),
            'agent_signature' => $this->string(),
            'agent_bio' => $this->text(),
            'img_user_profile' => $this->string(),
            'img_contact_overlay' => $this->string(),
            'video_profile_name' => $this->string(),
            'video_profile_path' => $this->string(),
            'language' => $this->string(),
            'imap_email' => $this->string(),
            'imap_password' => $this->string(),
            'imap_port' => $this->string(),
            'imap' => $this->string(),
            'imap_enabled' => $this->integer()
        ], $tableOptions);

        $this->createIndex('company_accounts', 'user', ['id', 'company_id'], true);

        $this->path = 'migrations/_user.sql';
        $this->execute(file_get_contents($this->path));

    }

    public function down()
    {
        $this->dropTable('user');
    }


}
