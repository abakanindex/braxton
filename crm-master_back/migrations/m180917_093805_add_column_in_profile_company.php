<?php

use yii\db\Migration;
use app\modules\profileCompany\models\ProfileCompany;

/**
 * Class m180917_093805_add_column_in_profile_company
 */
class m180917_093805_add_column_in_profile_company extends Migration
{
    public function up()
    {
        $this->addColumn(ProfileCompany::tableName(), 'prefix', $this->string());
    }

    public function down()
    {
        $this->dropColumn(ProfileCompany::tableName(), 'prefix');
    }
}
