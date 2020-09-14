<?php

use app\modules\reports\models\Reports;

$viewsPath = '@app/modules/reports/views/main/reports/';

switch ($report->type) {
    case Reports::LEAD_TYPE:
        echo $this->render($viewsPath . 'leads/pdf/_leads_by_type', ['data' => $data, 'report' => $report, 'user' => $user]);
        break;
    case Reports::LEAD_STATUS:
        echo $this->render($viewsPath . 'leads/pdf/_leads_by_status', ['data' => $data, 'report' => $report, 'user' => $user]);
        break;
    case Reports::LEAD_VIEWINGS:
        echo $this->render($viewsPath . 'leads/pdf/_leads_by_viewings', ['data' => $data, 'report' => $report, 'user' => $user]);
        break;
}
