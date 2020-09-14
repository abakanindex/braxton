

    <?= $form->field($model, 'contact_source')->widget(
            kartik\select2\Select2::classname(), [
                'name'          => 'contact_source',
                'data'          => $sourceModel,
                'theme'         => kartik\select2\Select2::THEME_BOOTSTRAP,
                'options'       => ['placeholder' => 'Select a contact source'],
                'pluginOptions' => [
                    'tags' => true,
                    'tokenSeparators' => [',', ' '],
                    'maximumInputLength' => 10
                ],
            ]
        ); 
    ?>

    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'designation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_type')->widget(
            kartik\select2\Select2::classname(), [
                'name'          => 'contact_source',
                'data'          => [
                    'Tenant'         => 'Tenant',  
                    'Buyer'          => 'Buyer',  
                    'LandLord'       => 'LandLord',  
                    'Seler'          => 'Seler',  
                    'LandLord+Seler' => 'LandLord+Seler',  
                ],
                'theme'         => kartik\select2\Select2::THEME_BOOTSTRAP,
                'options'       => ['placeholder' => 'Select a contact source'],
                'pluginOptions' => [
                    'tags' => true,
                    'tokenSeparators' => [',', ' '],
                    'maximumInputLength' => 10
                ],
            ]
        ); 
    ?>

    <?= $form->field($model, 'created_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'notes')->widget(
            mihaildev\ckeditor\CKEditor::className(),[
                'editorOptions' => [
                    'preset' => 'full',
                    'inline' => false, 
                ],
            ]
        ) 
    ?>

    <?= $form->field($model, 'documents')->textInput(['maxlength' => true]) ?>