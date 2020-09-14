<?php
use yii\helpers\{Html, ArrayHelper, Url};
use kartik\datetime\DateTimePicker;
use app\modules\deals\models\Deals;
use yii\widgets\ActiveForm;

?>

<?php
$deal = new Deals();
$type = $deal->type = strpos(get_class($model), 'Sale') ? Deals::TYPE_SALES : Deals::TYPE_RENTAL;
$deal->status = Deals::STATUS_DRAFT;
$formAddDeal = ActiveForm::begin([
    'action' => Url::to(['deals/deals/create']),
    'id' => 'formAddDealForItem'
]);
?>
    <div class="row">
        <div class="col-md-6">
            <div>
                <?= $deal->getAttributeLabel('Ref')?>
                <?= $formAddDeal->field($deal, 'ref')->textInput(['readonly' => true, 'class' => 'form-control'])->label(false); ?>
            </div>
            <div>
                <?= $deal->getAttributeLabel('Type')?>
                <?= $formAddDeal->field($deal, 'type')->dropDownList(
                    Deals::getTypes(),
                    [
                        'prompt'   => Yii::t('app', 'Select'),
                        'class'    => 'form-control',
                        'id'    => 'typeDropDown',
                    ]
                )->label(false); ?>
            </div>
            <div>
                <?= $deal->getAttributeLabel('Lead Ref')?>
                <?= Html::input('text', '', '', [
                    'class'    => 'form-control',
                    'readonly' => true
                ])?>
                <div class="help-block"></div>
                <?= $formAddDeal->field($deal, 'lead_id')
                    ->hiddenInput(['value' => 0])
                    ->label(false);?>
            </div>
            <div>
                <?= $deal->getAttributeLabel('Owner')?>
                <?= Html::input('text', '', $ownerRecord->last_name . ' ' . $ownerRecord->first_name, [
                    'class'    => 'form-control',
                    'readonly' => true
                ])?>
                <div class="help-block"></div>
            </div>
            <div>
                <?= $deal->getAttributeLabel('created_by')?>
                <?= $formAddDeal->field($deal, 'created_by')->textInput(['readonly' => true, 'class' => 'form-control', 'value' => Yii::$app->user->identity->last_name . ' ' . Yii::$app->user->identity->first_name])->label(false); ?>
            </div>
            <div>
                <?= $deal->getAttributeLabel('listing_ref')?>
                <?= Html::input('text', '', $model->ref, [
                    'class'    => 'form-control',
                    'readonly' => true
                ])?>
                <div class="help-block"></div>
                <?php
                echo $formAddDeal->field($deal, 'type')
                    ->hiddenInput(['value' => $type])
                    ->label(false);
                echo $formAddDeal->field($deal, 'model_id')
                    ->hiddenInput(['value' => $model->id])
                    ->label(false);
                ?>
            </div>
            <div>
                <?= $model->getAttributeLabel('category_id')?>
                <?= Html::input('text', '', $categories[$model->category_id], [
                    'class'    => 'form-control',
                    'readonly' => true
                ])?>
                <div class="help-block"></div>
            </div>
            <div>
                <?= $model->getAttributeLabel('beds')?>
                <?= Html::input('text', '', $model->beds, [
                    'class'    => 'form-control',
                    'readonly' => true
                ])?>
                <div class="help-block"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div>
                <?= $model->getAttributeLabel('region_id')?>
                <?= Html::input('text', '', $emiratesDropDown[$model->region_id], [
                    'class'    => 'form-control',
                    'readonly' => true
                ])?>
                <div class="help-block"></div>
            </div>
            <div>
                <?= $model->getAttributeLabel('area_location_id')?>
                <?= Html::input('text', '', $locationDropDown[$model->area_location_id], [
                    'class'    => 'form-control',
                    'readonly' => true
                ])?>
                <div class="help-block"></div>
            </div>
            <div>
                <?= $model->getAttributeLabel('sub_area_location_id')?>
                <?= Html::input('text', '', $subLocationDropDown[$model->sub_area_location_id], [
                    'class'    => 'form-control',
                    'readonly' => true
                ])?>
                <div class="help-block"></div>
            </div>
            <div>
                <?= $deal->getAttributeLabel('deal_price')?>
                <?= $formAddDeal->field($deal, 'deal_price')->textInput([
                    'class' => 'form-control'
                ])->label(false);
                ?>
            </div>
            <div>
                <?= $deal->getAttributeLabel('deposit')?>
                <?= $formAddDeal->field($deal, 'deposit')->textInput([
                    'class' => 'form-control'
                ])->label(false);
                ?>
            </div>
            <div>
                <?= $deal->getAttributeLabel('gross_commission')?>
                <?= $formAddDeal->field($deal, 'gross_commission')->textInput([
                    'class' => 'form-control'
                ])->label(false);
                ?>
            </div>
            <div>
                <?= $deal->getAttributeLabel('actual_date')?>
                <?= $formAddDeal->field($deal, 'actual_date')->widget(DateTimePicker::classname(), [
                    'options' => [
                        'value' => date('Y-m-d H:i'),
                        'class' => 'form-control',

                    ],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd hh:ii'
                    ]
                ])->label(false);
                ?>
            </div>
            <div>
                <?= $deal->getAttributeLabel('status')?>
                <?= $formAddDeal->field($deal, 'status')->dropDownList(
                    Deals::getStatuses(),
                    [
                        'prompt'   => Yii::t('app', 'Not Specified'),
                        'class'    => 'form-control',
                        'id'    => 'typeDropDown',
                    ]
                )->label(false); ?>
            </div>
        </div>
    </div>
    <div class="clearfix">
        <?= Html::submitButton(Yii::t('app', 'Save & Close'), ['class' => 'btn btn-success pull-right', 'id' => 'btnCreateDealForItem']) ?>
    </div>
<?php $formAddDeal = ActiveForm::end(); ?>
