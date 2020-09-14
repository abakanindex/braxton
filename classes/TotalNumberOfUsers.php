<?php

namespace app\classes;

use app\models\agent\Agent;
use yii;


class TotalNumberOfUsers 
{

    /**
     * this method 
     *
     * @return void
     */
    public function addDateTopUsersInJsone() : void
    {
        $getUser = (new Agent())->getNameOneAgentById(Yii::$app->user->getId());

        $json   = file_get_contents('../web/json/toptenusers.json');
        $json   = json_decode($json, true);
        $json[$getUser]   = $json[$getUser] + 1;
        $json   = json_encode($json);
        file_put_contents('../web/json/toptenusers.json', $json);
        
    }
}
