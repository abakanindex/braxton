<?php

namespace app\modules\reports\widgets;

use app\modules\reports\models\Reports;
use app\modules\reports\models\search\ReportsSearch;
use Yii;
use yii\base\Widget;

class ReportWidget extends Widget
{
    public $reportId;
    public $queryParams;
    public $dashboardWidget;

    const TYPE_PIE_CHART = 1;
    const TYPE_TABLE = 2;
    const TYPE_COLUMN_CHART = 3;

    public static function getStandartTypes() {
        return [
            self::TYPE_PIE_CHART => ucwords(Yii::t('app', 'Pie chart')),
            self::TYPE_TABLE => ucwords(Yii::t('app', 'Table')),
            self::TYPE_COLUMN_CHART => ucwords(Yii::t('app', 'Column chart')),
        ];
    }

    public function run()
    {
        $report = Reports::findOne($this->reportId);
        $reportSearch = new ReportsSearch();
        $provider = $reportSearch->getReportData(Yii::$app->request->queryParams, $report);
        return $this->render('report', [
            'report' => $report,
            'dashboardWidget' => $this->dashboardWidget,
            'provider' => $provider
        ]);
    }
}