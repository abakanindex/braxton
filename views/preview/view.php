<?php
use yii\bootstrap\Carousel;
use yii\helpers\Url;

$itemsGallery = array();

foreach($model->gallery as $g) {
    $itemsGallery[] = array('content' => '<img src="' . $g->path . '">');
}
?>
<title> <?= $model->beds?> BR <?= $model->category->title?> for <?php if($flagSale):?> sale <?php else:?> rental <?php endif;?> - Ref: <?= $model->ref?></title>
<div class="preview-wrap">
<div class="preview-head">
    <div class="preview-left">
        <span class="head-name">
            For <?php if($flagSale):?> sale <?php else:?> rental <?php endif;?> - Ref: <?= $model->ref?>
            <br/>
            <?= $model->name?>
        </span>
        <span class="head-property">
            <?= $model->emirate->name?>, <?= $model->location->name?>, <?= $model->subLocation->name?>
        </span>
    </div>
    <div class="preview-right">
        <img src="<?= $modelProfileCompany->logo ?>"/>
    </div>

</div>

<div class="preview-property">
    <div class="preview-property-head">
        <div class="preview-left">
                    <span class="head-name">
                    </span>
                    <span class="head-property">
                    </span>
                    <span class="head-property">
                    </span>
        </div>
        <div class="preview-right">
                    <span class="head-name">
                        Price: AED <?= Yii::$app->formatter->asDecimal($model->price)?>
                    </span>
                    <span class="head-property">
                        Deposit: AED <?= $model->deposit?>
                    </span>
        </div>
    </div>
    <div class="preview-property-gallery preview-left">
        <?= Carousel::widget([
            'items'    => $itemsGallery,
            'options'  => ['class' => 'carousel slide', 'data-interval' => '12000'],
            'controls' => [
                '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>',
                '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>'
            ]
        ]); ?>
    </div>
    <div class="preview-property-option preview-right">
        <ul class="button-group">
            <li><a class="btn color-button-gray" type="button" href="#"><i class="fa fa-facebook"></i>Share on Facebook</a></li>
            <li><a class="btn color-button-gray" type="button" href="#"><i class="fa fa-twitter-square"></i>Share on Twitter</a></li>
            <li><a class="btn color-button-gray" type="button" href="#"><i class="fa fa-linkedin"></i>Share on LinkedIn</a></li>
            <li><a class="btn color-button-gray" type="button" href="#"  onclick="window.print()"><i class="fa fa-print"></i>Print</a></li>
            <li><a class="btn color-button-gray" type="button" href="#"><i class="fa fa-eye"></i>Request to View</a></li>
            <li><a class="btn color-button-gray" type="button" href="#"><i class="fa fa-user"></i>Send to Friend</a></li>
        </ul>
        <div class="summary">
            <table class="table table-striped">
                <tbody>
                <tr>
                    <td>Category:</td>
                    <td><?= $model->category->title?></td>
                </tr>
                <tr>
                    <td>Emirate:</td>
                    <td><?= $model->emirate->name?></td>
                </tr>
                <tr>
                    <td>Location:</td>
                    <td><?= $model->location->name?></td>
                </tr>
                <tr>
                    <td>Sub-location:</td>
                    <td><?= $model->subLocation->name?></td>
                </tr>
                <tr>
                    <td>No. of Beds:</td>
                    <td><?= $model->beds?></td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>AED  <?= Yii::$app->formatter->asDecimal($model->price)?></td>
                </tr>
                <tr>
                    <td>Deposit:</td>
                    <td>AED  <?= $model->deposit?></td>
                </tr>
                <tr>
                    <td>Area:</td>
                    <td><?= $model->size?></td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>




<div class="preview-content-block">
    <div class="preview-content-title">
        Agent Information
    </div>
    <div class="preview-content-info">
        <div class="content-two">
            <table class="table agent-info">
                <tbody>
                <tr>
                    <td>Company Name:</td>
                    <td><?= $model->agent->companyName->company_name?></td>
                </tr>
                <tr>
                    <td>Agent Name:</td>
                    <td class="text-capitalize"><?= $model->agent->username?></td>
                </tr>
                <tr>
                    <td>Mobile:</td>
                    <td><?= $model->agent->mobile_no?></td>
                </tr>
                <tr>
                    <td>Licence Number:</td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="content-two">
            <img class="content-logo" src="<?= $modelProfileCompany->logo ?>"/>
        </div>
    </div>
</div>


<div class="preview-content-block">
    <div class="preview-content-title">
        Location
    </div>
    <div class="preview-content-info">
        <div id="googleMap"></div>
    </div>
</div>



<div class="preview-content-block">
    <div class="preview-content-title">
        Description
    </div>
    <div class="preview-content-info">
        <p>
            <?= $model->description?>
        </p>
    </div>
</div>



<div class="preview-content-block">
    <div class="preview-content-title">
        DLD Permit
    </div>
    <div class="preview-content-info">
        <p><?= $model->rera_permit?></p>
    </div>
</div>



<div class="preview-content-block">
    <div class="preview-content-title">
        Features
    </div>
    <div class="preview-content-info">
        <p>
            <?= $model->features?>
        </p>
    </div>
</div>




<div class="preview-content-block">
    <div class="preview-content-title">
        Disclaimer
    </div>
    <div class="preview-content-info">
        <p>These particulars are intended to give a fair description of the property but their accuracy cannot be guaranteed, and they do not constitute an offer of contract. Intending purchasers must rely on their own inspection of the property. None of the above appliances/services have been tested by ourselves. We recommend purchasers arrange for a qualified person to check all appliances/services before legal commitment.</p>
    </div>
</div>


<div class="preview-content-block">
    <div class="preview-content-title">
        Contact
    </div>
    <div class="preview-content-info">
        <div class="content-three left-align">
            <?php if($model->agent):?>
                <p class="bold-text"><?= $model->agent->last_name . ' ' . $model->agent->first_name?></p>
                <p><?= $model->agent->getAttributeLabel('mobile_no')?>: <?= $model->agent->mobile_no;?></p>
                <p><?= $model->agent->getAttributeLabel('email')?>: <?= $model->agent->email;?></p>
            <?php endif;?>
        </div>


        <div class="content-three">
            <img class="content-logo" src="<?= $modelProfileCompany->logo ?>"/>
        </div>
    </div>
</div>


<div class="preview-footer">

    <div class="preview-left footer-copyright">
        <img height="20px" src="<?=Url::to('@web/new-design/img/logo-lg.png')?>">
    </div>
    <div class="preview-right footer-action">
        <a href="#" onclick="window.print()">Print</a>
    </div>

</div>

</div>

<?= $this->render('@app/views/scripts/_preview', [
    'model' => $model
])?>
