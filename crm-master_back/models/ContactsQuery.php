<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Contacts]].
 *
 * @see Contacts
 */
class ContactsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Contacts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Contacts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
