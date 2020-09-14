<?php
use yii\widgets\Pjax;
?>
<div class="color-blue">
    <?= Yii::t('app', 'Matching Properties'); ?>
</div>
<div>
    <div>
        <input type="radio" name="match-for-lead-condition" checked value="1">
        <span class="color-green"><?= Yii::t('app', 'View Exact Matches'); ?></span>
    </div>
    <div>
        <input type="radio" name="match-for-lead-condition" value="2">
        <span class="color-green"><?= Yii::t('app', 'View Similar Properties'); ?></span>
    </div>
    <?php Pjax::begin(['id' => 'pjax-matching-properties']); ?>
    <div id="match-properties-block">
        <?php if (!$salesMatchProperties && !$rentalsMatchProperties) {?>
            <span class="text-danger f-w-bold"><?= Yii::t('app', 'Not found')?></span>
        <?php } else {?>
            <input type="checkbox" id="check-all-matching-item"><?= Yii::t('app', 'Check all')?>
            <br/>
            <a href="#" id="btn-call-modal-share-matching"><?= Yii::t('app', 'Share information')?></a>
            <?php foreach($salesMatchProperties as $sM):?>
                <?php
                $url = Yii::$app->getUrlManager()->createUrl([
                    'sale/view',
                    'id'   => $sM['id'],
                ]);
                ?>
                <div class="match-item">
                    <div class="margin-bottom-5 f-w-bold">
                        <input type="checkbox" class="check-matching-item" data-ref="<?= $sM['ref']?>">
                        <a href="<?= $url?>" target="_blank" data-pjax="0">
                            <?= $sM['beds']?> bed(-s) <?= $sM['category_title']?> in
                            <?= $sM['region_name']?>, <?= $sM['area_name']?>, <?= $sM['sub_area_name']?>
                        </a>
                    </div>
                    <div class="margin-bottom-5">
                        <input type="button" class="btn btn-info create-viewing-set-data" value="<?= Yii::t('app', 'Create viewing')?>" data-ref="<?= $sM['ref']?>">
                    </div>
                    <div class="margin-bottom-5">
                        <?= $sM['ref']?>
                    </div>
                    <div class="margin-bottom-5">
                        Type: <?= Yii::t('app', 'Sale')?>
                    </div>
                    <div class="margin-bottom-5">
                        Floor: <?= $sM['floor_no']?>
                    </div>
                    <div>
                        <i class="fa fa-usd" aria-hidden="true"></i> AED <?= $sM['price']?>
                        <br/>
                        <i class="fa fa-home"></i> <?= $sM['size']?>
                    </div>
                </div>
            <?php endforeach;?>
            <?php foreach($rentalsMatchProperties as $rM):?>
                <?php
                $url = Yii::$app->getUrlManager()->createUrl([
                    'rentals/view',
                    'id'   => $rM['id'],
                ]);
                ?>
                <div class="match-item">
                    <div class="margin-bottom-5 f-w-bold">
                        <input type="checkbox" class="check-matching-item" data-ref="<?= $rM['ref']?>">
                        <a href="<?= $url?>" target="_blank" data-pjax="0">
                            <?= $rM['beds']?> bed(-s) <?= $rM['category_title']?> in
                            <?= $rM['region_name']?>, <?= $rM['area_name']?>, <?= $rM['sub_area_name']?>
                        </a>
                    </div>
                    <div class="margin-bottom-5">
                        <input type="button" class="btn btn-info create-viewing-set-data" value="<?= Yii::t('app', 'Create viewing')?>" data-ref="<?= $rM['ref']?>">
                    </div>
                    <div class="margin-bottom-5">
                        <?= $rM['ref']?>
                    </div>
                    <div class="margin-bottom-5">
                        Type: <?= Yii::t('app', 'Rent')?>
                    </div>
                    <div>
                        <i class="fa fa-usd" aria-hidden="true"></i> AED <?= $rM['price']?>
                        <i class="fa fa-home"></i> <?= $rM['size']?>
                    </div>
                </div>
            <?php endforeach;?>
        <?php }?>
    </div>
    <?php Pjax::end()?>
</div>