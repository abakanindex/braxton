    <br/>
    <br/>
    <?= $form->field($model, 'mobile')->widget(
        borales\extensions\phoneInput\PhoneInput::className()
    );

    ?>

    <?= $form->field($model, 'phone')->widget(
            borales\extensions\phoneInput\PhoneInput::className()
        );  
    ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    