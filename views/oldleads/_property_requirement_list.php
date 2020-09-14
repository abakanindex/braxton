<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

?>
<?php
$salesAttributes = $model->getSalesAttributes();
$rentalsAttributes = $model->getRentalsAttributes();

$salesRequirementParameters = http_build_query($salesAttributes);
$rentalsRequirementParameters = http_build_query($rentalsAttributes);
?>
<a class="btn btn-default" style="margin-top: 5px; margin-bottom: 5px" data-toggle="collapse"
   href="#collapse-property-requirement-<?= $model->id; ?>" role="button" aria-expanded="false"
   aria-controls="collapse-property-requirement-<?= $model->id; ?>">
    <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
    <?php echo Yii::t('app', 'Property Requirement') . ' ' . ($index + 1); ?>
</a>
<div id="collapse-property-requirement-<?= $model->id; ?>"
     class="collapse panel panel-default property-requirement-view"
     data-sales-parameters="<?= $salesRequirementParameters ?>"
     data-rentals-parameters="<?= $rentalsRequirementParameters ?>"
>
    <div class="panel-body">
        <p>
            <?php
            echo Html::a(Yii::t('app', 'Update'), ['/lead/property-requirement/update', 'id' => $model->id], [
                'class' => 'btn btn-primary update-property-requirement',
                'style' => 'margin-right: 5px',
                'data-toggle' => 'modal',
                'data-target' => '#updatePropertyRequirementForm',
                'title' => 'Edit ID-10'
            ]);
            $deletePropertyReuirementUrl = Url::to(['/lead/property-requirement/delete', 'id' => $model->id]);
            echo Html::a(Yii::t('app', 'Delete'),
                $deletePropertyReuirementUrl,
                ['title' => 'Delete',
                    'onclick' => "if (confirm('" . Yii::t('app', 'Do you want to delete this property?') . "')) {
                          $.ajax('$deletePropertyReuirementUrl', {
                              type: 'POST'
                          }).done(function(data) {
                               bootbox.alert('" . Yii::t('app', 'Property Requirement was deleted') . "');
                               $.pjax.reload({container: '#property-requirement-list'});
                          }); 
                      }
                      return false;  
                      ",
                ]);
            ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'category_id',
                    'value' => $model->category->title,
                ],
                'location',
                'sub_location',
                'min_beds',
                'max_beds',
               /* 'min_price',
                'max_price',
                'min_area',
                'max_area',*/
                'unit_type',
                'unit',
            ],
        ]) ?>
    </div>
</div>
