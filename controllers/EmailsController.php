<?php

namespace app\controllers;
use app\models\MailerForm;

class EmailsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        
        $modelMailer = new MailerForm();
        return $this->render('index', [
            'modelMailer' => $modelMailer
        ]);
    }

}
