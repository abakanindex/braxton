<?php

use yii\db\Migration;

class m171016_185613_create_user_profile_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%user_profile}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'watermark' => $this->string(),
            'accost_id' => $this->smallInteger(),
            'company_id' => $this->smallInteger(),
            'rental_comm' => $this->string(),
            'sales_comm' => $this->string(),
            'rera_brn' => $this->string(),
            'mobile_number' => $this->bigInteger(),
            'job_title' => $this->string(),
            'Department' => $this->string(),
            'office_tel' => $this->bigInteger(),
        ]);

        $this->createTable('{{%user_profile_accost_select}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
        ]);

        $this->insert('user_profile_accost_select', ['title' => 'Mr.']);
        $this->insert('user_profile_accost_select', ['title' => 'Mrs.']);
        $this->insert('user_profile_accost_select', ['title' => 'Ms.']);
        $this->insert('user_profile_accost_select', ['title' => 'Miss.']);
        $this->insert('user_profile_accost_select', ['title' => 'Mx.']);
        $this->insert('user_profile_accost_select', ['title' => 'Master.']);
        $this->insert('user_profile_accost_select', ['title' => 'Madam.']);
        $this->insert('user_profile_accost_select', ['title' => 'Dr.']);
        $this->insert('user_profile_accost_select', ['title' => 'Prof.']);
        $this->insert('user_profile_accost_select', ['title' => 'Hon.']);
        $this->insert('user_profile_accost_select', ['title' => 'Other.']);

        $this->createTable('{{%user_profile_mobile_phones}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->smallInteger(),
            'mobile_phone' => $this->integer(),
        ]);

        $this->createTable('{{%user_profile_languages}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
        ]);

        $this->insert('{{%user_profile}}', [
            'user_id' => 1,
            'first_name' => 'CRM main admin account',
            'last_name' => '',
            'watermark' => 'watermark.png',
            'accost_id' => 1,
            'company_id' => 0,
            ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%user_profile}}');
        $this->dropTable('{{%user_profile_accost_select}}');
        $this->dropTable('{{%user_profile_mobile_phones}}');
        $this->dropTable('{{%user_profile_languages}}');
    }
}
