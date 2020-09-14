<?php

use yii\helpers\Html;

?>
<?= Html::a('Step 1. Select Module', ['#'], ['id' => 'select-module', 'class' => 'btn btn-info']) ?>
<?= Html::a('Step 2. Create Sub Groups', ['#'], ['id' => 'create-sub-groups', 'class' => 'btn btn-default']) ?>
<?= Html::a('Step 3. Selected Filters', ['#'], ['id' => 'seleted-filters', 'class' => 'btn btn-default']) ?>
<?= Html::a('DONE', ['#'], ['id' => 'done', 'class' => 'btn btn-default']) ?>