<?php

namespace app\modules\lead\models;

use app\models\Leads;
use Yii;

/**
 * This is the model class for table "lead_social_media_contact".
 *
 * @property int $id
 * @property int $lead_id
 * @property int $type
 * @property string $link
 *
 * @property Leads $lead
 */
class LeadSocialMediaContact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lead_social_media_contact';
    }

    const TYPE_FACEBOOK = 1;
    const TYPE_LINKEDIN = 2;
    const TYPE_INSTAGRAM = 3;

    public static function getTypes()
    {
        $types = [];
        $types[self::TYPE_FACEBOOK] = Yii::t('app', 'Facebook');
        $types[self::TYPE_LINKEDIN] = Yii::t('app', 'Linkedin');
        $types[self::TYPE_INSTAGRAM] = Yii::t('app', 'Instagram');
        return $types;
    }

    public function getBtnClass()
    {
        switch ($this->type) {
            case self::TYPE_FACEBOOK: return 'facebook-f'; break;
            case self::TYPE_LINKEDIN: return 'linkedin'; break;
            case self::TYPE_INSTAGRAM: return 'instagram'; break;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lead_id'], 'required'],
            [['lead_id', 'type'], 'integer'],
            [['link'], 'string', 'max' => 100],
            [['lead_id'], 'exist', 'skipOnError' => true, 'targetClass' => Leads::className(), 'targetAttribute' => ['lead_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lead_id' => Yii::t('app', 'Lead ID'),
            'type' => Yii::t('app', 'Type'),
            'link' => Yii::t('app', 'Link'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLead()
    {
        return $this->hasOne(Leads::className(), ['id' => 'lead_id']);
    }
}
