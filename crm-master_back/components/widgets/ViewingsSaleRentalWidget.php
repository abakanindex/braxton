<?php
namespace app\components\widgets;

use app\models\Company;
use app\models\User;
use app\modules\lead\models\LeadSubStatus;
use app\modules\lead\models\LeadType;
use Yii;
use app\models\agent\Agent;
use app\models\Leads;
use app\models\LeadsSearch;
use app\models\Viewings;
use yii\base\Widget;
use app\components\widgets\ViewingsSaleRentalWidgetAsset;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

class ViewingsSaleRentalWidget extends Widget
{
    public $model;
    public $viewingsStatuses;
    public $agents;
    public $agents2;
    public $ref;
    public $viewings;
    public $leadViewingLeadsDataProvider;
    public $leadViewingLeadsSearchModel;
    public $type;
    public $types;
    public $statuses;
    public $subStatuses;

    public function init()
    {
//        $agentUser = new Agent();
        $user            = new User();
        $this->agents    = ArrayHelper::map($user->getAllCompanyUsers(), 'id', 'username');
        $this->agents2   = ArrayHelper::map(User::find()->all(), 'id', 'username');

        $this->leadViewingLeadsSearchModel = new LeadsSearch();
        $this->leadViewingLeadsDataProvider = $this->leadViewingLeadsSearchModel
            ->search(Yii::$app->request->queryParams);
        $this->leadViewingLeadsDataProvider->pagination->pageSize = 10;

        $this->viewingsStatuses = Viewings::$statuses;
        $this->viewings = Viewings::getByRefByAgents($this->ref, Yii::$app->user->id);
        $this->types = ArrayHelper::map(LeadType::getTypes(), 'id', 'title');
        $this->statuses = Leads::getStatuses();
        $this->subStatuses = ArrayHelper::map(LeadSubStatus::getSubStatuses(), 'id', 'title');
    }

    public function run()
    {
        ViewingsSaleRentalWidgetAsset::register($this->view);
        $this->model->agent_id = ($this->model->agent_id) ? $this->model->agent_id : Yii::$app->user->id;

        return $this->render('viewings/viewings', [
            'model'                        => $this->model,
            'viewingsStatuses'             => $this->viewingsStatuses,
            'agents'                       => $this->agents,
            'agents2'                      => $this->agents2,
            'ref'                          => $this->ref,
            'viewings'                     => $this->viewings,
            'type'                         => $this->type,
            'leadViewingLeadsSearchModel'  => $this->leadViewingLeadsSearchModel,
            'leadViewingLeadsDataProvider' => $this->leadViewingLeadsDataProvider,
            'types'                        => $this->types,
            'statuses'                     => $this->statuses,
            'subStatuses'                  => $this->subStatuses,
            'viewingReports'               => Viewings::getByCompleteReport(1, $this->ref, Yii::$app->user->id)
        ]);
    }
}