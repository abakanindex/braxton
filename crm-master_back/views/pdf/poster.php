<?php
use Yii;
?>

<div style="">
    <div class="" style="background: #000000; color: white;padding: 20px">
        <div class="" style="float: left; width: 50%;">
            <div style="font-size: 20px;"><?= $model->beds?> <?= Yii::t('app', 'bed(-s)')?> <?= $model->category->title?></div>
            <div style="font-size: 18px;"><?= $model->emirate->name?>, <?= $model->location->name?>, <?= $model->subLocation->name?></div>
            <div><?= 'AED ' . Yii::$app->formatter->asDecimal($model->price)?></div>
        </div>
        <div class="" style="float: left; width: 50%;">
            <span style="font-size: 35px"><?= $type?></span>
        </div>
        <div style="clear: both"></div>
    </div>

    <div class="" style="background-color: #e2e2e2; padding: 20px">
        <div class="" style="float: left; width: 50%;">
            <?php foreach($model->gallery as $gal):?>
                <img src="<?= $gal->path?>" style="width: 200px; height: auto; margin-bottom: 10px;">
            <?php endforeach;?>
            <div style="background-color: #000000; color: white; padding: 20px">
                <div style="font-size: 20px;">
                    <?= Yii::t('app', 'Property Details')?>
                </div>
                <div style="font-size: 16px;">
                    <?= $model->getAttributeLabel('ref');?>:
                    <?= $model->ref;?>
                </div>
                <div style="font-size: 16px;">
                    <?= $model->getAttributeLabel('beds');?>:
                    <?= $model->beds;?>
                </div>
                <div style="font-size: 16px;">
                    <?= $model->getAttributeLabel('baths');?>:
                    <?= $model->baths;?>
                </div>
                <div style="font-size: 16px;">
                    <?= $model->getAttributeLabel('size');?>:
                    <?= $model->size;?>
                </div>
                <div style="font-size: 16px;">
                    <?= $model->getAttributeLabel('plot_size');?>:
                    <?= $model->plot_size;?>
                </div>
                <div style="font-size: 16px;">
                    <?= $model->getAttributeLabel('view_id');?>:
                    <?= $model->view_id;?>
                </div>
            </div>
        </div>
        <div class="" style="float: left; width: 50%;">
            <div>
                <h3><?= $model->name?></h3>
            </div>
            <div style="font-size: 13px;">
                <?= $model->description?>
            </div>
            <div>
                <h3><?= Yii::t('app', 'Agent Details')?></h3>
                <?php if($agentDetails == 1) {?>
                    <div><?= $user->last_name . ' ' . $user->first_name?></div>
                    <div><?= $user->mobile_no?></div>
                    <div><?= $user->email?></div>
                <?php } else {?>
                    <div><?= $model->agent->last_name . ' ' . $model->agent->first_name?></div>
                    <div><?= $model->agent->mobile_no?></div>
                    <div><?= $model->agent->email?></div>
                <?php }?>
            </div>
        </div>
        <div style="clear: both"></div>
    </div>
</div>

