<?php

namespace app\modules\admin\import\models;

use app\models\reference_books\PropertyCategory;
use app\models\Sale;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "import_temp".
 *
 * @property int $id
 * @property string $xml_link
 * @property string $data
 * @property string $username
 * @property string $password
 * @property integer $client_id
 * @property string $datetime
 */
class ImportTemp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'import_temp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'xml_link' => Yii::t('app', 'Xml Link'),
            'data' => Yii::t('app', 'Data'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    public function updateSalesTable()
    {
        $update = Yii::$app->db->createCommand("
                    UPDATE sale s, property_category pc 
                      SET s.`category_id` = pc.`id`
                      WHERE pc.`title` = s.`category_id`
                ");
        if ($update->execute()) {
            echo 'Sale table updated. <br />';
            flush();
        }
        return null;
    }

    public function updateRentalsTable()
    {
        $update = Yii::$app->db->createCommand("
                    UPDATE rentals r, property_category pc 
                      SET r.`category_id` = pc.`id`
                      WHERE pc.`title` = r.`category_id`
                ");
        if ($update->execute()) {
            echo 'Rentals table updated. <br />';
            flush();
        }
        return null;
    }
}
