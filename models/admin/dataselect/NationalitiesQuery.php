<?php

namespace app\models\admin\dataselect;

/**
 * This is the ActiveQuery class for [[Nationalities]].
 *
 * @see Nationalities
 */
class NationalitiesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Nationalities[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Nationalities|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
