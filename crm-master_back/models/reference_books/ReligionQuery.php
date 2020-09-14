<?php

namespace app\models\reference_books;

/**
 * This is the ActiveQuery class for [[Religion]].
 *
 * @see Religion
 */
class ReligionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Religion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Religion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
