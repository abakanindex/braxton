<?php

use app\models\Reminder;
use app\models\TaskManager;
use app\components\widgets\ReminderWidget;
use pudinglabs\tagsinput\TagsinputWidget;
use yii\bootstrap\Tabs;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TaskManager */
/* @var $form yii\widgets\ActiveForm */
?>

<?php

$sales = [];
foreach ($model->sales as $sale) {
    $sales[] = $sale->sale;
    $saleIds[] = $sale->sale->id;
}
$salesIdsJson = json_encode($saleIds);
if (count($saleIds) > 0)
    $model->salesIds = $salesIdsJson;

$rentals = [];
foreach ($model->rentals as $rental) {
    $rentals[] = $rental->rental;
    $rentalIds[] = $rental->rental->id;
}
$rentalsIdsJson = json_encode($rentalIds);
if (count($rentalIds) > 0)
    $model->rentalsIds = $rentalsIdsJson;

$responsibles = [];
foreach ($model->responsibleUsers as $responsibleUser) {
    $responsibles[] = $responsibleUser->user;
    $responsibleIds[] = $responsibleUser->user->id;
}
$responsiblesIdsJson = json_encode($responsibleIds);
if (count($responsibleIds) > 0)
    $model->responsible = $responsiblesIdsJson;

$leads = [];
foreach ($model->leads as $lead) {
    $leads[] = $lead->lead;
    $leadIds[] = $lead->lead->id;
}
$leadsIdsJson = json_encode($leadIds);
if (count($leadIds) > 0)
    $model->leadsIds = $leadsIdsJson;

$contacts = [];
foreach ($model->contacts as $contact) {
    $contacts[] = $contact->contact;
    $contactsIds[] = $contact->contact->id;
}
$contactsIdsJson = json_encode($contactsIds);
if (count($contactsIds) > 0)
    $model->contactsIds = $contactsIdsJson;

?>
<div>

    <?= $form->field($model, 'reminder')->textInput(['id' => 'reminder', 'style' => 'display: none'])->label(false) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'disabled' => $disabledAttribute]) ?>

    <?= $form->field($model, 'description')->textarea(['disabled' => $disabledAttribute]) ?>

    <?= Html::a('Add Responsible', '#', [
            'class' => 'btn btn-default',
            'data-toggle'  => 'modal',
            'data-target'  => '#users-modal-task',
        ]
    );?>

    <?php
    $field = $form->field($model, 'responsible');
    $field->template = "{input}{error}";
    echo $field->textInput(['style' => 'display: none']);
    ?>

    <div class='panel panel-default' style="margin-top: 10px">
        <div class='panel-heading'><?= Yii::t('app', 'Choosed Responsibles') ?></div>
        <div class='panel-body'>
            <ul id='choosed-responsibles-list' style='list-style: none; padding-left: 0px;'>
                <?php
                echo $this->render('_choosed_responsible_item', [
                    'responsibles' => $responsibles
                ]);
                ?>
            </ul>
        </div>
    </div>

    <?php
    echo $form->field($model, 'priority')->dropDownList([
        TaskManager::PRIORITY_HIGH => Yii::t('app', 'High'),
        TaskManager::PRIORITY_MEDIUM => Yii::t('app', 'Medium'),
        TaskManager::PRIORITY_LOW => Yii::t('app', 'Low'),
    ], ['disabled' => $disabledAttribute]);

    echo $form->field($model, 'status')->dropDownList(
        TaskManager::getStatuses(),
        ['prompt' => '', 'disabled' => $disabledAttribute]
    );
    ?>

    <?php
    echo '<label class="control-label">' . Yii::t('app', 'Deadline') . '</label>';
    echo DatePicker::widget([
        'model' => $model,
//        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
        'attribute' => 'deadline',
        'options' => ['placeholder' => 'Enter birth date ...'],
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd 00:00:00',
            'autoclose' => true
        ],
    ]);
    ?>

    <?= Html::a(Yii::t('app', 'Add Sales'), '#',
        [
            'class' => 'btn btn-default open-sales-gridview',
            'style' => 'margin-top: 10px'
        ]) ?>

    <?= $form->field($model, 'salesIds')->textInput(['style' => 'display: none'])->label(false); ?>

    <div class='panel panel-default'>
        <div class='panel-heading'><?= Yii::t('app', 'Choosed Sales') ?></div>
        <div class='panel-body'>
            <ul id='choosed-sales-list' style='list-style: none; padding-left: 0px;'>
                <?php
                echo $this->render('_choosed_sale_item', [
                    'sales' => $sales
                ]);
                ?>
            </ul>
        </div>
    </div>

    <?= Html::a(Yii::t('app', 'Add Rentals'), '#',
        [
            'class' => 'btn btn-default open-rentals-gridview',
            'style' => 'margin-top: 10px'
        ]) ?>

    <?= $form->field($model, 'rentalsIds')->textInput(['style' => 'display: none'])->label(false); ?>

    <div class='panel panel-default'>
        <div class='panel-heading'><?= Yii::t('app', 'Choosed Rentals') ?></div>
        <div class='panel-body'>
            <ul id='choosed-rentals-list' style='list-style: none; padding-left: 0px;'>
                <?php
                echo $this->render('_choosed_rental_item', [
                    'rentals' => $rentals
                ]);
                ?>
            </ul>
        </div>
    </div>

    <?= Html::a(Yii::t('app', 'Add Leads'), '#',
        [
            'class' => 'btn btn-default open-leads-gridview',
            'style' => 'margin-top: 10px'
        ]) ?>

    <?= $form->field($model, 'leadsIds')->textInput(['style' => 'display: none'])->label(false); ?>

    <div class='panel panel-default'>
        <div class='panel-heading'><?= Yii::t('app', 'Choosed Leads') ?></div>
        <div class='panel-body'>
            <ul id='choosed-leads-list' style='list-style: none; padding-left: 0px;'>
                <?php
                echo $this->render('_choosed_lead_item', [
                    'leads' => $leads
                ]);
                ?>
            </ul>
        </div>
    </div>

    <?= Html::a(Yii::t('app', 'Add Contacts'), '#',
        [
            'class' => 'btn btn-default open-contacts-gridview',
            'style' => 'margin-top: 10px'
        ]) ?>

    <?= $form->field($model, 'contactsIds')->textInput(['style' => 'display: none'])->label(false); ?>

    <div class='panel panel-default'>
        <div class='panel-heading'><?= Yii::t('app', 'Choosed Contacts') ?></div>
        <div class='panel-body'>
            <ul id='choosed-contacts-list' style='list-style: none; padding-left: 0px;'>
                <?php
                echo $this->render('_choosed_contact_item', [
                    'contacts' => $contacts
                ]);
                ?>
            </ul>
        </div>
    </div>
</div>
