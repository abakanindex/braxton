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

$propertyRequirementListUrl = Url::to(['/lead/property-requirement/list', 'leadId' => $model->lead_id]);

$collapse = (!$update) ? 'collapse': '';
$expanded = ($update) ? 'true' : 'false';
$collapsed = ($update) ? '' : 'collapsed';
$in = ($update) ? 'in' : '';

?>
<div id="property-requirement-item-<?= $model->id ?>">
    <a class="btn btn-default collapse-property-requirement" style="margin-top: 5px; margin-bottom: 5px"
       data-toggle="collapse"
       href="#collapse-property-requirement-<?= $model->id; ?>" role="button" aria-expanded="<?= $expanded ?>"
       aria-controls="collapse-property-requirement-<?= $model->id; ?>">
        <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
        <?php echo Yii::t('app', 'Property Requirement') . ' ' . ($index + 1); ?>
    </a>
    <div id="collapse-property-requirement-<?= $model->id; ?>"
         class="<?= $collapse ?> panel panel-default property-requirement-view <?= $in ?>"
         data-sales-parameters="<?= $salesRequirementParameters ?>"
         data-rentals-parameters="<?= $rentalsRequirementParameters ?>"
    >
        <div class="panel-body">
            <p>
                <?php
                echo Html::a(Yii::t('app', 'Update'), ['/lead/property-requirement/update', 'id' => $model->id], [
                    'class' => 'btn btn-primary update-property-requirement',
                    'style' => 'margin-right: 5px',
                    'data-property-requirement-id' => $model->id,
                ]);
                $deletePropertyRequirementUrl = Url::to(['/lead/property-requirement/delete', 'id' => $model->id]);
                echo Html::a(Yii::t('app', 'Delete'),
                    $deletePropertyRequirementUrl,
                    ['title' => 'Delete',
                        'onclick' => "if (confirm('" . Yii::t('app', 'Do you want to delete this property?') . "')) {
                        $.ajax({
                            url: '$deletePropertyRequirementUrl',
                            type: 'post',
                            success: function (response) {
                                if ( response.success ) {  
                                    $('.property-requirement-list-block').load('$propertyRequirementListUrl', function() {
                                        $('#create-property-requirement-modal').modal('hide'); 
                                        $('#matching-sales-list').empty();
                                        $('#matching-rentals-list').empty();
                                    });
                                }
                            }
                         });
                      }
                      return false;  
                      ",
                    ]);
                ?>
            </p>

            <?= $this->render('_details', ['model' => $model]) ?>
        </div>
    </div>
</div>
