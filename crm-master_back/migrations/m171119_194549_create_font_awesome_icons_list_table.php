<?php

use yii\db\Migration;

/**
 * Handles the creation of table `font_awesome_icons_list`.
 */
class m171119_194549_create_font_awesome_icons_list_table extends Migration
{
    public $path;
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('font_awesome_icons_list', [
            'id' => $this->primaryKey(),
            'icon_class' => $this->string()->notNull(),
            'preview' => $this->string()->notNull(),
        ]);

        $this->path = 'migrations/_fa_icons_list.sql';
        $this->execute(file_get_contents($this->path));
    }


    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('font_awesome_icons_list');
    }
}
