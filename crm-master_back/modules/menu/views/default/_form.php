<?php

use app\modules\menu\models\MenuItems;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dominus77\iconpicker\IconPicker;


/* @var $this yii\web\View */
/* @var $model app\modules\menu\models\MenuItems */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $iconClasses = \app\models\FontAwesomeIconsList::find()->select(['id', 'icon_class'])->all() ?>
<div class="menu-items-form">

    <?php
    $i = \yii\helpers\ArrayHelper::toArray(
        MenuItems::find()
            ->with('parent')
            ->where(['status' => 1])
            ->all(),
        [
            'app\modules\menu\models\MenuItem' => [
                'id', 'title', 'uri', 'status', 'class', 'icon','parent_id',
                'parent_title' => function ($item) {
                    return strlen($item->parent);
                },
            ],
        ]
    ); print_r($i);

    $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uri')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([1 => 'active', 0 => 'disabled']) ?>

    <?= $form->field($model, 'class')->textInput(['maxlength' => true]) ?>

    <?php
        $menuItems = MenuItems::find()->where(['status' => 1])->all();
        $items = ArrayHelper::map($menuItems, 'id', 'title');
        $params = [
            'prompt' => Yii::t('app', 'Choose parent item')
        ];
        echo $form->field($model, 'parent_id')->dropDownList($items, $params);
    ?>


    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
