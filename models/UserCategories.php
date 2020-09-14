<?php

namespace app\models;

use app\models\reference_books\PropertyCategory;
use Yii;

/**
 * This is the model class for table "user_categories".
 *
 * @property int $id
 * @property int $category_id
 * @property int $user_id
 */
class UserCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'user_id'], 'required'],
            [['category_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'user_id' => 'User ID',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getPropertyCategory()
    {
        return $this->hasOne(PropertyCategory::className(), ['id' => 'category_id']);
    }
}
