<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Leads]].
 *
 * @see Leads
 */
class LeadsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Leads[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Leads|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
