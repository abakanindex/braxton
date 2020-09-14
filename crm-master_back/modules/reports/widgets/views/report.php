<?php use app\modules\reports\models\Reports;

$viewsPath = '@app/modules/reports/widgets/views/reports/';

switch ($report->type) {
    case Reports::LEAD_TYPE:
        echo $this->render($viewsPath . 'leads/_leads_by_type', ['report' => $report, 'dashboardWidget' => $dashboardWidget, 'provider' => $provider]);
        break;
    case Reports::LEAD_STATUS:
        echo $this->render($viewsPath . 'leads/_leads_by_status', ['report' => $report, 'dashboardWidget' => $dashboardWidget, 'provider' => $provider]);
        break;
    case Reports::LEAD_VIEWINGS:
        echo $this->render($viewsPath . 'leads/_leads_by_viewings', ['report' => $report, 'dashboardWidget' => $dashboardWidget, 'provider' => $provider]);
        break;
    case Reports::SALES_CATEGORY:
        echo $this->render($viewsPath . 'listings/_sales_by_category', ['report' => $report, 'dashboardWidget' => $dashboardWidget, 'provider' => $provider]);
        break;
    case Reports::RENTALS_CATEGORY:
        echo $this->render($viewsPath . 'listings/_rentals_by_category', ['report' => $report, 'dashboardWidget' => $dashboardWidget, 'provider' => $provider]);
        break;
    case Reports::SALES_LOCATION:
        echo $this->render($viewsPath . 'listings/_sales_by_location', ['report' => $report, 'dashboardWidget' => $dashboardWidget, 'provider' => $provider]);
        break;
    case Reports::RENTALS_LOCATION:
        echo $this->render($viewsPath . 'listings/_rentals_by_location', ['report' => $report, 'dashboardWidget' => $dashboardWidget, 'provider' => $provider]);
        break;
    case Reports::SALES_STATUS:
        echo $this->render($viewsPath . 'listings/_sales_by_status', ['report' => $report, 'dashboardWidget' => $dashboardWidget, 'provider' => $provider]);
        break;
    case Reports::RENTALS_STATUS:
        echo $this->render($viewsPath . 'listings/_rentals_by_status', ['report' => $report, 'dashboardWidget' => $dashboardWidget, 'provider' => $provider]);
        break;
    case Reports::SALES_VIEWINGS_REPORT:
        echo $this->render($viewsPath . 'listings/_sales_viewings', ['report' => $report, 'dashboardWidget' => $dashboardWidget, 'provider' => $provider]);
        break;
    case Reports::RENTALS_VIEWINGS_REPORT:
        echo $this->render($viewsPath . 'listings/_rentals_viewings', ['report' => $report, 'dashboardWidget' => $dashboardWidget, 'provider' => $provider]);
        break;
    case Reports::TASKS_PRIORITY_REPORT:
        echo $this->render($viewsPath . 'tasks/_tasks_by_priority', ['report' => $report, 'dashboardWidget' => $dashboardWidget, 'provider' => $provider]);
        break;
} ?>