<?php
use yii\bootstrap\Modal;
use Yii;
?>

<?php Modal::begin([
    'id'     => 'modal-download-poster',
    'header' => Yii::t('app', 'Download A3 Poster')
])
?>
    <div class="">
        <div>
            <?= Yii::t('app', 'Would you like to download the Poster with your details or with the details of the listing agent?')?>
        </div>
        <div class="row">
            <div class="col-md-6">
                <input type="radio" class="height-auto" name="agent-details-to-generate" checked value="1"><?= Yii::t('app', 'My details')?>
            </div>
            <div class="col-md-6">
                <input type="radio" class="height-auto" name="agent-details-to-generate" value="2"><?= Yii::t('app', '	Listing agents details')?>
            </div>
        </div>
        <a href="#" class="text-primary text-decoration-none" id="link-download-poster">
            <i class="fa fa-file-pdf-o fa-5x"></i>
            <br/>
            <?= Yii::t('app', 'Download')?>
        </a>
    </div>
<?php Modal::end();?>