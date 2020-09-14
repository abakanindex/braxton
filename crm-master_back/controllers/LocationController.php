<?php

namespace app\controllers;

use app\models\Locations;
use Yii;
use yii\web\{Controller, Response};
use yii\helpers\{ArrayHelper, Json};

class LocationController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSearch()
    {
        $request  = Yii::$app->request;
        $postData = $request->post();
        $emirateId = $locationId = $subLocationId = 0;
        $data = [];

        if ($request->isPost) {
            $location = Locations::getByName($postData['text']);

            switch($location->type) {
                case(Locations::TYPE_EMIRATE):
                    $emirateId = $location->id;
                    break;
                case(Locations::TYPE_LOCATION):
                    $locationId = $location->id;
                    $emirateId  = $location->parent->id;
                    break;
                case(Locations::TYPE_SUB_LOCATION):
                    $subLocationId = $location->id;
                    $locationId    = $location->parent->id;
                    $emirate       = Locations::getById($location->parent->parent_id);
                    $emirateId     = $emirate->id;
                    break;
            }

            $data = [
                'emirateId'     => $emirateId,
                'locationId'    => $locationId,
                'subLocationId' => $subLocationId
            ];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $data;
    }

}
