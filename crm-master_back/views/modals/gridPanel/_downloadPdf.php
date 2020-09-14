<?php
use yii\bootstrap\Modal;
?>

<?php Modal::begin([
    'id'     => 'modal-download-pdf'
])
?>
<div class="text-center">
    <a href="#" class="text-primary text-decoration-none" id="link-download-pdf" data-pjax="0">
        <i class="fa fa-file-pdf-o fa-5x"></i>
        <br/>
        <?= Yii::t('app', 'Download')?>
    </a>
</div>
<?php Modal::end();?>