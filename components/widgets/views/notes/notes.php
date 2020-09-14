<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="tab-header">
    <?php $form = ActiveForm::begin([
        'action' => $urlCreateNote,
        'options' => [
            'enctype' => 'multipart/form-data',
            'class' => 'form clearfix',
            'id' => 'notes-form',
        ]
    ]);?>
    <div class="form-group">
        <?= $form->field($model, 'text', [
            'template' => '{input}', // Leave only input (remove label, error and hint)
            'options' => [
                'tag' => false, // Don't wrap with "form-group" div
            ],
        ])->textarea(['rows' => '4'])?>
    </div>
    <div class="form-group">
        <?= $form->field($model, 'ref', [
            'template' => '{input}', // Leave only input (remove label, error and hint)
            'options' => [
                'tag' => false, // Don't wrap with "form-group" div
            ],
        ])->textInput(['value' => $ref, 'class' => 'hidden'])?>
    </div>
    <?= Html::submitButton(
        Yii::t('app', 'Click to add your note'),
        [
            'class' => 'btn col-md-12'
        ]
    )?>
    <?php $form = ActiveForm::end();?>
</div>
<div class="tab-row">
    <ul>
        <?php foreach($notes as $n) {?>
            <li>
                <p>
                    <?= $n->user->username?>:
                    <?= $n->text?>
                    <?= $n->date?>
                </p>
            </li>
        <?php }?>
    </ul>
</div>