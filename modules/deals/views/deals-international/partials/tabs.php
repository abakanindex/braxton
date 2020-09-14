<?php

use app\components\widgets\NotesWidget;
use app\components\widgets\DocumentsWidget;
use app\components\widgets\ViewingsSaleRentalWidget;
use app\models\Note;
use app\models\Document;
use app\models\Viewings;
use app\models\statusHistory\widgets\ArchiveHistoryWidget;

?>

<div class="container-fluid col-md-3 notes-block"><!-- Right part-->
    <div id="notes-tab">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#notes" data-toggle="tab">Notes</a></li>
            <li><a href="#documents" data-toggle="tab">Documents</a></li>
        </ul>
        <div class="property-list">
            <div class="tab-content ">
                <div class="tab-pane active" id="notes">
                    <?= NotesWidget::widget(['model' => new Note(), 'ref' => $topModel->ref]) ?>
                </div>
                <div class="tab-pane" id="documents">
                    <?= DocumentsWidget::widget(['model' => new Document(), 'ref' => $topModel->ref]) ?>
                </div>
            </div>
        </div>
    </div>
</div>