<?php
/* @var $model app\modules\import_export\models\ImportXML */
/* @var $this yii\web\View */


use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\modules\ImportExport\models\XmlParser;


?>
<?php $this->title = 'Import module'; ?>
<?php $this->params['breadcrumbs'][] = $this->title; ?>

<?php IF ($model->success == false): ?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'xmlFile')->fileInput() ?>
    <button>Submit</button>
    <?php ActiveForm::end(); ?>
<?php ELSE: ?>
    <?= 'Uploaded successfully' ?>
<?php ENDIF; ?>


<?php

/**
 * testing don`t touch please
 */

$file = '2_2017-09-27_58655_xml-feed-example.xml';

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/app/yii2/uploads/' . $file)) {
    $xml = new XmlParser($file);
    $xml->testShow();
} else {
    echo '<testing>file not found</testing>';
}

?>