<?php

namespace app\models\reference_books;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "property_category".
 *
 * @property int $id
 * @property string $title
 * @property int $order
 */
class PropertyCategory extends \yii\db\ActiveRecord
{
    public static $shortCodes = [
        'Apartment' => 'AP',
        'Bulk Units' => 'BU',
        'Bungalow' => 'BW',
        'Compound' => 'CD',
        'Duplex' => 'DX',
        'Factory' => 'FA',
        'Full Floor' => 'FF',
        'Hotel Apartment' => 'HA',
        'Half Floor' => 'HF',
        'Labour Camp' => 'LC',
        'Land/Plot' => 'LP',
        'Office' => 'OF',
        'Penthouse' => 'PH',
        'Retail' => 'RE',
        'Restaurant' => 'RT',
        'Staff Accommodation' => 'SA',
        'Shop' => 'SH',
        'Show Room' => 'SR',
        'Storage' => 'SR',
        'Townhouse' => 'TH',
        'Villa' => 'VH',
        'Whole Building' => 'WB',
        'Warehouse' => 'WH'
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'property_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'order'], 'required'],
            [['order'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['order'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'order' => Yii::t('app', 'Order'),
        ];
    }

    public static function getById($id)
    {
        return self::findOne($id);
    }

    public static function getByTitle($name)
    {
        return self::findOne(['title' => $name]);
    }

    public static function getCategories()
    {
        return (new Query())->select('')->from(self::tableName())->createCommand()->queryAll();
    }
    
    /**
     * 
     * @param iterable $model
     * @return array
     */
    public function getNameCategoryById(iterable $model) : array
    {    
        $result = self::find()->select([
            'id',
            'title',
        ])->where([
            'id' => $model->category_id,
        ])->asArray()->all();
        
        return $result;
    }
}
