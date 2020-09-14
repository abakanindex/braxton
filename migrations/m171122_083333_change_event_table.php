<?php

use yii\db\Migration;

/**
 * Class m171122_083333_change_event_table
 */
class m171122_083333_change_event_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('event', 'ref_leads');
        $this->dropColumn('event', 'ref_listings');
        $this->dropColumn('event', 'ref_deals');

        $this->addColumn('event', 'rentals_id', $this->integer());
        $this->addColumn('event', 'sale_id', $this->integer());
        $this->addColumn('event', 'lead_viewing_id', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('event', 'ref_leads', $this->integer());
        $this->addColumn('event', 'ref_listings', $this->integer());
        $this->addColumn('event', 'ref_deals', $this->integer());

        $this->dropColumn('event', 'rentals_id');
        $this->dropColumn('event', 'sale_id');
        $this->dropColumn('event', 'lead_viewing_id');
    }

}
