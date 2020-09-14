<?php
use yii\grid\GridView;
use yii\helpers\Html;
?>
<div class="container-fluid  bottom-rentals-content clearfix">
    <div style="overflow-x: auto; padding-right: 0; padding-left: 0;height: 400px;" class="container-fluid clearfix">
        <?= GridView::widget([
            'dataProvider' => $provider,
            'layout' => "{items}\n{pager}",
            'tableOptions' => [
                'class' => 'table_listing table table-bordered'
            ],
            'columns' => [
                [
                    'attribute' => 'reference',
                    'format' => 'raw',
                    'value'     => function ($dataProvider) {
                            $url = Yii::$app->getUrlManager()->createUrl([
                                'leads/view',
                                'id'   => $dataProvider['lead_id'],
                            ]);

                            return Html::a(
                                $dataProvider['reference'],
                                $url,
                                [
                                    'target'     => '_blank',
                                    'data-pjax' => '0',
                                ]
                            );
                        }
                ],
                [
                    'label' => Yii::t('app', 'Agent name'),
                    'value' => 'agentName'
                ],
                'last_name',
                'first_name',
                'mobile_number',
                [
                    'label' => Yii::t('app', 'Category'),
                    'value' => 'category_title'
                ],
                [
                    'attribute' => 'emirate',
                    'value'     => function ($dataProvider) {
                        if (is_numeric($dataProvider['emirate'])) {
                            return $dataProvider['emirateName'];
                        } else {
                            return $dataProvider['emirate'];
                        }
                    }
                ],
                'location',
                'subLocation',
                [
                    'label' => Yii::t('app', 'Status'),
                    'value' => function ($dataProvider) use ($leadStatuses) {
                            return $leadStatuses[$dataProvider['status']];
                        }
                ],
                'min_beds',
                'max_beds',
                'min_baths',
                'max_baths',
                'min_price',
                'max_price',
                'min_area',
                'max_area'
            ]
        ]);
        ?>
    </div>
</div>