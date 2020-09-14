<?php
use yii\bootstrap\Modal;
use Yii;
?>

<?php Modal::begin([
    'id'     => 'modal-download-brochure',
    'header' => Yii::t('app', 'Download PDF Brochure')
])
?>
    <div class="">
        <div>
            <?= Yii::t('app', 'Would you like to download the PDF brochure with your details or with the details of the listing agent?')?>
        </div>
        <div class="row">
            <div class="col-md-6">
                <input type="radio" class="height-auto" name="agent-brochure-to-generate" checked value="1"><?= Yii::t('app', 'My details')?>
            </div>
            <div class="col-md-6">
                <input type="radio" class="height-auto" name="agent-brochure-to-generate" value="2"><?= Yii::t('app', '	Listing agents details')?>
            </div>
        </div>
        <a href="#" class="text-primary text-decoration-none" id="link-download-brochure">
            <i class="fa fa-file-pdf-o fa-5x"></i>
            <br/>
            <?= Yii::t('app', 'Download')?>
        </a>
    </div>
<?php Modal::end();?>