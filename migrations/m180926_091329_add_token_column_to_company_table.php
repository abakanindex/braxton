<?php

use yii\db\Migration;

/**
 * Handles adding token to table `company`.
 */
class m180926_091329_add_token_column_to_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('company', 'token', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('company', 'token');
    }
}
