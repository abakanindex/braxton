<?php

use yii\db\Migration;

/**
 * Handles the creation of table `profile_company`.
 */
class m180430_110253_create_profile_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function Up()
    {
        $this->createTable('profile_company', [
            'company_name'    => $this->string(),
            'rera_orn'        => $this->string(),
            'trn'             => $this->string(),
            'address'         => $this->string(),
            'office_tel'      => $this->string(),
            'office_fax'      => $this->string(),
            'primary_email'   => $this->string(),
            'website'         => $this->string(),
            'company_profile' => $this->string(),
            'logo'            => $this->string(),
            'watermark'       => $this->string(),
        ]);
        $this->addColumn('profile_company', 'company_id', $this->primaryKey());
    }

    /**
     * {@inheritdoc}
     */
    public function Down()
    {
        $this->dropTable('profile_company');
    }
}
