<?php
use app\components\widgets\NotesWidget;
use app\components\widgets\DocumentsWidget;
use app\models\statusHistory\widgets\ArchiveHistoryWidget;
use yii\bootstrap\Tabs;
use yii\grid\GridView;
use yii\helpers\Html;
use app\models\Document;
?>

<div id="notes-tab" >
<ul class="nav nav-tabs">
    <li class="active"><a href="#notes" data-toggle="tab">Notes</a></li>
    <li><a href="#documents" data-toggle="tab">Documents</a></li>
    <li><a href="#history" data-toggle="tab">History</a></li>
</ul>
<div class="property-list">
    <div class="tab-content">
        <div class="tab-pane active" id="notes">
            <?= NotesWidget::widget(['model' => $noteModel, 'ref' => $model->ref])?>
        </div>
        <div class="tab-pane" id="documents">
            <?= DocumentsWidget::widget(['model' => $documentModel, 'ref' => $model->ref, 'keyType' => Document::KEY_TYPE_CONTACT])?>
        </div>
        <div class="tab-pane" id="history">
            <div class="tab-header">
                <h4>History List</h4>
            </div>

            <div class="tab-row">
                <?= ArchiveHistoryWidget::widget(['modelHistory' => $historyProperty]); ?>
            </div>
        </div>
    </div>
</div>
</div>

<div>
    <h3><?= Yii::t('app', 'Properties')?></h3>
    <?= Tabs::widget([
        'items' => [
            [
                'label' => Yii::t('app', 'Sales'),
                'content' => GridView::widget([
                        'dataProvider' => $salesForContactDataProvider,
                        'layout' => "{items}\n{pager}",
                        'tableOptions' => [
                            'class' => 'table table-bordered listings_row',
                        ],
                        'columns' => [
                            [
                                'attribute' => 'landlord_id',
                                'value' => function($dataProvider) {
                                        return Yii::t('app', 'Yes');
                                    }
                            ],
                            [
                                'attribute' => 'ref',
                                'format' => 'raw',
                                'value'     => function($dataProvider) {
                                        return Html::a(
                                            $dataProvider->ref,
                                            ['/sale/view/' . $dataProvider->id],
                                            [
                                                'data-pjax' => '0',
                                                'target' => '_blank'
                                            ]
                                        );
                                    }
                            ]
                        ]
                    ])
            ],
            [
                'label' => Yii::t('app', 'Rentals'),
                'content' => GridView::widget([
                        'dataProvider' => $rentalsForContactDataProvider,
                        'layout' => "{items}\n{pager}",
                        'tableOptions' => [
                            'class' => 'table table-bordered listings_row',
                        ],
                        'columns' => [
                            [
                                'attribute' => 'landlord_id',
                                'value' => function($dataProvider) {
                                        return Yii::t('app', 'Yes');
                                    }
                            ],
                            [
                                'attribute' => 'ref',
                                'format' => 'raw',
                                'value'     => function($dataProvider) {
                                        return Html::a(
                                            $dataProvider->ref,
                                            ['/rentals/view/' . $dataProvider->id],
                                            [
                                                'data-pjax' => '0',
                                                'target' => '_blank'
                                            ]
                                        );
                                    }
                            ]
                        ]
                    ])
            ]
        ]
    ])?>
</div>
