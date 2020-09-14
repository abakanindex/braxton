<?php
use yii\helpers\{Html, ArrayHelper, Url};
use kartik\datetime\DateTimePicker;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use app\models\TaskManager;

$taskManager  = new TaskManager();
?>

<?php $formAddToDo = ActiveForm::begin([
    'action' => Url::to(['task-manager/create']),
    'id' => 'formAddToDoItem'
]);?>
<input type="hidden" name="externalForm" value="1">

    <div class="row">
        <div class="col-md-6">
            <?= $formAddToDo->field($taskManager, 'listing_ref')->hiddenInput(['value' => $ref])->label(false); ?>

            <?= Html::a(Yii::t('app', 'Add Responsible'), '#', ['class' => 'open-users-gridview btn btn-default']);?>

            <?php
            $field = $formAddToDo->field($taskManager, 'responsible');
            $field->template = "{input}{error}";
            echo $field->textInput(['style' => 'display: none']);
            ?>

            <div class='panel panel-default' style="margin-top: 10px">
                <div class='panel-heading'><?= Yii::t('app', 'Choosed Responsibles') ?></div>
                <div class='panel-body'>
                    <ul id='choosed-responsibles-list' style='list-style: none; padding-left: 0px;'>
                    </ul>
                </div>
            </div>

            <?= $formAddToDo->field($taskManager, 'title')->textInput(['maxlength' => true]) ?>

            <?= $formAddToDo->field($taskManager, 'description')->textarea(['id' => 'task-manager-description']);
            echo \vova07\imperavi\Widget::widget([
                'selector' => '#task-manager-description',
                'settings' => [
                    'lang'    => 'en',
                    'buttons' => ['link']
                ]
            ]);
            ?>
        </div>
        <div class="col-md-6">
            <?php
            echo $formAddToDo->field($taskManager, 'priority')->dropDownList([
                TaskManager::PRIORITY_HIGH => Yii::t('app', 'High'),
                TaskManager::PRIORITY_MEDIUM => Yii::t('app', 'Medium'),
                TaskManager::PRIORITY_LOW => Yii::t('app', 'Low'),
            ]);
            ?>

            <div class="form-group">
                <?php
                if (!$taskManager->IsNewRecord && $taskManager->deadline)
                    $taskManager->deadline = date('Y-m-d H:i', $taskManager->deadline);
                echo '<label>Deadline</label>';
                echo kartik\datetime\DateTimePicker::widget([
                    'model' => $taskManager,
                    'attribute' => 'deadline',
                    'options' => ['placeholder' => 'Enter event time ...'],
                    'pluginOptions' => [
                        'autoclose' => true
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>
    <div class="clearfix">
        <?= Html::submitButton(Yii::t('app', 'Save & Close'), ['class' => 'btn btn-success pull-right', 'id' => 'btnCreateToDoForItem']) ?>
    </div>

<?php $formAddToDo = ActiveForm::end(); ?>