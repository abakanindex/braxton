<?php
namespace app\components\widgets;

use app\models\User;
use Yii;
use app\models\agent\Agent;
use app\models\Company;
use app\models\Rentals;
use app\models\RentalsSearch;
use app\models\Sale;
use app\models\SaleSearch;
use app\models\Viewings;
use yii\base\Widget;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\components\widgets\ViewingsLeadWidgetAsset;

class ViewingsLeadWidget extends Widget
{
    public $model;
    public $viewingsStatuses;
    public $agents;
    public $agents2;
    public $viewings;
    public $saleSearchModel;
    public $rentalSearchModel;
    public $saleDataProvider;
    public $rentalDataProvider;
    public $modelLead;
    public $type;

    public function init()
    {
//        $agentUser = new Agent();
        $user              = new User();
        $this->agents      = ArrayHelper::map($user->getAllCompanyUsers(), 'id', 'username');
        $this->agents2     = ArrayHelper::map(User::find()->all(), 'id', 'username');
        $saleSearchModel   = new SaleSearch();
        $rentalSearchModel = new RentalsSearch();

        $saleDataProvider   = $saleSearchModel->search(Yii::$app->request->queryParams);
        $rentalDataProvider = $rentalSearchModel->search(Yii::$app->request->queryParams);

        $this->saleSearchModel     = $saleSearchModel;
        $this->rentalSearchModel   = $rentalSearchModel;
        $this->saleDataProvider    = $saleDataProvider;
        $this->rentalDataProvider  = $rentalDataProvider;
        $this->viewings = Viewings::getByRefByAgents(
            $this->modelLead->reference,
            Yii::$app->user->id
        );
        $this->viewingsStatuses    = Viewings::$statuses;
    }

    public function run()
    {
        ViewingsLeadWidgetAsset::register($this->view);
        $this->model->agent_id = ($this->model->agent_id) ? $this->model->agent_id : Yii::$app->user->id;

        return $this->render('viewingsLead/viewingsLead', [
            'model'              => $this->model,
            'viewingsStatuses'   => $this->viewingsStatuses,
            'agents'             => $this->agents,
            'agents2'            => $this->agents2,
            'modelLead'          => $this->modelLead,
            'viewings'           => $this->viewings,
            'saleSearchModel'    => $this->saleSearchModel,
            'rentalSearchModel'  => $this->rentalSearchModel,
            'saleDataProvider'   => $this->saleDataProvider,
            'rentalDataProvider' => $this->rentalDataProvider,
            'type'               => $this->type,
            'viewingReports'     => Viewings::getByCompleteReport(1, $this->modelLead->reference, Yii::$app->user->id)
        ]);
    }
}