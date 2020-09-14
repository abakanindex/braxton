<?php

use app\models\Rentals;
use app\models\Sale;
use app\modules\lead_viewing\models\LeadViewingProperty;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = Yii::t('app', 'Lead Viewing');
$this->params['breadcrumbs'][] = ['label' => 'Lead Viewings', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
echo $this->render('_lead-viewings-modals', [
    'salesSearchModel' => $leadViewingSalesSearchModel,
    'salesDataProvider' => $leadViewingSalesDataProvider,
    'rentalsSearchModel' => $leadViewingRentalsSearchModel,
    'rentalsDataProvider' => $leadViewingRentalsDataProvider,
]);
$leadViewingUrl = Url::to(['/lead_viewing/main/index-list', 'id' => $leadViewing->id]);
?>
    <div class="lead-viewing-view">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Update', '#',
                [
                    'class' => 'btn btn-primary',
                    'id' => 'updateLeadViewing',
                    'onclick' => "   
                    $('#modal-viewing-content').load('$leadViewingUrl', function() {
                        $('#modal-viewing').modal('show'); 
                    });
                    return false;
                ",
                ]) ?>
            <?php
            if (time() > $leadViewing->time)
                echo Html::a('Update Report', '#', ['class' => 'btn btn-success', 'id' => 'create-report-lead-viewing']) ?>
            <?= Html::a(Yii::t('app', 'My Viewings'), ['/lead_viewing/main/list'], ['class' => 'btn btn-default', 'id' => 'viewings-show']) ?>
        </p>

        <?= DetailView::widget([
            'model' => $leadViewing,
            'attributes' => [
                [
                    'format' => 'raw',
                    'label' => Yii::t('app', 'Lead'),
                    'value' => Html::a($leadViewing->lead->reference, ['/leads/' . $leadViewing->lead->reference]),
                ],
                [
                    'label' => Yii::t('app', 'Time'),
                    'value' => date('Y-m-d H:i', $leadViewing->time),
                ],
                [
                    'label' => Yii::t('app', 'Sales'),
                    'format' => 'raw',
                    'value' => function ($model) {
                        if (count($model->sales) == 0) return '';
                        $html = '<ul style="list-style: none">';
                        foreach ($model->sales as $saleViewing) {
                            if ($saleViewing->type == LeadViewingProperty::TYPE_SALE) {
                                $sale = Sale::findOne(['id' => $saleViewing->property_id]);
                                $html .= '<li style="margin-top: 2px; margin-bottom: 5px;">'
                                    . Html::a($sale->ref, ['/sale/view', 'id' => $sale->id]) . '</li>';
                            }
                        }
                        $html .= '</ul>';
                        return $html;
                    },
                ],
                [
                    'label' => Yii::t('app', 'Rentals'),
                    'format' => 'raw',
                    'value' => function ($model) {
                        if (count($model->rentals) == 0) return '';
                        $html = '<ul style="list-style: none">';
                        foreach ($model->rentals as $rentalsViewing) {
                            if ($rentalsViewing->type == LeadViewingProperty::TYPE_RENTALS) {
                                $rental = Rentals::findOne(['id' => $rentalsViewing->property_id]);
                                $html .= '<li style="margin-top: 2px; margin-bottom: 5px;">'
                                    . Html::a($rental->ref, ['/rentals/view', 'id' => $rental->id]) . '</li>';
                            }
                        }
                        $html .= '</ul>';
                        return $html;
                    },
                ],
                'report:ntext'
            ]
        ]);
        ?>
    </div>
    <div id="modal-report" class="modal-report modal fade">
        <div class="modal-dialog">
            <div id="modal-report-content" class="modal-content">
            </div>
        </div>
    </div>
<?php
$reportUrl = Url::to(['/lead_viewing/report/update', 'id' => $leadViewing->id]);
$reportSavedMessage = Yii::t('app', 'Report was successfuly saved');

$script = <<<JS
 
$( '#create-report-lead-viewing').click(function () {  
    $('#modal-report-content').load('$reportUrl', function() {
        $('#modal-report').modal('show'); 
    });
    return false;
});  

$('body').on('beforeSubmit.yii', 'form#report-form', function (e) { 
        e.preventDefault();
        e.stopImmediatePropagation();    
        var form = $(this);
        if (form.find('.has-error').length) { 
            return false;
        }    
        
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (response) {
                if ( response.result === 'success' ) {  
                    bootbox.confirm('$reportSavedMessage', function(result) {
                        if (result) { window.location.reload(); } 
                    });   
                }   
             }     
        });
        return false; 
    });
 
JS;
$this->registerJs($script, yii\web\View::POS_READY);