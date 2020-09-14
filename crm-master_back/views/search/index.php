<?php
use yii\helpers\{Html, Url};
?>
<div>
    <?= Yii::t('app', 'Search result for ') . '"' . $searchValue . '"'?>
</div>

<div>
    <h3>
        <?= Yii::t('app', 'Rentals')?>
    </h3>
</div>
<div>
    <?php if ($rentals) {?>
        <?php foreach($rentals as $r) {?>
            <div>
                <?= Html::a(
                    $r['ref'],
                    Yii::$app->getUrlManager()->createUrl([
                        'rentals/view',
                        'id'   => $r['id'],
                    ]),
                    [
                        'target' => '_blank'
                    ]
                )
                ?>
            </div>
        <?php }?>
    <?php } else {?>
        <?= Yii::t('app', 'No results found')?>
    <?php }?>
</div>

<div>
    <h3>
        <?= Yii::t('app', 'Sales')?>
    </h3>
</div>
<div>
    <?php if ($sales) {?>
        <?php foreach($sales as $s) {?>
            <div>
                <?= Html::a(
                    $s['ref'],
                    Yii::$app->getUrlManager()->createUrl([
                        'sale/view',
                        'id'   => $s['id'],
                    ]),
                    [
                        'target' => '_blank'
                    ]
                )
                ?>
            </div>
        <?php }?>
    <?php } else {?>
        <?= Yii::t('app', 'No results found')?>
    <?php }?>
</div>

<div>
    <h3>
        <?= Yii::t('app', 'Contacts')?>
    </h3>
</div>
<div>
    <?php if ($contacts) {?>
        <?php foreach($contacts as $c) {?>
            <div>
                <?= Html::a(
                    $c['ref'],
                    Yii::$app->getUrlManager()->createUrl([
                        'contacts/view',
                        'id'   => $c['id'],
                    ]),
                    [
                        'target' => '_blank'
                    ]
                )
                ?>
            </div>
        <?php }?>
    <?php } else {?>
        <?= Yii::t('app', 'No results found')?>
    <?php }?>
</div>

<div>
    <h3>
        <?= Yii::t('app', 'Leads')?>
    </h3>
</div>
<div>
    <?php if ($leads) {?>
        <?php foreach($leads as $l) {?>
            <div>
                <?= Html::a(
                    $l['reference'],
                    Yii::$app->getUrlManager()->createUrl([
                        'leads/view',
                        'id'   => $l['id'],
                    ]),
                    [
                        'target' => '_blank'
                    ]
                )
                ?>
            </div>
        <?php }?>
    <?php } else {?>
        <?= Yii::t('app', 'No results found')?>
    <?php }?>
</div>