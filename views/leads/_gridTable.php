<?php
use app\models\Company;
use app\models\Leads;
use app\models\reference_books\PropertyCategory;
use app\models\reference_books\ContactSource;
use app\models\User;
use app\models\UserProfile;
use app\modules\lead\models\CompanySource;
use app\modules\lead\models\LeadSubStatus;
use app\modules\lead\models\LeadType;
use kartik\grid\GridView;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\Breadcrumbs;
use yii;

$origins = Leads::$origins;
$types = ArrayHelper::map(LeadType::find()->asArray()->all(), 'id', 'title');
$subStatuses = ArrayHelper::map(LeadSubStatus::find()->asArray()->all(), 'id', 'title');
$sources = ArrayHelper::map(ContactSource::find()->where([])->asArray()->all(), 'id', 'source');
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'layout' => "{items}\n{pager}",
    'tableOptions' => [
        'class' => 'table table-bordered listings_row',
        'id' => 'full-listing-table'
    ],
    'rowOptions'   => function ($model, $key, $index, $grid) use ($urlView) {
            $url = Yii::$app->getUrlManager()->createUrl([
                $urlView,
                'id' => $model['id']
            ]);
            $url = $url.'?page=' .
                (empty(Yii::$app->request->get('page')) ? '1' : Yii::$app->request->get('page'));

            return [
                'data-url'    =>  $url,
                'class'       => 'full-listing-table-row'
            ];
        },
    'columns' => array_merge([
        /*['class' => 'yii\grid\SerialColumn'],*/
        [
            'class'    => 'yii\grid\CheckboxColumn',
            'cssClass' => 'check-column-in-grid',
            'contentOptions' => ['class' => 'check-box-column']
        ],
        [
            'class'  => 'yii\grid\ActionColumn',
            'buttons'=>[
                'view' => function ($url, $model) use ($urlView, $topModel) {
                        $url = Yii::$app->getUrlManager()->createUrl([
                            $urlView,
                            'id'   => $model['id'],
                        ]);
                        return \yii\helpers\Html::a(
                            ($topModel->id == $model['id']) ? '<i class="fa fa-eye active"></i>' : '<i class="fa fa-eye"></i>',
                            $url.'?page=' .
                            (empty(Yii::$app->request->get('page')) ? '1' : Yii::$app->request->get('page')),
                            [
                                'title'     => Yii::t('app', 'View'),
                                'data-pjax' => '1',
                                'pjax'      => '#result',
                                'class'     => 'view-contact'
                            ]
                        );
                    }
            ],
            'template'=>'{view}',
        ],
        [
            'attribute' => 'source',
            'value' => function($model) use ($sources) {
                    return $sources[$model->source];
                },
            'filter' => Html::activeDropDownList($searchModel,
                    'source',
                    $sources,
                    ['class' => 'form-control', 'prompt' => '']
                ),
        ],
        [
            'attribute' => 'origin',
            'value' => function($model) use ($origins) {
                return $origins[$model->origin];
            },
            'filter' => Html::activeDropDownList($searchModel,
                'origin',
                $origins,
                ['class' => 'form-control', 'prompt' => '']
            ),
        ],
        [
            'attribute' => 'reference',
            'format' => 'raw',
            'value' => function ($model) {
                    return Html::a($model->reference, ['leads/' . $model->slug]);
                },
        ],
        [
            'attribute' => 'type_id',
            'value' => function($model) use ($types) {
                return $types[$model->type_id];
            },
            'filter' => $types,
            'contentOptions' => ['style' => 'min-width:170px;'],
            'headerOptions' => ['style' => 'min-width:170px;'],
        ],
        [
            'attribute' => 'status',
            'value' => function ($model) {
                return $model->getStatus();
            },
            'filter' => Leads::getStatuses(),
            'contentOptions' => ['style' => 'min-width:150px;'],
            'headerOptions' => ['style' => 'min-width:150px;'],
        ],
        [
            'attribute' => 'sub_status_id',
            'value' => function($model) use ($subStatuses) {
                return $subStatuses[$model->sub_status_id];
            },
            'filter' => $subStatuses,
            'headerOptions' => ['style' => 'min-width:180px;'],
        ],
        [
            'attribute' => 'priority',
            'value' => function ($model) {
                    return $model->getPriority();
                },
            'filter' => Leads::getPriorities(),
            'headerOptions' => ['style' => 'min-width:120px;'],
        ],
        [
            'attribute' => 'first_name',
            'headerOptions' => ['style' => 'min-width:100px;'],
        ],
        [
            'attribute' => 'last_name',
            'headerOptions' => ['style' => 'min-width:100px;'],
        ]
    ], $filteredColumns)
]);
?>