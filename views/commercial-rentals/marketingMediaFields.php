<?php

//echo vova07\imperavi\Widget::widget([
//    'name' => 'redactor',
//    'settings' => [
//        'lang' => 'ru',
//        'minHeight' => 200,
//        'plugins' => [
//            'clips',
//            'fullscreen'
//        ]
//    ]
//]);

echo '<label class="control-label">Photos</label>';
echo kartik\file\FileInput::widget([
    'model' => $modelImg,
    'attribute' => 'imageFiles[]',
    'language' => 'en',
    'options' => [
        'accept' => 'image/*',
        'multiple' => true,
    ],
    'pluginOptions' => [
        'showPreview' => true,
        'initialPreviewAsData' => true,
        'overwriteInitial' => true,
        'showUpload' => false,
        'initialPreview' => $modelImg->imgUrl($modelImg->imageFiles),
        'showCaption' => false,
        'showRemove' => false,
        'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
        'browseLabel' => 'Select Photo',
        'uploadUrl' => \yii\helpers\Url::to(['/site/file-upload']),
    ]
]);
?>

<?php

echo '<label class="control-label">Floor plans</label>';
echo kartik\file\FileInput::widget([
    'model' => $modelImgTwo,
    'attribute' => 'imageFilesTwo[]',
    'language' => 'en',
    'options' => [
        'accept' => 'image/*',
        'multiple' => true,
    ],
    'pluginOptions' => [
        'showPreview' => true,
        'initialPreviewAsData' => true,
        'overwriteInitial' => true,
        'showUpload' => false,
        'initialPreview' => $modelImgTwo->imgUrl($modelImgTwo->imageFilesTwo),
        'showCaption' => false,
        'showRemove' => false,
        'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
        'browseLabel' => 'Select Photo',
        'uploadUrl' => \yii\helpers\Url::to(['/site/file-upload']),
    ]
]);
?>

<?= $form->field($model, 'language')->dropDownList([
    'English' => Yii::t('app', 'English'),
    'Russian' => Yii::t('app', 'Russian'),
    'Arabic' => Yii::t('app', 'Arabic'),
]);
?>
<?= $form->field($model, 'title')->textInput(['maxlength' => true]); ?>

<?= $form->field($model, 'description')->widget(vova07\imperavi\Widget::className(), [
    'settings' => [
        'lang' => 'en',
        'buttons' => ['link']
    ],
]);
?>
<?php

$items = [
    Yii::t('app', 'JustProperty') => Yii::t('app', 'JustProperty'),
    Yii::t('app', 'JustRentals') => Yii::t('app', 'JustRentals'),
    Yii::t('app', 'Dubizzle') => Yii::t('app', 'Dubizzle'),
    Yii::t('app', 'Propertyfinder') => Yii::t('app', 'Propertyfinder'),
    Yii::t('app', 'Bayut') => Yii::t('app', 'Bayut'),
    Yii::t('app', 'GNproperty') => Yii::t('app', 'GNproperty'),
    Yii::t('app', 'Zoopla') => Yii::t('app', 'Zoopla'),
    Yii::t('app', 'Rightmove') => Yii::t('app', 'Rightmove'),
    Yii::t('app', 'YzerProperty') => Yii::t('app', 'YzerProperty'),
    Yii::t('app', 'Own Website') => Yii::t('app', 'Own Website'),
    Yii::t('app', 'Juwai') => Yii::t('app', 'Juwai'),
    Yii::t('app', 'Mansion Global') => Yii::t('app', 'Mansion Global'),
    Yii::t('app', 'PropSpace MLS') => Yii::t('app', 'PropSpace MLS'),
    Yii::t('app', 'WallStreet Journal') => Yii::t('app', 'WallStreet Journal'),
];


$atr = $model->portals ? 'portals' : 'portals[]' ;

?>


<?= $form->field($model, $atr)->widget(
    kartik\select2\Select2::classname(), [
        'name' => 'portals',
        'data' => $items,
        'theme' => kartik\select2\Select2::THEME_BOOTSTRAP,
        'options' => ['placeholder' => 'Select a contact source', 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
        ],
    ]
);

?>

<?php

$items = [
    Yii::t('app', 'Property Features') => [
        Yii::t('app', 'Balcony') => Yii::t('app', 'Balcony'),
        Yii::t('app', 'Basement parking') => Yii::t('app', 'Basement parking'),
        Yii::t('app', 'BBQ area') => Yii::t('app', 'BBQ area'),
        Yii::t('app', 'Broadband ready') => Yii::t('app', 'Broadband ready'),
        Yii::t('app', 'Built in wardrobes') => Yii::t('app', 'Built in wardrobes'),
        Yii::t('app', 'Carpets') => Yii::t('app', 'Carpets'),
        Yii::t('app', 'Central air conditioning') => Yii::t('app', 'Central air conditioning'),
        Yii::t('app', 'Central heating') => Yii::t('app', 'Central heating'),
        Yii::t('app', 'Community View') => Yii::t('app', 'Community View'),
        Yii::t('app', 'Covered parking') => Yii::t('app', 'Covered parking'),
        Yii::t('app', 'Driver\'s Room') => Yii::t('app', 'Driver\'s Room'),
        Yii::t('app', 'Fully fitted kitchen') => Yii::t('app', 'Fully fitted kitchen'),
        Yii::t('app', 'Fully furnished') => Yii::t('app', 'Fully furnished'),
        Yii::t('app', 'Gazebo and outdoor entertaining area') => Yii::t('app', 'Gazebo and outdoor entertaining area'),
        Yii::t('app', 'Gymnasium') => Yii::t('app', 'Gymnasium'),
        Yii::t('app', 'Intercom') => Yii::t('app', 'Intercom'),
        Yii::t('app', 'Jacuzzi') => Yii::t('app', 'Jacuzzi'),
        Yii::t('app', 'Kitchen white goods') => Yii::t('app', 'Kitchen white goods'),
        Yii::t('app', 'Maid\'s room') => Yii::t('app', 'Maid\'s room'),
        Yii::t('app', 'Marble floors') => Yii::t('app', 'Marble floors'),
        Yii::t('app', 'On high floor') => Yii::t('app', 'On high floor'),
        Yii::t('app', 'On low floor') => Yii::t('app', 'On low floor'),
        Yii::t('app', 'On mid floor') => Yii::t('app', 'On mid floor'),
        Yii::t('app', 'Part furnished') => Yii::t('app', 'Part furnished'),
        Yii::t('app', 'Pets allowed') => Yii::t('app', 'Pets allowed'),
        Yii::t('app', 'Private garage') => Yii::t('app', 'Private garage'),
        Yii::t('app', 'Private garden') => Yii::t('app', 'Private garden'),
        Yii::t('app', 'Private swimming pool') => Yii::t('app', 'Private swimming pool'),
        Yii::t('app', 'Professionally landscaped garden') => Yii::t('app', 'Professionally landscaped garden'),
        Yii::t('app', 'Professionally landscaped garden') => Yii::t('app', 'Professionally landscaped garden'),
        Yii::t('app', 'Sauna') => Yii::t('app', 'Sauna'),
        Yii::t('app', 'Shared swimming pool') => Yii::t('app', 'Shared swimming pool'),
        Yii::t('app', 'Solid wood floors') => Yii::t('app', 'Solid wood floors'),
        Yii::t('app', 'Steam room') => Yii::t('app', 'Steam room'),
        Yii::t('app', 'Study') => Yii::t('app', 'Study'),
        Yii::t('app', 'Upgraded interior') => Yii::t('app', 'Upgraded interior'),
        Yii::t('app', 'View of gardens') => Yii::t('app', 'View of gardens'),
        Yii::t('app', 'View of golf course') => Yii::t('app', 'View of golf course'),
        Yii::t('app', 'View of parkland') => Yii::t('app', 'View of parkland'),
        Yii::t('app', 'View of sea/water') => Yii::t('app', 'View of sea/water'),
    ],
    Yii::t('app', 'Property Amenities') => [
        Yii::t('app', '24 hours Maintenance') => Yii::t('app', '24 hours Maintenance'),
        Yii::t('app', 'Bank/ATM Facility') => Yii::t('app', 'Bank/ATM Facility'),
        Yii::t('app', 'Basketball Court') => Yii::t('app', 'Basketball Court'),
        Yii::t('app', 'Beach Access') => Yii::t('app', 'Beach Access'),
        Yii::t('app', 'Bus services') => Yii::t('app', 'Bus services'),
        Yii::t('app', 'Business Center') => Yii::t('app', 'Business Center'),
        Yii::t('app', 'Children\'s nursery') => Yii::t('app', 'Children\'s nursery'),
        Yii::t('app', 'Children\'s play area') => Yii::t('app', 'Children\'s play area'),
        Yii::t('app', 'Clubhouse') => Yii::t('app', 'Clubhouse'),
        Yii::t('app', 'Communal gardens') => Yii::t('app', 'Communal gardens'),
        Yii::t('app', 'Concierge service') => Yii::t('app', 'Concierge service'),
        Yii::t('app', 'Cycling tracks') => Yii::t('app', 'Cycling tracks'),
        Yii::t('app', 'Fitness Center') => Yii::t('app', 'Fitness Center'),
        Yii::t('app', 'Golf club and clubhouse') => Yii::t('app', 'Golf club and clubhouse'),
        Yii::t('app', 'Laundry Service') => Yii::t('app', 'Laundry Service'),
        Yii::t('app', 'Marina Berth') => Yii::t('app', 'Marina Berth'),
        Yii::t('app', 'Metro station') => Yii::t('app', 'Metro station'),
        Yii::t('app', 'Mosque') => Yii::t('app', 'Mosque'),
        Yii::t('app', 'Polo club and clubhouse') => Yii::t('app', 'Polo club and clubhouse'),
        Yii::t('app', 'Public park') => Yii::t('app', 'Public park'),
        Yii::t('app', 'Public parking') => Yii::t('app', 'Public parking'),
        Yii::t('app', 'Public transport') => Yii::t('app', 'Public transport'),
        Yii::t('app', 'Recreational Facilities') => Yii::t('app', 'Recreational Facilities'),
        Yii::t('app', 'Restaurants') => Yii::t('app', 'Restaurants'),
        Yii::t('app', 'School') => Yii::t('app', 'School'),
        Yii::t('app', 'Shopping mall') => Yii::t('app', 'Shopping mall'),
        Yii::t('app', 'Shops') => Yii::t('app', 'Shops'),
        Yii::t('app', 'Sports academies') => Yii::t('app', 'Sports academies'),
        Yii::t('app', 'Squash courts') => Yii::t('app', 'Squash courts'),
        Yii::t('app', 'Tennis courts') => Yii::t('app', 'Tennis courts'),
        Yii::t('app', 'Valet Service') => Yii::t('app', 'Valet Service'),
        Yii::t('app', 'Walking Trails') => Yii::t('app', 'Walking Trails'),
    ],
];


$atr = $model->features ? 'features' : 'features[]' ;
?>

<?= $form->field($model, $atr)->widget(
    kartik\select2\Select2::classname(), [
        'name' => 'features',
        'data' => $items,
        'theme' => kartik\select2\Select2::THEME_BOOTSTRAP,
        'options' => ['placeholder' => 'Select a contact source', 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
        ],
    ]
);


?>

<?php $form->field($model, 'neighbourhood')->textarea(['rows' => 6]); ?>


