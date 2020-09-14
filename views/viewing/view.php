<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Viewings;

/**
 * @var $model
 */

$this->title = Yii::t('app', 'Viewing');
?>

<div class="reminder-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table">
        <tbody>
            <tr>
                <th scope="row"><?= Yii::t('app', 'Id') ?></th>
                <td><?= $model->id ?></td>
            </tr>
            <tr>
                <th scope="row"><?= Yii::t('app', 'Client Name') ?></th>
                <td><?= $model->client_name ?></td>
            </tr>
            <tr>
                <th scope="row"><?= Yii::t('app', 'Viewing Date') ?></th>
                <td><?= $model->date ?></td>
            </tr>
            <tr>
                <th scope="row"><?= Yii::t('app', 'Agent') ?></th>
                <td><?= $model->first_name . ' ' . $model->last_name ?></td>
            </tr>
            <tr>
                <th scope="row"><?= Yii::t('app', 'Note') ?></th>
                <td><?= $model->note ?></td>
            </tr>
            <tr>
                <th scope="row"><?= Yii::t('app', 'Referral') ?></th>
                <td><?= $model->ref ?></td>
            </tr>
            <tr>
                <th scope="row"><?= Yii::t('app', 'Listing Referral') ?></th>
                <td><?= $model->listing_ref ?></td>
            </tr>
            <tr>
                <th scope="row"><?= Yii::t('app', 'Status') ?></th>
                <td><?= Viewings::$statuses[$model->status] ?></td>
            </tr>
        </tbody>
    </table>

    <?php if ($model->is_report_complete) : ?>
        <h1><?= Yii::t('app', 'Viewing Report') ?></h1>

        <table class="table">
            <tbody>
            <tr>
                <th scope="row"><?= Yii::t('app', 'Title') ?></th>
                <td><?= $model->report_title ?></td>
            </tr>
            <tr>
                <th scope="row"><?= Yii::t('app', 'Description') ?></th>
                <td><?= $model->report_description ?></td>
            </tr>
            </tbody>
        </table>
    <?php endif; ?>
</div>