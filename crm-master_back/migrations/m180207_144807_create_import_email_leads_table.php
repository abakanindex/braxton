<?php

use yii\db\Migration;

/**
 * Handles the creation of table `import_email_leads`.
 */
class m180207_144807_create_import_email_leads_table extends Migration
{
    public $path;

    public function up()
    {
        $tableOptions = null;

        $this->createTable('{{%import_email_leads}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'enabled' => $this->boolean(),
            'imap' => $this->string(),
            'email' => $this->string()->unique(),
            'password' => $this->string(),
            'port' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->path = 'migrations/_import_email_leads.sql';
        $this->execute(file_get_contents($this->path));

    }

    public function down()
    {
        $this->dropTable('import_email_leads');
    }
}
