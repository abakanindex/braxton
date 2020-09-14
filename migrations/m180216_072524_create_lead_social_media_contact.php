<?php

use yii\db\Migration;

/**
 * Class m180216_072524_create_lead_social_media_contact
 */
class m180216_072524_create_lead_social_media_contact extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('lead_social_media_contact', [
            'id' => $this->primaryKey(),
            'lead_id' => $this->integer()->notNull(),
            'type' => $this->integer(2),
            'link' => $this->string(100)
        ]);

        $this->createIndex(
            'idx-lead_social_media_contact-lead_id',
            'lead_social_media_contact',
            'lead_id'
        );

        $this->addForeignKey(
            'fk-lead_social_media_contact-lead_id',
            'lead_social_media_contact',
            'lead_id',
            'leads',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-lead_social_media_contact-lead_id',
            'lead_social_media_contact'
        );

        $this->dropIndex(
            'idx-lead_social_media_contact-lead_id',
            'lead_social_media_contact'
        );

        $this->dropTable('lead_social_media_contact');
    }
}
