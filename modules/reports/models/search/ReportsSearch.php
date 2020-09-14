<?php

namespace app\modules\reports\models\search;

use app\models\Leads;
use app\models\Rentals;
use app\models\Sale;
use app\models\TaskManager;
use app\models\User;
use app\models\Note;
use app\models\Viewings;
use app\models\Locations;
use app\modules\reports\models\Reports;
use app\models\reference_books\PropertyCategory;
use app\modules\lead\models\PropertyRequirement;
use app\modules\lead\models\LeadAgent;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

class ReportsSearch
{
    public $params;
    public $query;
    public $report;
    public $queryParams;
    public $email;
    public $pageSize = 10;
    private $companyId;
    private $dashboardChartPath = '';

    public function getReportData($queryParams, $report, $email = false)
    {
        $dataProvider = [];
        $this->queryParams = $queryParams;
        $this->report = $report;
        $this->email = $email;
        switch ($this->report->type) {
            case Reports::LEAD_TYPE:
                $dataProvider = $this->searchLeadsByType();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/leads/charts/leads_by_type__pie';
                break;
            case Reports::LEAD_STATUS:
                $dataProvider = $this->searchLeadsByStatus();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/leads/charts/leads_by_status__pie';
                break;
            case Reports::LEAD_VIEWINGS:
                $dataProvider = $this->searchLeadsByViewings();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/leads/charts/leads_by_viewings__pie';
                break;
            case Reports::SALES_CATEGORY:
                $dataProvider = $this->searchSalesByCategory();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/listings/charts/sales_by_category__pie';
                break;
            case Reports::RENTALS_CATEGORY:
                $dataProvider = $this->searchRentalsByCategory();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/listings/charts/rentals_by_category__pie';
                break;
            case Reports::SALES_LOCATION:
                $dataProvider = $this->searchSalesByLocation();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/listings/charts/sales_by_location__pie';
                break;
            case Reports::RENTALS_LOCATION:
                $dataProvider = $this->searchRentalsByLocation();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/listings/charts/rentals_by_location__pie';
                break;
            case Reports::SALES_STATUS:
                $dataProvider = $this->searchSalesByStatus();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/listings/charts/sales_by_status__pie';
                break;
            case Reports::RENTALS_STATUS:
                $dataProvider = $this->searchRentalsByStatus();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/listings/charts/rentals_by_status__pie';
                break;
            case Reports::SALES_VIEWINGS_REPORT:
                $dataProvider = $this->searchSalesViewings();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/listings/charts/sales_viewings__pie';
                break;
            case Reports::RENTALS_VIEWINGS_REPORT:
                $dataProvider = $this->searchRentalsViewings();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/listings/charts/rentals_viewings__pie';
                break;
            case Reports::TASKS_PRIORITY_REPORT:
                $dataProvider = $this->searchTasksPriority();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/tasks/charts/tasks_by_priority__pie';
                break;
            case Reports::SALES_AGENTS:
                $dataProvider = $this->searchSalesByAgents();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/listings/charts/sales_by_agents__pie';
                break;
            case Reports::RENTALS_AGENTS:
                $dataProvider = $this->searchRentalsByAgents();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/listings/charts/rentals_by_agents__pie';
                break;
            case Reports::SALES_INACTIVE_AGENTS:
                $dataProvider = $this->searchSalesByAgents(Sale::STATUS_UNPUBLISHED);
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/listings/charts/sales_by_agents__pie';
                break;
            case Reports::RENTALS_INACTIVE_AGENTS:
                $dataProvider = $this->searchRentalsByAgents(Rentals::STATUS_UNPUBLISHED);
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/listings/charts/rentals_by_agents__pie';
                break;
            case Reports::LEAD_AGENTS:
                $dataProvider = $this->searchLeadsByAgents();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/leads/charts/leads_by_agents__pie';
                break;
            case Reports::LEAD_PROPERTY:
                $dataProvider = $this->searchLeadsByProperty();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/leads/charts/leads_by_property__pie';
                break;
            case Reports::LEAD_SOURCE:
                $dataProvider = $this->searchLeadsBySource();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/leads/charts/leads_by_source__pie';
                break;
            case Reports::LEAD_OPEN:
                $dataProvider = $this->searchByOpenLeads();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/leads/charts/open_leads__pie';
                break;
            case Reports::LEAD_AGENT_CONTACT_INTERVAL:
                $dataProvider = $this->searchByAgentContactInterval();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/leads/charts/agent_contact_interval__pie';
                break;
            case Reports::LEAD_AGENT_CONTACT_NUMBER:
                $dataProvider = $this->searchByAgentContactNumber();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/leads/charts/agent_contact_number__pie';
                break;
            case Reports::LEAD_BY_LOCATION:
                $dataProvider = $this->searchLeadsByLocation();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/leads/charts/leads_by_location__pie';
                break;
            case Reports::SALES_AGENTS_IN_NUMBERS_PROPERTIES:
                $dataProvider = $this->searchSalesByAgentsNumbersProperties();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/listings/charts/sales_by_agents__pie';
                break;
            case Reports::SALES_AGENTS_IN_AED:
                $dataProvider = $this->searchSalesByAgentsAED();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/listings/charts/sales_by_agents_aed__pie';
                break;
            case Reports::SALES_LOCATION_CLOSED:
                $dataProvider = $this->searchSalesClosedByLocation();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/listings/charts/sales_closed_by_location__pie';
                break;
            case Reports::RENTALS_AGENTS_IN_NUMBERS_PROPERTIES:
                $dataProvider = $this->searchRentalsByAgentsNumbersProperties();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/listings/charts/rentals_by_agents__pie';
                break;
            case Reports::RENTALS_AGENTS_IN_AED:
                $dataProvider = $this->searchRentalsByAgentsAED();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/listings/charts/rentals_by_agents_aed__pie';
                break;
            case Reports::RENTALS_LOCATION_CLOSED:
                $dataProvider = $this->searchRentalsClosedByLocation();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/listings/charts/rentals_closed_by_location__pie';
                break;
            case Reports::AGENT_LEADERBOARD_SALES:
                $dataProvider = $this->searchAgentLeaderBoardSales();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/agent_leader/charts/agent_leader_sales__pie';
                break;
            case Reports::AGENT_LEADERBOARD_RENTALS:
                $dataProvider = $this->searchAgentLeaderBoardRentals();
                $this->dashboardChartPath =
                    '@app/modules/reports/views/main/reports/agent_leader/charts/agent_leader_rentals__pie';
                break;
        }
        return $dataProvider;
    }

    public function searchTasksPriority()
    {
        $this->query = TaskManager::find();
        $this->query->select(["COUNT(*) AS number", 'priority']);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['priority']);
        $this->getTasksIntervalQuery('created_at');
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    public function searchRentalsViewings()
    {
        $this->query = Rentals::find();
        $this->query->select(["COUNT(*) AS number, v.status AS viewingStatus"]);
        $this->query->innerJoin(Viewings::tableName() . ' as v', 'v.ref = rentals.ref');
        $this->query->where(['rentals.company_id' => $this->companyId]);
        $this->query->groupBy(['viewingStatus']);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->getUserViewingsIntervalQuery();
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    public function searchSalesViewings()
    {
        $this->query = Sale::find();
        $this->query->select(["COUNT(*) AS number, v.status AS viewingStatus"]);
        $this->query->innerJoin(Viewings::tableName() . ' as v', 'v.ref = sale.ref');
        $this->query->where(['sale.company_id' => $this->companyId]);
        $this->query->groupBy(['viewingStatus']);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->getUserViewingsIntervalQuery();
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    public function searchRentalsByStatus()
    {
        $this->query = Rentals::find();
        $this->query->select(["COUNT(*) AS number", 'status']);
        $this->query->where(['company_id' => $this->companyId]);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['status']);
        $this->getGroupIntervalQuery('dateadded');
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    public function searchSalesByStatus()
    {
        $this->query = Sale::find();
        $this->query->select(["COUNT(*) AS number", 'status']);
        $this->query->where(['company_id' => $this->companyId]);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['status']);
        $this->getGroupIntervalQuery('dateadded');
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    public function searchRentalsByLocation()
    {
        $this->query = Rentals::find();
        $this->query->select(["COUNT(*) AS number", 'area_location_id']);
        $this->query->where(['company_id' => $this->companyId]);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['area_location_id']);
        $this->getGroupIntervalQuery('dateadded');
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    public function searchRentalsClosedByLocation()
    {
        $this->query = Rentals::find();
        $this->query->select(["COUNT(*) AS number", 'area_location_id']);
        $this->query->where(['company_id' => $this->companyId]);
        $this->query->andWhere(['prop_status' => Rentals::PROPERTY_STATUS_SOLD]);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['area_location_id']);
        $this->getGroupIntervalQuery('dateadded');
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    public function searchSalesByLocation()
    {
        $this->query = Sale::find();
        $this->query->select(["COUNT(*) AS number", 'area_location_id']);
        $this->query->where(['company_id' => $this->companyId]);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['area_location_id']);
        $this->getGroupIntervalQuery('dateadded');
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    public function searchSalesClosedByLocation()
    {
        $this->query = Sale::find();
        $this->query->select(["COUNT(*) AS number", 'area_location_id']);
        $this->query->where(['company_id' => $this->companyId]);
        $this->query->andWhere(['prop_status' => Sale::PROPERTY_STATUS_SOLD]);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['area_location_id']);
        $this->getGroupIntervalQuery('dateadded');
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    public function searchSalesByCategory()
    {
        $this->query = Sale::find();
        $this->query->select(["COUNT(id) AS number", 'category_id']);
        $this->query->where(['company_id' => $this->companyId]);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['category_id']);
        $this->getGroupIntervalQuery('dateadded');
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    public function searchRentalsByCategory()
    {

        $this->query = Rentals::find();
        $this->query->select(["COUNT(id) AS number", 'category_id']);
        $this->query->where(['company_id' => $this->companyId]);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['category_id']);
        $this->getGroupIntervalQuery('dateadded');
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    public function searchLeadsByType()
    {
        $this->query = Leads::find();
        $this->query->select(["COUNT(*) AS number", 'type_id']);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['type_id']);
        $this->getLeadsIntervalQuery();
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    public function searchLeadsByStatus()
    {
        $leads = new Leads();
        $this->query = Leads::find();
        $expr = new Expression("COUNT(id) AS number");
        $this->query->select(['status']);
        $this->query->addSelect($expr);
        $leads->load($this->queryParams);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['status']);
        $this->getLeadsIntervalQuery();
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    public function searchLeadsByViewings()
    {
        $this->query = Leads::find();
        $this->query->select(["COUNT(*) AS number, v.status AS viewingStatus"]);
        $this->query->innerJoin(Viewings::tableName() . ' as v', 'v.ref = leads.reference');
        $this->query->where(['leads.company_id' => $this->companyId]);
        $this->query->groupBy(['viewingStatus']);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->getUserViewingsIntervalQuery();
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    private function getUserViewingsIntervalQuery()
    {
        if ($this->queryParams['total']) {
            $this->params = [
                'totalNumber' => $this->query->sum('number'),
                'totalCount' => $this->query->count(),
                'id' => $this->report->url_id,
                'page' => $this->queryParams['page'],
                'per-page' => $this->queryParams['per-page'],
            ];
        } else if (($this->queryParams['date_from'] && $this->queryParams['date_to']) || $this->report->date_type == Reports::DATE_TYPE_TIME) {
            if ($this->queryParams['date_from'] && $this->queryParams['date_to']) {
                $startDate = strtotime($this->queryParams['date_from']);
                $endDate = strtotime($this->queryParams['date_to']);
            } else {
                $startDate = strtotime($this->report->date_from);
                $endDate = strtotime($this->report->date_to);
            }
            $this->query->where(['>=', 'v.date', $startDate]);
            $this->query->andWhere(['<=', 'v.date', $endDate]);
            $this->params = [
                'totalNumber' => $this->query->sum('number'),
                'totalCount' => $this->query->count(),
                'id' => $this->report->url_id,
                'page' => $this->queryParams['page'],
                'per-page' => $this->queryParams['per-page'],
                'date_from' => $this->queryParams['date_from'],
                'date_to' => $this->queryParams['date_to'],
            ];
        } else {
            $this->query->andWhere(['>=', 'v.date', strtotime(date('Y-m-d') . ' - 3 month')]);
            $this->params = [
                'totalNumber' => $this->query->sum('number'),
                'totalCount' => $this->query->count(),
                'id' => $this->report->url_id,
                'page' => $this->queryParams['page'],
                'per-page' => $this->queryParams['per-page'],
            ];
        }
        return $this->query;
    }

    private function getIntervalQuery($attribute)
    {
        if ($this->queryParams['total']) {
            $this->params = [
                'totalCount' => $this->query->count(),
                'id' => $this->report->url_id,
                'page' => $this->queryParams['page'],
                'per-page' => $this->queryParams['per-page'],
            ];
        } else if (($this->queryParams['date_from'] && $this->queryParams['date_to']) || $this->report->date_type == Reports::DATE_TYPE_TIME) {
            if ($this->queryParams['date_from'] && $this->queryParams['date_to']) {
                $startDate = strtotime($this->queryParams['date_from'] . ' +1 day');
                $endDate = strtotime($this->queryParams['date_to'] . ' +1 day');
            } else {
                $startDate = strtotime($this->report->date_from . ' +1 day');
                $endDate = strtotime($this->report->date_to . ' +1 day');
            }
            $this->query->where(['>=', $attribute , $startDate]);
            $this->query->andWhere(['<=', $attribute, $endDate]);
            $this->params = [
                'totalCount' => $this->query->count(),
                'id' => $this->report->url_id,
                'page' => $this->queryParams['page'],
                'per-page' => $this->queryParams['per-page'],
                'date_from' => $this->queryParams['date_from'],
                'date_to' => $this->queryParams['date_to'],
            ];
        } else {
            $this->query->where(['>=', $attribute, strtotime(date('Y-m-d') . ' - 1 month')]);
            $this->params = [
                'totalCount' => $this->query->count(),
                'id' => $this->report->url_id,
                'page' => $this->queryParams['page'],
                'per-page' => $this->queryParams['per-page'],
            ];
        }
        return $this->query;
    }

    private function getGroupIntervalQuery($attribute)
    {
        if ($this->queryParams['total']) {
            $this->params = [
                'totalNumber' => $this->query->sum('number'),
                'totalCount' => $this->query->count(),
                'id' => $this->report->url_id,
                'page' => $this->queryParams['page'],
                'per-page' => $this->queryParams['per-page'],
            ];
        } else if (($this->queryParams['date_from'] && $this->queryParams['date_to']) || $this->report->date_type == Reports::DATE_TYPE_TIME) {
            if ($this->queryParams['date_from'] && $this->queryParams['date_to']) {
                $startDate = date('Y-m-d', strtotime($this->queryParams['date_from'] . ' +1 day'));
                $endDate = date('Y-m-d', strtotime($this->queryParams['date_to'] . ' +1 day'));
            } else {
                $startDate = date('Y-m-d', strtotime($this->report->date_from . ' +1 day'));
                $endDate = date('Y-m-d', strtotime($this->report->date_to . ' +1 day'));
            }
            $this->query->where(['>=', $attribute , $startDate]);
            $this->query->andWhere(['<=', $attribute, $endDate]);
            $this->params = [
                'totalNumber' => $this->query->sum('number'),
                'totalCount' => $this->query->count(),
                'id' => $this->report->url_id,
                'page' => $this->queryParams['page'],
                'per-page' => $this->queryParams['per-page'],
                'date_from' => $this->queryParams['date_from'],
                'date_to' => $this->queryParams['date_to'],
            ];
        } else {
            //$this->query->where(['>=', $attribute, strtotime(date('Y-m-d') . ' - 1 month')]);
            //$this->query->andWhere(['<=', $attribute, strtotime(date('Y-m-d'))]);
            $this->params = [
                'totalNumber' => $this->query->sum('number'),
                'totalCount' => $this->query->count(),
                'id' => $this->report->url_id,
                'page' => $this->queryParams['page'],
                'per-page' => $this->queryParams['per-page'],
            ];
        }
        return $this->query;
    }

    private function getTasksIntervalQuery($attribute)
    {
        if ($this->queryParams['total']) {
            $this->params = [
                'totalNumber' => $this->query->sum('number'),
                'totalCount' => $this->query->count(),
                'id' => $this->report->url_id,
                'page' => $this->queryParams['page'],
                'per-page' => $this->queryParams['per-page'],
            ];
        } else if (($this->queryParams['date_from'] && $this->queryParams['date_to']) || $this->report->date_type == Reports::DATE_TYPE_TIME) {
            if ($this->queryParams['date_from'] && $this->queryParams['date_to']) {
                $startDate = strtotime($this->queryParams['date_from'] . ' +1 day');
                $endDate = strtotime($this->queryParams['date_to'] . ' +1 day');
            } else {
                $startDate = strtotime($this->report->date_from . ' +1 day');
                $endDate = strtotime($this->report->date_to . ' +1 day');
            }
            $this->query->where(['>=', $attribute , $startDate]);
            $this->query->andWhere(['<=', $attribute, $endDate]);
            $this->params = [
                'totalNumber' => $this->query->sum('number'),
                'totalCount' => $this->query->count(),
                'id' => $this->report->url_id,
                'page' => $this->queryParams['page'],
                'per-page' => $this->queryParams['per-page'],
                'date_from' => $this->queryParams['date_from'],
                'date_to' => $this->queryParams['date_to'],
            ];
        } else {
            $this->params = [
                'totalNumber' => $this->query->sum('number'),
                'totalCount' => $this->query->count(),
                'id' => $this->report->url_id,
                'page' => $this->queryParams['page'],
                'per-page' => $this->queryParams['per-page'],
            ];
        }
        return $this->query;
    }

    private function getLeadsIntervalQuery()
    {
        if ($this->queryParams['total']) {
            $this->params = [
                'totalNumber' => $this->query->sum('number'),
                'totalCount' => $this->query->count(),
                'id' => $this->report->url_id,
                'page' => $this->queryParams['page'],
                'per-page' => $this->queryParams['per-page'],
            ];
        } else if (($this->queryParams['date_from'] && $this->queryParams['date_to']) || $this->report->date_type == Reports::DATE_TYPE_TIME) {
            if ($this->queryParams['date_from'] && $this->queryParams['date_to']) {
                $startDate = strtotime($this->queryParams['date_from'] . ' +1 day');
                $endDate = strtotime($this->queryParams['date_to'] . ' +1 day');
            } else {
                $startDate = strtotime($this->report->date_from);
                $endDate = strtotime($this->report->date_to);
            }
            $this->query->where(['>=', 'created_at', $startDate]);
            $this->query->andWhere(['<=', 'created_at', $endDate]);
            $this->params = [
                'totalNumber' => $this->query->sum('number'),
                'totalCount' => $this->query->count(),
                'id' => $this->report->url_id,
                'page' => $this->queryParams['page'],
                'per-page' => $this->queryParams['per-page'],
                'date_from' => $this->queryParams['date_from'],
                'date_to' => $this->queryParams['date_to'],
            ];
        } else {
            //$this->query->where(['>=', 'UNIX_TIMESTAMP(date_time_start)', strtotime(date('Y-m-d') . ' - 1 month')]);
            //$this->query->andWhere(['<=', 'UNIX_TIMESTAMP(date_time_start)', strtotime(date('Y-m-d'))]);
            $this->params = [
                'totalNumber' => $this->query->sum('number'),
                'totalCount' => $this->query->count(),
                'id' => $this->report->url_id,
                'page' => $this->queryParams['page'],
                'per-page' => $this->queryParams['per-page'],
            ];
        }
        return $this->query;
    }

    private function getLeadsAgentContactIntervalQuery()
    {
        if ($this->queryParams['total']) {
            $this->params = [
                'totalNumber' => $this->query->sum('number'),
                'totalCount' => $this->query->count(),
                'id' => $this->report->url_id,
                'page' => $this->queryParams['page'],
                'per-page' => $this->queryParams['per-page'],
            ];
        } else if (($this->queryParams['date_from'] && $this->queryParams['date_to']) || $this->report->date_type == Reports::DATE_TYPE_TIME) {
            if ($this->queryParams['date_from'] && $this->queryParams['date_to']) {
                $startDate = strtotime($this->queryParams['date_from'] . ' +1 day');
                $endDate = strtotime($this->queryParams['date_to'] . ' +1 day');
            } else {
                $startDate = strtotime($this->report->date_from);
                $endDate = strtotime($this->report->date_to);
            }
            $this->query->where(['>=', 'la.created_at', $startDate]);
            $this->query->andWhere(['<=', 'la.created_at', $endDate]);
            $this->params = [
                'totalNumber' => $this->query->sum('number'),
                'totalCount' => $this->query->count(),
                'id' => $this->report->url_id,
                'page' => $this->queryParams['page'],
                'per-page' => $this->queryParams['per-page'],
                'date_from' => $this->queryParams['date_from'],
                'date_to' => $this->queryParams['date_to'],
            ];
        } else {
            $this->params = [
                'totalNumber' => $this->query->sum('number'),
                'totalCount' => $this->query->count(),
                'id' => $this->report->url_id,
                'page' => $this->queryParams['page'],
                'per-page' => $this->queryParams['per-page'],
            ];
        }
        return $this->query;
    }

    private function getAgentsIntervalQuery()
    {
        if ($this->queryParams['total']) {
            $this->params = [
                'totalNumber' => $this->query->sum('number'),
                'totalCount' => $this->query->count(),
                'id' => $this->report->url_id,
                'page' => $this->queryParams['page'],
                'per-page' => $this->queryParams['per-page'],
            ];
        } else if (($this->queryParams['date_from'] && $this->queryParams['date_to']) || $this->report->date_type == Reports::DATE_TYPE_TIME) {
            if ($this->queryParams['date_from'] && $this->queryParams['date_to']) {
                $startDate = strtotime($this->queryParams['date_from']);
                $endDate = strtotime($this->queryParams['date_to']);
            } else {
                $startDate = strtotime($this->report->date_from);
                $endDate = strtotime($this->report->date_to);
            }
            $this->query->where(['>=', 'leads.created_at', $startDate]);
            $this->query->andWhere(['<=', 'leads.created_at', $endDate]);
            $this->params = [
                'totalNumber' => $this->query->sum('number'),
                'totalCount' => $this->query->count(),
                'id' => $this->report->url_id,
                'page' => $this->queryParams['page'],
                'per-page' => $this->queryParams['per-page'],
                'date_from' => $this->queryParams['date_from'],
                'date_to' => $this->queryParams['date_to'],
            ];
        } else {
            $this->query->andWhere(['>=', 'leads.created_at', strtotime(date('Y-m-d') . ' - 3 month')]);
            $this->params = [
                'totalNumber' => $this->query->sum('number'),
                'totalCount' => $this->query->count(),
                'id' => $this->report->url_id,
                'page' => $this->queryParams['page'],
                'per-page' => $this->queryParams['per-page'],
            ];
        }

        return $this->query;
    }

    /**
     * @param int/null $companyId
     * @return ReportsSearch
     */
    public function setCompanyId($companyId) : self
    {
        $this->companyId = $companyId;
        return $this;
    }

    public function searchAgentLeaderBoard()
    {
        $this->query = User::find();
        $this->query->select(["COUNT(*) AS number", 'user.username']);
        $this->query->innerJoin('lead_agent', 'lead_agent.user_id = user.id');
        $this->query->innerJoin('leads', 'leads.id = lead_agent.lead_id');
        $this->query->andWhere(['user.company_id' => $this->companyId]);
        $this->query->groupBy(['user.id']);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->getAgentsIntervalQuery();
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    public function searchAgentLeaderBoardSales()
    {
        $this->query = Sale::find();
        $this->query->select(["COUNT(*) AS number", 'agent_id']);
        $this->query->where(['company_id' => $this->companyId]);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['agent_id']);
        $this->query->limit(5);
        $this->getGroupIntervalQuery('dateadded');
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    public function searchAgentLeaderBoardRentals()
    {
        $this->query = Rentals::find();
        $this->query->select(["COUNT(*) AS number", 'agent_id']);
        $this->query->where(['company_id' => $this->companyId]);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['agent_id']);
        $this->query->limit(5);
        $this->getGroupIntervalQuery('dateadded');
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    /**
     * @param string $status
     * @return ActiveDataProvider
     */
    public function searchSalesByAgents($status = Sale::STATUS_PUBLISHED) : ActiveDataProvider
    {
        $this->query = Sale::find();
        $this->query->select(["COUNT(*) AS number", 'agent_id']);
        $this->query->where(['company_id' => $this->companyId, 'status' => $status]);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['agent_id']);
        $this->getGroupIntervalQuery('dateadded');
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    /**
     * @return ActiveDataProvider
     */
    public function searchSalesByAgentsNumbersProperties() : ActiveDataProvider
    {
        $this->query = Sale::find();
        $this->query->select(["COUNT(*) AS number", 'agent_id']);
        $this->query->where(['company_id' => $this->companyId]);
        $this->query->andWhere(['prop_status' => Sale::PROPERTY_STATUS_SOLD]);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['agent_id']);
        $this->getGroupIntervalQuery('dateadded');
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    /**
     * @return ActiveDataProvider
     */
    public function searchSalesByAgentsAED() : ActiveDataProvider
    {
        $this->query = Sale::find();
        $this->query->select(["COUNT(*) AS number", 'SUM(price) AS priceCommon', 'agent_id']);
        $this->query->where(['company_id' => $this->companyId]);
        $this->query->andWhere(['prop_status' => Sale::PROPERTY_STATUS_SOLD]);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['agent_id']);
        $this->getGroupIntervalQuery('dateadded');
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    /**
     * @param string $status
     * @return ActiveDataProvider
     */
    public function searchRentalsByAgents($status = Rentals::STATUS_PUBLISHED) : ActiveDataProvider
    {
        $this->query = Rentals::find();
        $this->query->select(["COUNT(*) AS number", 'agent_id']);
        $this->query->where(['company_id' => $this->companyId, 'status' => $status]);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['agent_id']);
        $this->getGroupIntervalQuery('dateadded');
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    /**
     * @return ActiveDataProvider
     */
    public function searchRentalsByAgentsNumbersProperties() : ActiveDataProvider
    {
        $this->query = Rentals::find();
        $this->query->select(["COUNT(*) AS number", 'agent_id']);
        $this->query->where(['company_id' => $this->companyId]);
        $this->query->andWhere(['prop_status' => Rentals::PROPERTY_STATUS_SOLD]);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['agent_id']);
        $this->getGroupIntervalQuery('dateadded');
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    /**
     * @return ActiveDataProvider
     */
    public function searchRentalsByAgentsAED() : ActiveDataProvider
    {
        $this->query = Rentals::find();
        $this->query->select(["COUNT(*) AS number", 'SUM(price) AS priceCommon', 'agent_id']);
        $this->query->where(['company_id' => $this->companyId]);
        $this->query->andWhere(['prop_status' => Rentals::PROPERTY_STATUS_SOLD]);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['agent_id']);
        $this->getGroupIntervalQuery('dateadded');
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    /**
     * @return ActiveDataProvider
     */
    public function searchLeadsByAgents() : ActiveDataProvider
    {
        $leads = new Leads();
        $this->query = Leads::find();
        $expr = new Expression("COUNT(id) AS number");
        $this->query->select(['agent_1']);
        $this->query->addSelect($expr);
        $leads->load($this->queryParams);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['agent_1']);
        $this->getLeadsIntervalQuery();
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    /**
     * @return ActiveDataProvider
     */
    public function searchLeadsByProperty() : ActiveDataProvider
    {
        $this->query = Leads::find();
        $this->query->select(["COUNT(*) AS number", 'pc.title as categoryTitle']);
        $this->query->innerJoin(PropertyRequirement::tableName() . ' as pr', 'pr.lead_id = leads.id');
        $this->query->innerJoin(PropertyCategory::tableName() . ' as pc', 'pc.id = pr.category_id');
        $this->query->where(['leads.company_id' => $this->companyId]);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['pr.category_id']);
        $this->getLeadsIntervalQuery();
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    /**
     * @return ActiveDataProvider
     */
    public function searchLeadsBySource() : ActiveDataProvider
    {
        $this->query = Leads::find();
        $this->query->select(["COUNT(*) AS number", "source"]);
        $this->query->where(['company_id' => $this->companyId]);
        $this->query->andWhere(['!=', 'source', 0]);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['source']);
        $this->getLeadsIntervalQuery();
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    /**
     * @return ActiveDataProvider
     */
    public function searchByOpenLeads() : ActiveDataProvider
    {
        $query1 = Leads::find();
        $query1->select(["COUNT(*) AS number"]);
        $query1->where(['company_id' => $this->companyId]);
        $query1->andWhere('reference IN (SELECT DISTINCT(ref) FROM '. Note::tableName() . ')');
        $query1->andWhere(['status' => Leads::STATUS_OPEN]);

        $query2 = Leads::find();
        $query2->select(["COUNT(*) AS number"]);
        $query2->leftJoin(Note::tableName() . ' as n', 'leads.reference = n.ref');
        $query2->where(['leads.company_id' => $this->companyId]);
        $query2->andWhere('n.id IS NULL');
        $query2->andWhere(['leads.status' => Leads::STATUS_OPEN]);;

        $this->query = $query2->union($query1);

        $this->getLeadsIntervalQuery();
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    /**
     * @return ActiveDataProvider
     */
    public function searchByAgentContactInterval() : ActiveDataProvider
    {
        $this->query = Leads::find();
        $this->query->select(['COUNT(*) AS number', 'ABS(DATEDIFF(n.date, FROM_UNIXTIME(la.created_at))) AS agentContactIntervalDays, leads.reference, agent.username AS noteAgentName']);
        $this->query->innerJoin(LeadAgent::tableName() . ' as la', 'la.lead_id = leads.id');
        $this->query->innerJoin(Note::tableName() . ' as n', 'n.ref = leads.reference');
        $this->query->innerJoin(User::tableName() . ' as agent', 'n.user_id = agent.id');
        $this->query->where(['leads.company_id' => $this->companyId]);
        $this->query->andWhere('la.user_id = n.user_id');
        $this->query->groupBy(['leads.id', 'n.user_id']);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);

        $this->getLeadsAgentContactIntervalQuery();
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    /**
     * @return ActiveDataProvider
     */
    public function searchByAgentContactNumber() : ActiveDataProvider
    {
        $this->query = Leads::find();
        $this->query->select(['COUNT(*) AS number', 'leads.reference', 'agent.username AS noteAgentName']);
        $this->query->innerJoin(LeadAgent::tableName() . ' as la', 'la.lead_id = leads.id');
        $this->query->innerJoin(Note::tableName() . ' as n', 'n.ref = leads.reference');
        $this->query->innerJoin(User::tableName() . ' as agent', 'n.user_id = agent.id');
        $this->query->where(['leads.company_id' => $this->companyId]);
        $this->query->andWhere('la.user_id = n.user_id');
        $this->query->groupBy(['leads.id', 'n.user_id']);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);

        $this->getLeadsAgentContactIntervalQuery();
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    public function searchLeadsByLocation()
    {
        $this->query = Leads::find();
        $this->query->select(["COUNT(*) AS number", 'l.name AS propertyLocationName']);
        $this->query->innerJoin(PropertyRequirement::tableName() . ' as pr', 'pr.lead_id = leads.id');
        $this->query->innerJoin(Locations::tableName() . ' as l', 'l.id = pr.location');
        $this->query->where(['leads.company_id' => $this->companyId]);
        $this->query->orderBy([
            'number' => SORT_DESC,
        ]);
        $this->query->groupBy(['pr.location']);
        $this->getLeadsIntervalQuery();
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => ($this->email) ? $this->query->count() : $this->pageSize,
                'params' => $this->params
            ]
        ]);
        if ($this->email)
            $dataProvider->sort = false;
        return $dataProvider;
    }

    public function getDashboardChartPath()
    {
        return $this->dashboardChartPath;
    }
}