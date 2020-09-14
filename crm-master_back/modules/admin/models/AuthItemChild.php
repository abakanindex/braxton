<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "auth_item_child".
 *
 * @property string $parent
 * @property string $child
 * @property int $company_id
 */
class AuthItemChild extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_item_child';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent', 'child', 'company_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'parent'     => Yii::t('app', 'Parent'),
            'child'      => Yii::t('app', 'Child'),
            'company_id' => Yii::t('app', 'Company ID'),
        ];
    }
}
