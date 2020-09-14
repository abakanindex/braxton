<?php
use yii\helpers\Html;
use yii\grid\GridView;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'layout' => "{items}\n{pager}",
    'tableOptions' => [
        'class' => 'table table-bordered listings_row',
    ],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'class'  => 'yii\grid\ActionColumn',
            'buttons'=>[
                'view'=>function ($url, $model) use ($urlView, $topModel) {
                        $url = Yii::$app->getUrlManager()->createUrl([
                            '/users/user-settings/view',
                            'id'   => $model['id'],
                        ]);
                        return \yii\helpers\Html::a(
                            ($topModel->id == $model['id']) ? '<i class="fa fa-eye active"></i>' : '<i class="fa fa-eye"></i>',
                            $url,
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
        'username',
        'first_name',
        'last_name',
        'job_title',
        'office_no',
        'mobile_no',
        'country_dialing',
        'email',
        [
            'attribute' => 'role',
            'filter'    => Html::activeDropDownList($searchModel, 'role', $authItems, ['class' => 'form-control', 'prompt' => ''])
        ],
        [
            'attribute' => 'status',
            'value'     => 'userStatus.title',
            'filter'    => Html::activeDropDownList($searchModel, 'status', $userStatuses, ['class' => 'form-control', 'prompt' => ''])
        ]
    ],
]);
?>