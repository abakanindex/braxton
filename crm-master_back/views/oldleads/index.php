<?php
use app\models\Company;
use app\models\Leads;
use app\models\reference_books\PropertyCategory;
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
/* @var $this yii\web\View */
/* @var $searchModel app\models\LeadsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$userCreatedFilter = ArrayHelper::map(User::find()->where(['company_id' => Company::getCompanyIdBySubdomain()])->asArray()->all(), 'id', 'username');
$this->title = Yii::t('app', 'Leads');
$this->params['breadcrumbs'][] = $this->title;
$companyId = Company::getCompanyIdBySubdomain();
if (empty($companyId))
    $companyId = 0;
?>
<div class="leads-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Lead'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'is_imported',
                'format' => 'raw',
                'filter' => Leads::getImportStatuses(),
                'value' => function ($model) {
                    if ($model->is_imported == Leads::IMPORTED)
                        return '<span class="glyphicon glyphicon-download" aria-hidden="true"></span>';
                    else
                        return '';
                },
                'contentOptions' => ['style' => 'min-width:70px;', 'class' => 'text-center'],
                'contentOptions' => ['style' => 'min-width:70px;', 'class' => 'text-center'],
                'headerOptions' => ['style' => 'min-width:70px;', 'class' => 'text-center'],
            ],
            [
                'attribute' => 'reference',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->reference, ['leads/' . $model->slug]);
                },
            ],
            ['attribute' => 'type',
                'value' => 'leadType.title',
                'filter' => ArrayHelper::map(LeadType::find()->asArray()->all(), 'id', 'title'),
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
                'attribute' => 'subStatus',
                'value' => 'subStatus.title',
                'filter' => ArrayHelper::map(LeadSubStatus::find()->asArray()->all(), 'id', 'title'),
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
            ],
            [
                'attribute' => 'mobile_number',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            [
                'attribute' => 'category',
                'value' => 'category.title',
                'filter' => ArrayHelper::map(PropertyCategory::find()->asArray()->all(), 'id', 'title'),
                'headerOptions' => ['style' => 'min-width:140px;'],
            ],
            [
                'attribute' => 'hot_lead',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            [
                'attribute' => 'emirate',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            [
                'attribute' => 'location',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            [
                'attribute' => 'sub_location',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            [
                'attribute' => 'unit_type',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            [
                'attribute' => 'unit_number',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            [
                'attribute' => 'min_beds',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            [
                'attribute' => 'max_beds',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            [
                'attribute' => 'min_price',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            [
                'attribute' => 'max_price',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            [
                'attribute' => 'min_area',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            [
                'attribute' => 'max_area',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            [
                'attribute' => 'source',
                'value' => 'companySource.title',
                'filter' => ArrayHelper::map(CompanySource::find()->where(['company_id' => $companyId])->asArray()->all(), 'id', 'title'),
            ],
            [
                'attribute' => 'listing_ref',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            [
                'attribute' => 'created_by_user',
                'headerOptions' => ['style' => 'width:100%'],
                'value' => 'createdByUser.username',
                'filter' => $userCreatedFilter,
                'headerOptions' => ['style' => 'min-width:150px;'],
            ],
            [
                'attribute' => 'agent_1',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            [
                'attribute' => 'agent_2',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            [
                'attribute' => 'agent_3',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            [
                'attribute' => 'agent_4',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            [
                'attribute' => 'agent_5',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            /*[
                'attribute' => 'agent',
                'format' => 'raw',
                'label' => Yii::t('app', 'Agents'),
                'headerOptions' => ['style' => 'width:100%'],
                'value' => function ($model, $index, $widget) {
                    $agentsList = '<ul style="list-style: none">';
                    foreach ($model->leadAgents as $agent)
                        $agentsList .= '<li>' . $agent->agent->username . '</li>';
                    $agentsList .= '</ul>';
                    return $agentsList;
                },
                'filter' => $userCreatedFilter,
            ],*/
            [
                'attribute' => 'finance_type',
                'value' => function ($model) {
                    return $model->getFinanceType();
                },
                'filter' => Leads::getFinanceTypes(),
                'headerOptions' => ['style' => 'min-width:150px;'],
            ],
            [
                'attribute' => 'enquiry_time',
                'value' => function ($model, $index, $widget) {
                    if ($model->enquiry_time)
                        return Yii::$app->formatter->asDate($model->enquiry_time);
                    else
                        return '';
                },
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ]
                ],
                'headerOptions' => ['style' => 'min-width:200px;'],
                'hAlign' => 'center',
            ],
            [
                'attribute' => 'updated_time',
                'value' => function ($model, $index, $widget) {
                    return Yii::$app->formatter->asDate($model->updated_time);
                },
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ]
                ],
                'headerOptions' => ['style' => 'min-width:200px;'],
                'hAlign' => 'center',
            ],
            [
                'attribute' => 'contract_company',
                'headerOptions' => ['style' => 'min-width:140px;'],
            ],
            [
                'attribute' => 'email',
                'headerOptions' => ['style' => 'min-width:140px;'],
            ],
            [
                'attribute' => 'agent_referrala',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            [
                'attribute' => 'shared_leads',
                'headerOptions' => ['style' => 'min-width:100px;'],
            ],
            [
                'attribute' => 'additionalEmails',
                'format' => 'raw',
                'value' => function ($model, $index, $widget) {
                    $additionalEmailsList = '<ul style="list-style: none">';
                    foreach ($model->additionalEmailsList as $additionalEmails)
                        $additionalEmailsList .= '<li>' . $additionalEmails->email . '</li>';
                    $additionalEmailsList .= '</ul>';
                    return $additionalEmailsList;
                },
                'headerOptions' => ['style' => 'min-width:140px;'],
            ],
            [
                'attribute' => 'socialMediaContacts',
                'format' => 'raw',
                'value' => function ($model, $index, $widget) {
                    $socialMediaContactsList = '<ul style="list-style: none">';
                    foreach ($model->leadSocialMeadiaContacts as $socialMediaContact) {
                        $socialMediaContactsList .= '<li>' . Html::a(FA::icon($socialMediaContact->getBtnClass()), $socialMediaContact->link, ['target' => '_blank']) . '</li>';
                    }
                    $socialMediaContactsList .= '</ul>';
                    return $socialMediaContactsList;
                },
                'headerOptions' => ['style' => 'min-width:140px;'],
            ],
            [
                'attribute' => 'email_opt_out',
                'value' => function ($model, $index, $widget) {
                    if ($model->email_opt_out)
                        $email_opt_out = Yii::t('app', 'yes');
                    else
                        $email_opt_out = '';
                    return $email_opt_out;
                },
            ],
            [
                'attribute' => 'phone_opt_out',
                'value' => function ($model, $index, $widget) {
                    if ($model->phone_opt_out)
                        $phone_opt_out = Yii::t('app', 'yes');
                    else
                        $phone_opt_out = '';
                    return $phone_opt_out;
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '',
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['leads/' . $model->slug]);
                    },
                    'delete' => function ($url, $model) {
                        $activityUrl = Url::to(['/leads/activity', 'id' => $model->id]);
                        if ($model->activity == Leads::ACTIVITY_ACTIVE) {
                            $glyphiconColor = 'color: #008000;';
                            $btnText = Yii::t('yii', 'Deactivate');
                        } else {
                            $glyphiconColor = 'color: #FF0000';
                            $btnText = Yii::t('yii', 'Activate');
                        }
                        return Html::a('<span style=" ' . $glyphiconColor . ' " class="activity-btn glyphicon glyphicon-off"></span>', '#', [
                            'title' => $btnText,
                            'aria-label' => $btnText,
                            'onclick' => "  
                                var thItem = $(this).closest('tr'); 
                                $.ajax({ 
                                url: '$activityUrl',  
                                 type: 'GET',
                                 dataType: 'json',
                                 success: function(data) {
                                      if ( data.result == 'success' ) {
                                        if ( data.activity == 'not_active' )
                                            thItem.find('.activity-btn').css('color', '#FF0000');
                                            else
                                            thItem.find('.activity-btn').css('color', '#008000');
                                        }                                        
                                  }   
                                });     
                                return false;
                            ",
                        ]);
                    },
                ]
            ]
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>