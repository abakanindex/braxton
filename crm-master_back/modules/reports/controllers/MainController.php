<?php

namespace app\modules\reports\controllers;

use app\models\User;
use app\models\UserViewing;
use app\models\Company;
use app\modules\reports\components\ReportsPdfHelper;
use app\modules\reports\models\DashboardReportOrder;
use app\modules\reports\models\ReportEmail;
use app\modules\reports\models\Reports;
use app\modules\reports\models\search\ReportsSearch;
use app\modules\reports\models\search\ReportsWidgetChartSearch;
use app\modules\reports\models\UserReportsSearch;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;

/**
 * Default controller for the `reports` module
 */
class MainController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'only'  => ['dashboard'],
                'rules' => [
                    [
                        'allow'       => true,
                        'actions'     => ['dashboard'],
                        'permissions' => ['reportsCreate'],
                        'roles'       => ['Owner']
                        
                    ],
                ],
            ],
        ];
    }

    public function actionDashboard()
    {
        $query = Reports::find();
        $query->join('LEFT JOIN', 'user_viewing', '(report.id = user_viewing.model_id AND user_viewing.type = ' . UserViewing::TYPE_REPORT . ')');
        $query->where(['user_viewing.user_id' => Yii::$app->user->id]);
        $query->select(['report.name', 'report.url_id', 'MAX(user_viewing.created_at) as max_created_at']);
        $query->groupBy(['report.id']);
        $query->orderBy(['max_created_at' => SORT_DESC]);

        $recentlyViewedReports = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $query = Reports::find();
        $query->where(['user_id' => Yii::$app->user->id])
            ->orderBy(['id' => SORT_DESC]);
        $recentlySavedReports = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $dashboardWidgets = DashboardReportOrder::find()
        ->innerJoin('report', 'report.id = dashboard_report_order.report_id')
        ->where(['dashboard_report_order.user_id' => Yii::$app->user->id])
        ->orderBy(
            [
                'dashboard_report_order.order'      => SORT_ASC,
                'dashboard_report_order.updated_at' => SORT_DESC
            ]
        )
        ->all();

        $reportSearch = new ReportsSearch();
        $reportSearch->setCompanyId(Company::getCompanyIdBySubdomain());
        $boxes = [];
        foreach ($dashboardWidgets as $k => $widget) {
            $provider = $reportSearch->getReportData(
                ['id' => $widget->report->url_id],
                $widget->report
            );
            $boxes[$k]['view'] = $this->renderPartial(
                $reportSearch->getDashboardChartPath(),
                ['provider' => $provider]
            );
            $boxes[$k]['report'] = $widget->report;
        }

        return $this->render('dashboard', [
            'recentlyViewedReports' => $this->renderPartial('parts/reports-tabs', [
                'idForPjax' => 'recently-viewed-report-listview',
                'dataProvider' => $recentlyViewedReports,
            ]),

            'recentlySavedReports' => $this->renderPartial('parts/reports-tabs', [
                'idForPjax' => 'recently-saved-report-listview',
                'dataProvider' => $recentlySavedReports,
            ]),

            'boxes' => $boxes,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \Exception
     */
    public function actionReport($id)
    {
        $report = Reports::find()->where(['url_id' => $id])->one();
        if (!$report) {
            throw new \Exception('The report with id: ' . $id . ' does not exist!');
        }
        UserViewing::create(UserViewing::TYPE_REPORT, $report->id);
        $reportSearch = new ReportsSearch();
        $reportSearch->setCompanyId(Company::getCompanyIdBySubdomain());
        $provider = $reportSearch->getReportData(Yii::$app->request->queryParams, $report);
        $pdfProvider = $reportSearch->getReportData(Yii::$app->request->queryParams, $report, true);
        $newReport = new Reports();
        $newReport->attributes = $report->attributes;
        $newReport->name = '';
        $newReport->description = '';
        $emailForm = new ReportEmail();
        $user = User::find()->with('userProfile')->where(['id' => Yii::$app->user->id])->one();
        $emailForm->from = $user->email;
        $emailForm->subject = $report->name;
        $emailForm->message = ReportEmail::getDefaultEmailMessage($report, $user);
        $emailForm->attach = true;
        $emailForm->report_id = $report->id;
        $emailForm->user_id = Yii::$app->user->id;
        $emailForm->created_at = time();
        $user = User::find()->with('userProfile')->where(['id' => Yii::$app->user->id])->one();
        return $this->render('report', [
            'report' => $report,
            'provider' => $provider,
            'newReport' => $newReport,
            'emailForm' => $emailForm,
            'user' => $user,
            'pdfProvider' => $pdfProvider
        ]);
    }

    public function actionCreateReport()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new Reports();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->menu_item = Reports::MENU_ITEM_NOT;
            $model->url_id = $model->generateUniqueRandomString('url_id', 11);
            $model->created_at = time();
            if ($model->save()) {
                return ['result' => 'success', 'name' => $model->name];
            } else return ['result' => 'error'];
        } else
            return ['result' => 'error'];
    }

    public function actionValidateReport()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new Reports();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
//            $model->name = $model->generateUniqueRandomString('name', 20);
            return ActiveForm::validate($model);
            Yii::$app->end();
        }
    }

    public function actionValidateEmail()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new ReportEmail();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            return ActiveForm::validate($model);
            Yii::$app->end();
        }
    }

    public function actionSendEmail()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result = 'error';
        $model = new ReportEmail();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $report = Reports::findOne($model->report_id);
            $reportSearch = new ReportsSearch();
            $data = $reportSearch->getReportData(Yii::$app->request->queryParams, $report, true);
            $user = User::find()->with('userProfile')->where(['id' => Yii::$app->user->id])->one();
            $pdf = new ReportsPdfHelper();
            $pdfFile = $pdf->render($report->url_id);
            $path = Yii::getAlias('@runtime/reports-pdf/tmp/') . $pdfFile;
            if ($model->save()) {
                if ($model->sendReportEmail($path)) {
                    $result = 'success';
                }
            }
        }
        return ['result' => $result];
    }

    public function actionSavedReports($report_type)
    {
        $searchModel = new UserReportsSearch();
        $searchModel->type = $report_type;
        $typeTitle = Reports::getTypeTitle($report_type);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('saved-reports', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'typeTitle' => $typeTitle
        ]);
    }

    public function actionSaveReportPdf($urlId)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $pdf = new ReportsPdfHelper();
        $pdfFile = $pdf->render($urlId);
        $dir = Yii::getAlias('@uploads') . '/reports-pdf/tmp';
        if (!is_dir($dir)) {
            $status = mkdir($dir, 0777, true);
        }
        if (!$status) {
            throw new InvalidConfigException("Could not create the folder '{$dir}' in '\$tempPath' set.");
        }
        rename(Yii::getAlias('@runtime/reports-pdf/tmp/') . $pdfFile, $dir . '/' . $pdfFile);
        return ['result' => 'success', 'pdfFile' => $pdfFile];
    }

    public function actionPdfReport($urlId)
    {
        $this->layout = 'pdfReport';
        $report = Reports::find()->where(['url_id' => $urlId])->one();
        $reportSearch = new ReportsSearch();
        $provider = $reportSearch->getReportData(Yii::$app->request->queryParams, $report, true);
        $user = User::find()->with('userProfile')->where(['id' => Yii::$app->user->id])->one();
        return $this->render('pdf-report', [
            'report' => $report,
            'provider' => $provider,
            'user' => $user,
        ]);
    }

    public function actionDownloadPdfReport($urlId)
    {
        $pdf = new ReportsPdfHelper();
        $pdfFile = $pdf->render($urlId);
        $file = Yii::getAlias('@runtime/reports-pdf/tmp/') . $pdfFile;
        if (file_exists($file)) {
            Yii::$app->response->sendFile($file, 'Summary.pdf');
        }
    }

    public function actionCharts($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $report = Reports::find()->where(['url_id' => $id])->one();
        $reportWidgetChartSearch = new ReportsWidgetChartSearch();
        $data = $reportWidgetChartSearch->getReportData($report);
        return $data;
    }

    public function actionDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Reports::deleteAll(['url_id' => $id]))
            return ['result' => 'success'];
        else
            return ['result' => 'error'];
    }
}
