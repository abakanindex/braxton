<?php

use yii\db\Migration;

/**
 * Class m180806_100229_add_parse_full_name_to_contacts_table
 */
class m180806_100229_add_parse_full_name_to_contacts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('contacts', 'parsed_full_name', $this->string());
        $this->addColumn('contacts', 'parsed_full_name_reverse', $this->string());
        $this->addColumn('contacts_archive', 'parsed_full_name', $this->string());
        $this->addColumn('contacts_archive', 'parsed_full_name_reverse', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('contacts', 'parsed_full_name');
        $this->dropColumn('contacts_archive', 'parsed_full_name');
        $this->dropColumn('contacts', 'parsed_full_name_reverse');
        $this->dropColumn('contacts_archive', 'parsed_full_name_reverse');
    }
}
