<?php

use app\components\widgets\NotesWidget;
use app\components\widgets\DocumentsWidget;
use app\components\widgets\ViewingsSaleRentalWidget;
use app\components\widgets\ReminderWidget;
use app\models\Note;
use app\models\Document;
use app\models\Viewings;
use app\models\Reminder;
use app\models\statusHistory\widgets\ArchiveHistoryWidget;

?>

<div
    <?php if(Yii::$app->controller->action->id === 'create' || !$topModel->id):?>
        id="listing-widget-actions"
        class="container-fluid col-md-3 notes-block opacity-half"
    <?php else:?>
        class="container-fluid col-md-3 notes-block"
    <?php endif?>
    >
    <div id="notes-tab">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#notes" data-toggle="tab">Notes</a></li>
            <li><a href="#reminder" data-toggle="tab">Reminder</a></li>
            <li><a href="#documents" data-toggle="tab">Documents</a></li>
            <li><a href="#history" data-toggle="tab">History</a></li>
        </ul>
        <div class="property-list">
            <div class="tab-content ">
                <div class="tab-pane active" id="notes">
                    <?= NotesWidget::widget(['model' => new Note(), 'ref' => $topModel->ref]) ?>
                </div>
                <div class="tab-pane" id="reminder">
                    <div class="tab-header">
                        <h4>Set up Reminder</h4>
                    </div>
                    <div class="tab-row">
                        <div class="panel panel-default">
                            <?= ReminderWidget::widget(['keyId' => $topModel->id, 'keyType' => Reminder::KEY_TYPE_SALE]) ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="documents">
                    <?= DocumentsWidget::widget(['model' => new Document(), 'ref' => $topModel->ref, 'keyType' => Document::KEY_TYPE_SALE]) ?>
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

    <?= ViewingsSaleRentalWidget::widget(['model' => new Viewings(), 'ref' => $topModel->ref, 'type' => Viewings::TYPE_SALE]) ?>
</div>