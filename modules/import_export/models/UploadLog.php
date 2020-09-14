<?php

namespace app\modules\import_export\models;

use Yii;

/**
 * This is the model class for table "upload_log".
 *
 * @property int $id
 * @property string $timestamp
 * @property int $user_id
 * @property string $file_name
 * @property int $random_int
 */
class UploadLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'upload_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['timestamp'], 'safe'],
            [['user_id'], 'required'],
            [['user_id', 'random_int'], 'integer'],
            [['file_name'], 'string', 'max' => 90],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'timestamp' => 'Timestamp',
            'user_id' => 'User ID',
            'file_name' => 'File Name',
            'random_int' => 'Random Int',
        ];
    }

    public function insertLogRow($fileName = '', $userId = 0, $fileIdentifier = 0)
    {
        $this->file_name = $fileName;
        $this->timestamp = date('Y-m-d H:m:s');
        $this->user_id = $userId;
        $this->random_int = $fileIdentifier;
        if ($this->save()) {
            return true;
        }
        return false;
    }
}
