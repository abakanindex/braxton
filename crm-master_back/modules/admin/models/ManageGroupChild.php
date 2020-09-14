<?php

namespace app\modules\admin\models;

use app\models\User;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "{{%manage_group_child}}".
 *
 * @property string $group_name
 * @property int $user_id
 */
class ManageGroupChild extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%manage_group_child}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['group_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'group_name' => Yii::t('app', 'Group Name'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    public static function getForUser($userId)
    {
        $query = new Query();

        return $query
            ->select([
                'mGC.*',
                'oMG.owner_id',
                'u.email as owner_email'
            ])
            ->from(self::tableName() . ' mGC')
            ->innerJoin(OwnerManageGroup::tableName() . ' oMG', 'oMG.group_name = mGC.group_name')
            ->innerJoin(User::tableName() . ' u', 'u.id = oMG.owner_id')
            ->where(['user_id' => $userId])
            ->all();
    }
}
