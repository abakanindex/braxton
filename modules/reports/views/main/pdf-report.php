<?php

use app\modules\reports\models\Reports;

$viewsPath = '@app/modules/reports/views/main/reports/';
switch ($report->type) {
    case Reports::LEAD_TYPE:
        echo $this->render($viewsPath . 'leads/pdf/_leads_by_type', ['provider' => $provider, 'report' => $report, 'user' => $user]);
        break;
    case Reports::LEAD_STATUS:
        echo $this->render($viewsPath . 'leads/pdf/_leads_by_status', ['provider' => $provider, 'report' => $report, 'user' => $user]);
        break;
    case Reports::LEAD_VIEWINGS:
        echo $this->render($viewsPath . 'leads/pdf/_leads_by_viewings', ['provider' => $provider, 'report' => $report, 'user' => $user]);
        break;
    case Reports::SALES_CATEGORY:
        echo $this->render($viewsPath . 'listings/pdf/_sales_by_category', ['provider' => $provider, 'report' => $report, 'user' => $user]);
        break;
    case Reports::RENTALS_CATEGORY:
        echo $this->render($viewsPath . 'listings/pdf/_rentals_by_category', ['provider' => $provider, 'report' => $report, 'user' => $user]);
        break;
    case Reports::SALES_LOCATION:
        echo $this->render($viewsPath . 'listings/pdf/_sales_by_location', ['provider' => $provider, 'report' => $report, 'user' => $user]);
        break;
    case Reports::RENTALS_LOCATION:
        echo $this->render($viewsPath . 'listings/pdf/_rentals_by_location', ['provider' => $provider, 'report' => $report, 'user' => $user]);
        break;
    case Reports::SALES_STATUS:
        echo $this->render($viewsPath . 'listings/pdf/_sales_by_status', ['provider' => $provider, 'report' => $report, 'user' => $user]);
        break;
    case Reports::RENTALS_STATUS:
        echo $this->render($viewsPath . 'listings/pdf/_rentals_by_status', ['provider' => $provider, 'report' => $report, 'user' => $user]);
        break;
    case Reports::SALES_VIEWINGS_REPORT:
        echo $this->render($viewsPath . 'listings/pdf/_sales_viewings', ['provider' => $provider, 'report' => $report, 'user' => $user]);
        break;
    case Reports::RENTALS_VIEWINGS_REPORT:
        echo $this->render($viewsPath . 'listings/pdf/_rentals_viewings', ['provider' => $provider, 'report' => $report, 'user' => $user]);
        break;
    case Reports::TASKS_PRIORITY_REPORT:
        echo $this->render($viewsPath . 'tasks/pdf/_tasks_by_priority', ['provider' => $provider, 'report' => $report, 'user' => $user]);
        break;
} ?>