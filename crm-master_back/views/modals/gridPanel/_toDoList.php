<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
?>

<?php
Modal::begin([
    'header' => '<h4>' . Yii::t('app', 'To Do') . '</h4>',
    'id'     => 'modal-to-do-gridview',
    'size'   => 'modal-lg',
]);
?>
<div class="container-fluid  bottom-rentals-content clearfix">
    <div style="overflow-x: auto; padding-right: 0; padding-left: 0;" class="container-fluid clearfix">
        <?=GridView::widget([
            'dataProvider' => $taskManagerDataProvider,
            //'filterModel' => $contactsSearchModel,
            'layout' => "{items}\n{pager}",
            'tableOptions' => [
                'class' => 'listings_row table table-bordered',
            ],
            'columns' => [
                'title',
                'description:html',
                [
                    'attribute' => 'responsible',
                    'format'    => 'raw',
                    'value'     => function ($model, $index, $widget) {
                            $users     = \app\models\TaskResponsibleUser::find()->where(['task_id' => $model->id])->with(['user'])->all();
                            $usersList = '<ul style="list-style: none">';
                            foreach ($users as $user)
                                $usersList .= '<li>' . $user->user->username . '</li>';
                            $usersList .= '</ul>';
                            return $usersList;
                        }
                ],
                [
                    'attribute' => Yii::t('app', 'Deadline'),
                    'format'    => 'raw',
                    'value'     => function ($model, $index, $widget) {
                            if ($model->deadline)
                                return date('Y-m-d H:i', $model->deadline);
                            else return '';
                        }
                ],
                'remind',
                [
                    'attribute' => 'salesIds',
                    'format'    => 'raw',
                    'value'     => function ($model, $index, $widget) {
                            $salesLinks = \app\models\TaskSaleLink::find()->where(['task_id' => $model->id])->with(['sale'])->all();
                            $salesList  = '<ul style="list-style: none">';
                            foreach ($salesLinks as $salesLink)
                                $salesList .= '<li>' . Html::a($salesLink->sale->ref, ['sale/view', 'id' => $salesLink->sale->id]) . '</li>';
                            $salesList .= '</ul>';
                            return $salesList;
                        }
                ],
                [
                    'attribute' => 'rentalsIds',
                    'format'    => 'raw',
                    'value'     => function ($model, $index, $widget) {
                            $rentalsLinks = \app\models\TaskRentalLink::find()->where(['task_id' => $model->id])->with(['rental'])->all();
                            $rentalsList  = '<ul style="list-style: none">';
                            foreach ($rentalsLinks as $rentalsLink)
                                $rentalsList .= '<li>' . Html::a($rentalsLink->rental->ref, ['rentals/view', 'id' => $rentalsLink->rental->id]) . '</li>';
                            $rentalsList .= '</ul>';
                            return $rentalsList;
                        }
                ],
                [
                    'attribute' => 'leadsIds',
                    'format'    => 'raw',
                    'value'     => function ($model, $index, $widget) {
                            $leadsLinks = \app\models\TaskLeadLink::find()->where(['task_id' => $model->id])->with(['lead'])->all();
                            $leadsList = '<ul style="list-style: none">';
                            foreach ($leadsLinks as $leadsLink)
                                $leadsList .= '<li>' . Html::a($leadsLink->lead->reference, ['leads/' . $leadsLink->lead->reference]) . '</li>';
                            $leadsList .= '</ul>';
                            return $leadsList;
                        }
                ],
                [
                    'attribute' => 'contactsIds',
                    'format'    => 'raw',
                    'value'     => function ($model, $index, $widget) {
                            $contactsLinks = \app\models\TaskContactLink::find()->where(['task_id' => $model->id])->with(['contact'])->all();
                            $contactsList = '<ul style="list-style: none">';
                            foreach ($contactsLinks as $contactsLink)
                                $contactsList .= '<li>' . Html::a($contactsLink->contact->ref, ['contacts/view', 'id' => $contactsLink->contact->id]) . '</li>';
                            $contactsList .= '</ul>';
                            return $contactsList;
                        }
                ]
            ],
        ]);
        ?>
    </div>
</div>
<?php
Modal::end();
?>