<?php
$counter = 1;
foreach ($dataProviders as $dataProvider) {
    if ($dataProvider->getTotalCount() > 0) {
        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading">' . Yii::t('app', 'Property Requirement') . ' ' . $counter . ' </div>';
        echo '<div class="panel-body">';
        echo $this->render('_matching_sales', [
            'dataProvider' => $dataProvider,
            'counter' => $counter,
        ]);
        echo '</div>';
        echo '</div>';
    }
    $counter++;
}