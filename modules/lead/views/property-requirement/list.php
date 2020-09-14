<?php
use yii\widgets\ListView;
use yii\widgets\Pjax;

Pjax::begin(['id' => 'property-requirement-list']);
echo ListView::widget([
    'dataProvider' => $propertyRequirementDataProvider,
    'itemView' => '_property_requirement_list',
]);
Pjax::end();