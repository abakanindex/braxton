<?php

namespace app\models\admin\dataselect;

/**
 * This is the ActiveQuery class for [[Title]].
 *
 * @see Title
 */
class TitleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Title[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Title|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
