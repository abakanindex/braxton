<?php

namespace app\modules\reports\models\search;

use app\models\Leads;
use app\models\Rentals;
use app\models\Sale;
use app\models\TaskManager;
use app\models\UserViewing;
use app\modules\reports\models\Reports;

class ReportsWidgetChartSearch
{

    public $report;
    public $startDate;
    public $endDate;

    public function getReportData($report)
    {
        $data = [];
        $this->report = $report;
        if ($this->report->date_type == Reports::DATE_TYPE_TIME) {
            $this->startDate = strtotime($this->report->date_from . ' +1 day');
            $this->endDate = strtotime($this->report->date_to . ' +1 day');
        }
        switch ($this->report->type) {
            case Reports::LEAD_TYPE:
                $data = $this->searchLeadsByType();
                break;
            case Reports::LEAD_STATUS:
                $data = $this->searchLeadsByStatus();
                break;
            case Reports::LEAD_VIEWINGS:
                $data = $this->searchLeadsByViewings();
                break;
            case Reports::SALES_CATEGORY:
                $data = $this->searchSalesByCategory();
                break;
            case Reports::RENTALS_CATEGORY:
                $data = $this->searchRentalsByCategory();
                break;
            case Reports::SALES_LOCATION:
                $data = $this->searchSalesByLocation();
                break;
            case Reports::RENTALS_LOCATION:
                $data = $this->searchRentalsByLocation();
                break;
            case Reports::SALES_STATUS:
                $data = $this->searchSalesByStatus();
                break;
            case Reports::RENTALS_STATUS:
                $data = $this->searchRentalsByStatus();
                break;
            case Reports::SALES_VIEWINGS_REPORT:
                $data = $this->searchSalesViewings();
                break;
            case Reports::RENTALS_VIEWINGS_REPORT:
                $data = $this->searchRentalsViewings();
                break;
            case Reports::TASKS_PRIORITY_REPORT:
                $data = $this->searchTasksByPriority();
                break;
        }
        return $data;
    }

    public function searchTasksByPriority()
    {
        $query = TaskManager::find();
        if ($this->report->date_type == Reports::DATE_TYPE_TIME) {
            $query->where(['>=', 'created_at', $this->startDate]);
            $query->andWhere(['<=', 'created_at', $this->endDate]);
        }
        $query->select(["COUNT(`id`) AS number", 'priority']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $query->groupBy(['priority']);
        $query->andWhere(['IS NOT', 'priority', null]);
        $tasks = $query->asArray()->all();
        $data = [];
        foreach ($tasks as $task) {
            $taskWithPriorities = [];
            $taskWithPriorities['priority'] = TaskManager::findPriority($task['priority']);
            $taskWithPriorities['number'] = $task['number'];
            $data[] = $taskWithPriorities;
        }
        return ['attribute' => 'priority', 'data' => $data];
    }

    public function searchRentalsViewings()
    {
        $query = Rentals::find();
        $query->select(["COUNT(user_viewing.id) AS number", 'ref']);
        $query->join('LEFT JOIN', 'user_viewing', 'user_viewing.model_id = rentals.id AND user_viewing.type = ' . UserViewing::TYPE_RENTAL);
        if ($this->report->date_type == Reports::DATE_TYPE_TIME) {
            $query->where(['>=', 'user_viewing.created_at', $this->startDate]);
            $query->andWhere(['<=', 'user_viewing.created_at', $this->endDate]);
        }
        $query->andWhere(['IS NOT', 'user_viewing.id', null]);
        $query->groupBy(['rentals.id']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $data = $query->asArray()->all();
        return ['attribute' => 'ref', 'data' => $data];
    }

    public function searchSalesViewings()
    {
        $query = Sale::find();
        $query->select(["COUNT(user_viewing.id) AS number", 'ref']);
        $query->join('LEFT JOIN', 'user_viewing', 'user_viewing.model_id = sale.id AND user_viewing.type = ' . UserViewing::TYPE_SALE);
        if ($this->report->date_type == Reports::DATE_TYPE_TIME) {
            $query->where(['>=', 'user_viewing.created_at', $this->startDate]);
            $query->andWhere(['<=', 'user_viewing.created_at', $this->endDate]);
        }
        $query->andWhere(['IS NOT', 'user_viewing.id', null]);
        $query->groupBy(['sale.id']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $data = $query->asArray()->all();
        return ['attribute' => 'ref', 'data' => $data];
    }

    public function searchRentalsByStatus()
    {
        $query = Rentals::find();
        if ($this->report->date_type == Reports::DATE_TYPE_TIME) {
            $query->where(['>=', 'rented_at', $this->startDate]);
            $query->andWhere(['<=', 'rented_at', $this->endDate]);
        }
        $query->select(["COUNT(`id`) AS number", 'status']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $query->groupBy(['status']);
        $query->andWhere(['IS NOT', 'status', null]);
        $data = $query->asArray()->all();
        return ['attribute' => 'status', 'data' => $data];
    }

    public function searchSalesByStatus()
    {
        $query = Sale::find();
        if ($this->report->date_type == Reports::DATE_TYPE_TIME) {
            $query->where(['>=', 'rented_at', $this->startDate]);
            $query->andWhere(['<=', 'rented_at', $this->endDate]);
        }
        $query->select(["COUNT(`id`) AS number", 'status']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $query->groupBy(['status']);
        $query->andWhere(['IS NOT', 'status', null]);
        $data = $query->asArray()->all();
        return ['attribute' => 'status', 'data' => $data];
    }

    public function searchRentalsByLocation()
    {
        $query = Rentals::find();
        if ($this->report->date_type == Reports::DATE_TYPE_TIME) {
            $query->where(['>=', 'rented_at', $this->startDate]);
            $query->andWhere(['<=', 'rented_at', $this->endDate]);
        }
        $query->select(["COUNT(`id`) AS number", 'location']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $query->groupBy(['location']);
        $query->andWhere(['IS NOT', 'location', null]);
        $data = $query->asArray()->all();
        return ['attribute' => 'location', 'data' => $data];
    }

    public function searchSalesByLocation()
    {
        $query = Sale::find();
        if ($this->report->date_type == Reports::DATE_TYPE_TIME) {
            $query->where(['>=', 'rented_at', $this->startDate]);
            $query->andWhere(['<=', 'rented_at', $this->endDate]);
        }
        $query->select(["COUNT(`id`) AS number", 'location']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $query->groupBy(['location']);
        $query->andWhere(['IS NOT', 'location', null]);
        $data = $query->asArray()->all();
        return ['attribute' => 'location', 'data' => $data];
    }

    public function searchSalesByCategory()
    {
        $query = Sale::find();
        if ($this->report->date_type == Reports::DATE_TYPE_TIME) {
            $query->where(['>=', 'rented_at', $this->startDate]);
            $query->andWhere(['<=', 'rented_at', $this->endDate]);
        }
        $query->select(["COUNT(`id`) AS number", 'category']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $query->groupBy(['category']);
        $query->andWhere(['IS NOT', 'category', null]);
        $data = $query->asArray()->all();
        return ['attribute' => 'category', 'data' => $data];
    }

    public function searchRentalsByCategory()
    {
        $query = Rentals::find();
        if ($this->report->date_type == Reports::DATE_TYPE_TIME) {
            $query->where(['>=', 'rented_at', $this->startDate]);
            $query->andWhere(['<=', 'rented_at', $this->endDate]);
        }
        $query->select(["COUNT(`id`) AS number", 'category']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $query->groupBy(['category']);
        $query->andWhere(['IS NOT', 'category', null]);
        $data = $query->asArray()->all();
        return ['attribute' => 'category', 'data' => $data];
    }

    public function searchLeadsByStatus()
    {
        $query = Leads::find();
        if ($this->report->date_type == Reports::DATE_TYPE_TIME) {
            $query->where(['>=', 'UNIX_TIMESTAMP(date_time_start)', $this->startDate]);
            $query->andWhere(['<=', 'UNIX_TIMESTAMP(date_time_start)', $this->endDate]);
        }
        $query->select(["COUNT(`status`) AS number", 'status']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $query->groupBy(['status']);
        $query->andWhere(['IS NOT', 'status', null]);
        $data = $query->asArray()->all();
        return ['attribute' => 'status', 'data' => $data];
    }

    public function searchLeadsByType()
    {
        $query = Leads::find();
        if ($this->report->date_type == Reports::DATE_TYPE_TIME) {
            $query->where(['>=', 'UNIX_TIMESTAMP(date_time_start)', $this->startDate]);
            $query->andWhere(['<=', 'UNIX_TIMESTAMP(date_time_start)', $this->endDate]);
        }
        $query->select(["COUNT(`lead_type`) AS number", 'lead_type']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $query->groupBy(['lead_type']);
        $query->andWhere(['IS NOT', 'lead_type', null]);
        $leads = $query->asArray()->all();
        $data = [];
        foreach ($leads as $lead) {
            $leadWithType = [];
            $leadWithType['type'] = Leads::findType($lead['lead_type']);
            $leadWithType['number'] = $lead['number'];
            $data[] = $leadWithType;
        }
        return ['attribute' => 'type', 'data' => $data];
    }

    public function searchLeadsByViewings()
    {
        $query = Leads::find();
        $query->select(["COUNT(user_viewing.id) AS number", 'agent']);
        $query->join('LEFT JOIN', 'user_viewing', 'user_viewing.model_id = leads.id AND user_viewing.type = ' . UserViewing::TYPE_LEAD);
        if ($this->report->date_type == Reports::DATE_TYPE_TIME) {
            $query->where(['>=', 'user_viewing.created_at', $this->startDate]);
            $query->andWhere(['<=', 'user_viewing.created_at', $this->endDate]);
        }
        $query->andWhere(['IS NOT', 'user_viewing.id', null]);
        $query->groupBy(['leads.id']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $data = $query->asArray()->all();
        return ['attribute' => 'agent', 'data' => $data];
    }
}