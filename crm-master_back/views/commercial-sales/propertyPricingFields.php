

<?= $form->field($model, 'price')->textInput(); ?>

<?= $form->field($model, 'parking')->textInput(['maxlength' => true]); ?>

<?= $form->field($model, 'price_2')->textInput(); ?>

<?= $form->field($model, 'status')->dropDownList([
    'Published' => Yii::t('app', 'Published'),
    'Unfurnished' => Yii::t('app', 'Unfurnished'),
    'Draft' => Yii::t('app', 'Draft'),
]); ?>