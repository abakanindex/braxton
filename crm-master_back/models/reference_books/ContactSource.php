<?php

namespace app\models\reference_books;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "{{%contact_Source}}".
 *
 * @property int $id
 * @property string $source
 */
class ContactSource extends \yii\db\ActiveRecord
{
    const SOURCE_DUBIZZLE       = 30;
    const SOURCE_BAYUT          = 17;
    const SOURCE_PROPERTYFINDER = 87;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contact_source}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source' => 'Source',
        ];
    }

    public static function getContactSources()
    {
        return (new Query())->select('')->from(self::tableName())->createCommand()->queryAll();
    }
    
    public function getNameSourceById(iterable $model) : array
    {
        $result = self::find()->select([
            'id',
            'source',
        ])->where([
            'id' => $model->source_of_listing,
        ])->asArray()->all();
        
        return $result;
    }

    
    /**
     * @inheritdoc
     * @return ReligionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReligionQuery(get_called_class());
    }
}
