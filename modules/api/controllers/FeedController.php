<?php

namespace app\modules\api\controllers;

use app\classes\Feed;
use app\models\Company;
use app\models\reference_books\Portals;
use app\models\Rentals;
use app\models\Sale;
use app\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\{ArrayHelper, Json, Url, FileHelper};
use yii\web\{
    UploadedFile,
    NotFoundHttpException,
    Controller,
    Response
};

/**
 * Default controller for the `api` module
 */
class FeedController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionXml($portalId, $token) {

        $company = Company::getCompanyByToken($token);
        $xml = (new Feed())->returnXml($portalId, $company->id);


//        Yii::$app->response->format = Response::FORMAT_XML;
//        Yii::$app->response->headers->add('Content-Type', 'text/xml');

//        return htmlspecialchars_decode($xml);
//        echo htmlentities($xml);exit;
        return nl2br(htmlentities($xml));
    }

    public function actionView($portalId, $token)
    {
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, Yii::$app->getUrlManager()->createAbsoluteUrl(['/api/feed/xml']));
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
//            'portalId' => $portalId,
//            'username' => 'admin',
//            'password' => '123456'
//        )));
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        $serverOutput = curl_exec($ch);
//        curl_close($ch);
//
//        $data = Json::decode($serverOutput);

//        $xml = new \XmlWriter();
//        $xml->openMemory();
//        $xml->startDocument('1.0', 'UTF-8');
//        $xml->startElement('mydoc');
//        $xml->startElement('myele');
//
//        $xml->startElement('mycdataelement');
//        $xml->writeCData("text for inclusion within CData tags");
//        $xml->endElement();
//
//        $xml->endElement();
//        $xml->endElement();


        $company = Company::getCompanyByToken($token);
        $xml = (new Feed())->returnXml($portalId, $company->id);


        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/xml');

        return $xml;
    }

//    public function actionXml()
//    {
//        $request = Yii::$app->request;
//
//        if ($request->isPost) {
//            $data = $request->post();
//            $portalId = $data['portalId'];
//            $username = $data['username'];
//            $password = $data['password'];
//            $user = User::getByUsername($username);
//
//            if (!$user->validatePassword($password)) {
//                return 'invalid password or username';
//            }
//
//            Yii::$app->user->login($user, 0);
//
//            $data = [
//                'xml' => (new Feed())->returnXml($portalId, $company)
//            ];
//
//            return $this->asJson($data);
//        }
//    }
}
