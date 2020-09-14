<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "departments".
 *
 * @property int $id
 * @property string $title
 * @property int $parent
 */
class Departments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'departments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'parent' => Yii::t('app', 'Parent'),
        ];
    }
}
