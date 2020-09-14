<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;

$users = User::findOne(['id' => Yii::$app->user->getId()]);
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'email:email',
            'role',
            'userStatus.title',
            'country',
            'company.company_name',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{permit}&nbsp;&nbsp;{delete}',
                'buttons' =>
                    [
                        'permit' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-wrench"></span>',
                                Url::to(['/permit/user/view', 'id' => $model->id]),
                                [
                                    'title' => Yii::t('yii', 'Change user role')
                                ]);
                        },
                    ]
            ],
        ],
    ]); ?>
</div>
