<?php
use Yii;
?>

<div style="text-align: center">
    <div style="color: #203D9B; font-weight: bold">
        <?= $model->ref?> - <?= $model->name?>
    </div>
    <div>
        <?= $model->description?>
    </div>
</div>

<div>
    <div style="text-align: center;">
        <h3><?= Yii::t('app', 'Location')?></h3>
        <div style="color: #203D9B; font-weight: bold">
            <?= $model->emirate->name?>|<?= $model->location->name?>|<?= $model->subLocation->name?>
        </div>
    </div>
    <div style="text-align:center">
        <img style= src='https://maps.googleapis.com/maps/api/staticmap?center=<?= $model->latitude?>,<?= $model->longitude?>&markers=color:blue%7Clabel:Place%7C<?= $model->latitude?>,<?= $model->longitude?>&zoom=13&size=700x250&maptype=roadmap&key=AIzaSyDLqOx_cg_0waZsiOwEThXTBwGbpFi46tc'>
    </div>
</div>

<div>
    <div style="text-align: center; margin-top: 30px">
        <div style="color: #203D9B; font-weight: bold">
            <?= $model->ref?> - <?= $model->name?>
        </div>
    </div>

    <div style="text-align: center; margin-bottom: 15px;">
        <h3><?= Yii::t('app', 'Data sheet')?></h3>
    </div>

    <div style="margin-bottom: 15px;">
        <div style="float: left; width: 15%">
            <span style="color: #203D9B;"><?= Yii::t('app', 'Model')?>:</span>
        </div>
        <div style="float: left; width: 85%">
            <span style="color: #7d7d7d; display: inline-block;"><?= $model->name?></span>
        </div>
    </div>
    <div style="margin-bottom: 15px;">
        <div style="float: left; width: 15%">
            <span style="color: #203D9B;"><?= Yii::t('app', 'No. of Bedrooms')?>:</span>
        </div>
        <div style="float: left; width: 85%">
            <span style="color: #7d7d7d;"><?= $model->beds?></span>
        </div>
    </div>
    <div style="margin-bottom: 15px;">
        <div style="float: left; width: 15%">
            <span style="color: #203D9B;"><?= Yii::t('app', 'No. of Baths')?>:</span>
        </div>
        <div style="float: left; width: 85%">
            <span style="color: #7d7d7d;"><?= $model->baths?></span>
        </div>
    </div>
    <div style="margin-bottom: 15px;">
        <div style="float: left; width: 15%">
            <span style="color: #203D9B;"><?= Yii::t('app', 'View')?>:</span>
        </div>
        <div style="float: left; width: 85%">
            <span style="color: #7d7d7d;"><?= $model->view_id?></span>
        </div>
    </div>
    <div style="margin-bottom: 15px;">
        <div style="float: left; width: 15%">
            <span style="color: #203D9B;"><?= Yii::t('app', 'Plot size')?>:</span>
        </div>
        <div style="float: left; width: 85%">
            <span style="color: #7d7d7d;"><?= $model->plot_size?></span>
        </div>
    </div>
    <div style="margin-bottom: 15px;">
        <div style="float: left; width: 15%">
            <span style="color: #203D9B;"><?= Yii::t('app', 'Price')?>:</span>
        </div>
        <div style="float: left; width: 85%">
            <span style="color: #7d7d7d;">AED <?= Yii::$app->formatter->asDecimal($model->price)?></span>
        </div>
    </div>
    <div>
        <div style="float: left; width: 15%">
            <span style="color: #203D9B;"><?= Yii::t('app', 'Features')?>:</span>
        </div>
        <div style="float: left; width: 85%">
            <?php foreach($model->featureListing as $fL):?>
                <span style="color: #7d7d7d;"><?= '-' . $fL->feature->features?></span>
                <br/>
            <?php endforeach?>
        </div>
    </div>
</div>


<div>
    <?php foreach($model->gallery as $gal):?>
        <img src="<?= $gal->path?>">
    <?php endforeach;?>
</div>