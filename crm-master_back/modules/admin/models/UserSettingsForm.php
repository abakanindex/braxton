<?php

namespace app\modules\admin\models;


use yii\base\Model;

class UserSettingsForm extends Model
{
    public $ownergroup;

       /**
     *
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'ownergroup'
                ], 
                'safe'
            ],
        ];
    }

}