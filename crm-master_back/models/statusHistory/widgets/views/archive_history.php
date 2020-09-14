<?php

/* @var $this yii\web\View */
/* @var $modelHistory app\models\statusHistory\ArchiveHistory */
/* @var $tag_id string */
/* @var $tag_class string */
/* @var $icon string */

use app\models\{Leads, Locations, User, Contacts};
use app\modules\lead\models\LeadSubStatus;
use app\models\reference_books\{ContactSource, Portals, Features};


?>

    <ul<?= ($tag_id ? ' id="' . $tag_id . '"' : '') . ($tag_class ? ' class="' . $tag_class . '"' : '') ?>>
    <?php foreach ($modelHistory as $model): ?>
    <ul>
        <?php foreach ($model as $key => $value):
        if (!empty($value)): ?>
            <?php 

                switch($key) {
                    case 'Status'; ?>
                        <li>
                        <?= $icon ? '<i class="' . $icon . '"></i>' : '' ?>
                            <b><?= $key ?>:</b> <?= $key == 'Updated Time' ? Yii::$app->formatter->asDate($value, 'php:Y-m-d H:i:s') : (new Leads)->getStatuses()[$value] ?>
                        </li>
                    <?php break; ?>
                    <?php case 'Sub Status'; ?>
                        <li>
                        <?= $icon ? '<i class="' . $icon . '"></i>' : '' ?>
                            <b><?= $key ?>:</b> <?= $key == 'Updated Time' ? Yii::$app->formatter->asDate($value, 'php:Y-m-d H:i:s') : LeadSubStatus::findOne($value)->title; ?>
                        </li>
                    <?php break; ?>
                    <?php case 'Company'; ?>
                    <?php break; ?>
                    <?php case 'Type'; ?>
                        <li>
                        <?= $icon ? '<i class="' . $icon . '"></i>' : '' ?>
                            <b><?= $key ?>:</b> <?= $key == 'Updated Time' ? Yii::$app->formatter->asDate($value, 'php:Y-m-d H:i:s') : (new Leads)->getType($value)?>
                        </li>
                    <?php break; ?>
                    <?php case 'Latitude'; ?>
                    <?php break; ?>
                    <?php case 'Source'; ?>
                        <li>
                        <?= $icon ? '<i class="' . $icon . '"></i>' : '' ?>
                            <b><?= $key ?>:</b> <?= $key == 'Updated Time' ? Yii::$app->formatter->asDate($value, 'php:Y-m-d H:i:s') : ContactSource::findOne($value)->source  ?>
                        </li>
                    <?php break; ?>
                    <?php case 'Created By'; ?>
                    <?php break; ?>
                    <?php case 'Finance Type'; ?>
                        <li>
                        <?= $icon ? '<i class="' . $icon . '"></i>' : '' ?>
                            <b><?= $key ?>:</b> <?= $key == 'Updated Time' ? Yii::$app->formatter->asDate($value, 'php:Y-m-d H:i:s') : (new Leads)->getFinanceType($value)  ?>
                        </li>
                    <?php break; ?>
                    <?php case 'Longitude'; ?>
                    <?php break; ?>
                    <?php case 'Updated Time'; ?>
                    <?php break; ?>
                    <?php case 'Category'; ?>
                        <li>
                            <?= $icon ? '<i class="' . $icon . '"></i>' : '' ?>
                                <b><?= $key ?>:</b> <?= $key == 'Updated Time' ? Yii::$app->formatter->asDate($value, 'php:Y-m-d H:i:s') : ContactSource::findOne($value)->source ?>
                        </li>
                    <?php break; ?>
                    <?php case 'Emirate'; ?>
                        <li>
                            <?= $icon ? '<i class="' . $icon . '"></i>' : '' ?>
                                <b><?= $key ?>:</b> <?= $key == 'Updated Time' ? Yii::$app->formatter->asDate($value, 'php:Y-m-d H:i:s') : Locations::findOne($value)->name ?>
                        </li>
                    <?php break; ?>
                    <?php case 'Location'; ?>
                        <li>
                            <?= $icon ? '<i class="' . $icon . '"></i>' : '' ?>
                                <b><?= $key ?>:</b> <?= $key == 'Updated Time' ? Yii::$app->formatter->asDate($value, 'php:Y-m-d H:i:s') : Locations::findOne($value)->name ?>
                        </li>
                    <?php break; ?>
                    <?php case 'Sub-Location'; ?>
                        <li>
                            <?= $icon ? '<i class="' . $icon . '"></i>' : '' ?>
                                <b><?= $key ?>:</b> <?= $key == 'Updated Time' ? Yii::$app->formatter->asDate($value, 'php:Y-m-d H:i:s') : Locations::findOne($value)->name ?>
                        </li>
                    <?php break; ?>
                    <?php case 'Priority'; ?>
                        <li>
                        <?= $icon ? '<i class="' . $icon . '"></i>' : '' ?>
                            <b><?= $key ?>:</b> <?= $key == 'Updated Time' ? Yii::$app->formatter->asDate($value, 'php:Y-m-d H:i:s') : (new Leads)->getPriority($value)?>
                        </li>
                    <?php break; ?>
                    <?php case 'Owner'; ?>
                        <li>
                        <?= $icon ? '<i class="' . $icon . '"></i>' : '' ?>
                            <b><?= $key ?>:</b> <?= $key == 'Updated Time' ? Yii::$app->formatter->asDate($value, 'php:Y-m-d H:i:s') : Contacts::findOne(['id' => $value])->first_name ?>
                        </li>
                    <?php break; ?>
                    <?php case 'Features'; ?>
                        <?php if($value != 'Array'): ?>
                            <b><?= $key ?>:</b>
                            </li>
                                <?php foreach (explode(',', $value) as $keyfech => $valuefech): ?>
                                    <?= Features::findOne(['id' => $valuefech])->features; ?>,
                                <?php endforeach;?>
                            <li>
                        <?php endif; ?>
                    <?php break; ?>
                    <?php case 'Portals'; ?>
                        <?php if($value != 'Array'): ?>
                            <b><?= $key ?>:</b>
                            </li>
                                <?php foreach (explode(',', $value) as $keyport => $valueport): ?>
                                    <?= Portals::findOne(['id' => $valueport])->portals; ?>,
                                <?php endforeach;?>
                            <li>
                        <?php endif; ?>
                    <?php break; ?>
                    <?php default; ?>
                        <li>
                            <?= $icon ? '<i class="' . $icon . '"></i>' : '' ?>
                                <b><?= $key ?>:</b> <?= $key == 'Updated Time' ? Yii::$app->formatter->asDate($value, 'php:Y-m-d H:i:s') : $value ?>
                        </li>
                    <?php
                    break;
                }
            
            ?>      
    
        <?php endif;
        endforeach; ?>
    </ul>
    <br />
    <?php endforeach; ?>
    </ul>
