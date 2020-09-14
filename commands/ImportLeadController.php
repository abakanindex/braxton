<?php

namespace app\commands;
use app\modules\lead\models\EmailImportLeadParser;
use yii\console\Controller;
use Yii;

class ImportLeadController extends Controller
{
    public $message;

    public function actionIndex()
    {
        EmailImportLeadParser::checkEmail();
        echo "Ok!\n";
        return 0;
    }
}