<?php
use yii\helpers\{Html, ArrayHelper, Url};
use kartik\datetime\DateTimePicker;
use app\models\Leads;
use yii\widgets\ActiveForm;

$lead = new Leads();
?>

<?php $formAddLead = ActiveForm::begin([
    'action' => Url::to(['leads/create']),
    'id' => 'formAddLeadForItem'
]);?>
<div class="row">
    <div class="col-md-6">
        <div>
            <?= $lead->getAttributeLabel('type_id')?>
            <?php
            $types = \app\modules\lead\models\LeadType::find()->all();
            $items = ArrayHelper::map($types, 'id', 'title');
            $params = [
                'prompt' => Yii::t('app', ''),
                'class' => 'form-control'
            ];
            echo $formAddLead->field($lead, 'type_id')->dropDownList($items, $params)->label(false);
            ?>
        </div>

        <div>
            <?= $lead->getAttributeLabel('first_name')?>
            <?= $formAddLead->field($lead, 'first_name')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false); ?>
        </div>

        <div>
            <?= $lead->getAttributeLabel('last_name')?>
            <?= $formAddLead->field($lead, 'last_name')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false); ?>
        </div>

        <div>
            <?= $lead->getAttributeLabel('type_id')?>
            Mobile Number
            <?= $formAddLead->field($lead, 'mobile_number')->widget(
                borales\extensions\phoneInput\PhoneInput::className(),
                [
                    'jsOptions' => [
                        'initialCountry' => 'ae',
                    ]
                ]
            )->label(false);
            ?>
        </div>
    </div>
    <div class="col-md-6">
        <div>
            <?= $lead->getAttributeLabel('email')?>
            <?= $formAddLead->field($lead, 'email')->textInput([
                'maxlength' => true,
                'class' => 'form-control'
            ])->label(false);
            ?>
        </div>

        <div>
            <?= $lead->getAttributeLabel('enquiry_time')?>
            <?php
            if ($lead->enquiry_time) {
                $enquiryTimeValue = (!$lead->isNewRecord) ? date('Y-m-d H:i', $lead->enquiry_time) : '';
            } else {
                $enquiryTimeValue = '';

                echo $formAddLead->field($lead, 'enquiry_time')->widget(DateTimePicker::classname(), [
                    'options' => [
                        'placeholder' => 'Enter enquiry time ...',
                        'value' => $enquiryTimeValue,
                        'class' => 'form-control',

                    ],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd hh:ii'
                    ]
                ])->label(false);
            }
            ?>
        </div>

        <div>
            <?= $lead->getAttributeLabel('listing_ref')?>
            <?= $formAddLead->field($lead, 'listing_ref')->textInput([
                'maxlength' => true,
                'class' => 'form-control',
                'readonly' => true,
                'value' => $model->ref
            ])->label(false);
            ?>
        </div>

        <div>
            <?= $lead->getAttributeLabel('status')?>
            <?php
            $items = [
                Leads::STATUS_OPEN => Yii::t('app', 'Open'),
                Leads::STATUS_CLOSED => Yii::t('app', 'Closed'),
                Leads::STATUS_NOT_SPECIFIED => Yii::t('app', 'Not Specified')
            ];
            $params = [
                'prompt' => Yii::t('app', ''),
                'class' => 'form-control'
            ];
            echo $formAddLead->field($lead, 'status')->dropDownList($items, $params)->label(false);
            ?>
        </div>
    </div>
</div>
<div class="clearfix">
    <?= Html::submitButton(Yii::t('app', 'Save & Close'), ['class' => 'btn btn-success pull-right', 'id' => 'btnCreateLeadForItem']) ?>
</div>
<?php $formAddLead = ActiveForm::end(); ?>