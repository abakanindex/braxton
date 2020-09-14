<?php

namespace app\models\reference_books;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "features".
 *
 * @property int $id
 * @property string $features
 */
class Features extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'features';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['features'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'features' => Yii::t('app', 'Features'),
        ];
    }

    public static function getFeatures()
    {
        return (new Query())->select('')->from(self::tableName())->createCommand()->queryAll();
    }
    
        /**
     * 
     * @param iterable $model
     * @return array
     */
    public function getFeaturesName(iterable $model) : array 
    {
        $result       = explode(',', $model->features);
        $nameFeatures = [];
        $arrFeatures  = [];
        $id           = 1;
        foreach ($result as $value) {
            $arrFeatures[] = self::find()->where(['id' => $value])->all();
        }
        
        for ($i = 0; count($arrFeatures) > $i; $i++) {
            $nameFeatures[$id] = $arrFeatures[$i][0]['features'];
            $id++;
        }
        
        return $nameFeatures;
    }
}
