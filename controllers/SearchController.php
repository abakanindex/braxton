<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\{ArrayHelper, Json, Url, FileHelper};
use yii\web\{
    UploadedFile,
    NotFoundHttpException,
    Controller,
    Response
};
use app\models\{
    SaleSearch,
    Sale,
    Company,
    Gallery,
    Rentals,
    Contacts,
    Leads
};
use yii\filters\AccessControl;

class SearchController extends Controller
{
    public function actionSearch()
    {
        $request  = Yii::$app->request;
        $postData = $request->post();
        $value = $postData['search-value'];
        $searchIn = array_filter(explode(";", $postData['search-in-objects']));
        $rentals = $sales = $contacts = $leads = [];

        foreach($searchIn as $sI) {
            switch($sI) {
                case 1:
                    $rentals = (new Rentals)::searchBy($value);
                    break;
                case 2:
                    $sales = (new Sale)::searchBy($value);
                    break;
                case 3:
                    $contacts = (new Contacts())::searchBy($value);
                    break;
                case 4:
                    $leads = (new Leads())::searchBy($value);
                    break;
            }
        }

        return $this->render('index',[
            'contacts'    => $contacts,
            'rentals'     => $rentals,
            'sales'       => $sales,
            'searchValue' => $value,
            'leads'       => $leads
        ]);
    }
}