<?php

namespace app\modules\admin\models;

use Yii;
use app\modules\admin\models\ManageGroupChild;

/**
 * This is the model class for table "{{%owner_manage_group}}".
 *
 * @property string $group_name
 * @property int $owner_id
 */
class OwnerManageGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%owner_manage_group}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['owner_id'], 'integer'],
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
            'owner_id'   => Yii::t('app', 'Owner ID'),
        ];
    }

    /**
     * Undocumented function
     *
     * @param [type] $modeId
     * @param [type] $postData
     * @return void
     */
    public function setGroupOwner($modeId, $postData) 
    {
        $rows = [];
       
        if (!empty($postData)) {
            for ($i=0; $i < count($postData); $i++) { 
                $result = $this::find()->where(['group_name' =>  $postData[$i], 'owner_id' => $modeId])->exists();
                if ($result == false) {
                    $rows[] = [$postData[$i], $modeId];
                }
            }
            Yii::$app->db->createCommand()
            ->batchInsert($this::tableName(), $this::attributes(), $rows)
            ->execute();
        } 

    }

    /**
     * this method return id users of group for veiws 
     *
     * @return array
     */
    public function getViewsByGroup() : array
    {
        $getOwnerGroup = $this::find()->where(['owner_id' => Yii::$app->user->id])->all();
        $row = [];
        $result = [];
        $result[] = Yii::$app->user->id;
        $userIdGroup = [];
        for ($i=0; $i < count($getOwnerGroup); $i++) { 
            $row[] = ManageGroupChild::find()->where(['group_name' => $getOwnerGroup[$i]->group_name])->all();
        }
        for ($it=0; $it < count($row); $it++) { 
            for ($ir=0; $ir < count($row[$it]) ; $ir++) { 
                $result[] = $row[$it][$ir]->user_id;
            }
        }
        return array_unique($result);
    }
}
