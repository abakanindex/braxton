<?php
    use yii\grid\GridView;
    use yii\widgets\Pjax;
?>


<? //var_dump($modelManageGroupChild); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'layout'       => "{items}\n{pager}",
    'tableOptions' => [
        'class' => 'table table-bordered listings_row',
        'id'    => 'result'
    ],
    'columns' => [
        /*['class' => 'yii\grid\SerialColumn'],*/
        [
            'class'  => 'yii\grid\CheckboxColumn',
            'checkboxOptions' => function ($model, $key, $index, $column) use ($modelManageGroupChild, $modelManageGroup, $disabled) {
                $modelGroup = $modelManageGroupChild::find()->where(['group_name' => $modelManageGroup->group_name, 'user_id' => $model->id])->one();
                return [
                    'checked'  => $modelGroup->group_name ? true : false,
                    'disabled' => $disabled
                ];
            }
        ],
        [
            'class'    => 'yii\grid\ActionColumn',
            'template'=>'',
        ],
        'username',
        'first_name',
        'role',
        [
            'attribute' => 'status',
            'value'     => 'userStatus.title'
        ]
    ],
]);
?>