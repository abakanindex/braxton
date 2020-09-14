<?php
use app\modules\notifications\widgets\NotificationsWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\admin\Rbac;
use app\models\User;
use yii\bootstrap\Alert;

?>
<!---     Content       -->
<div id="content" class="container-fluid clearfix">
    <?php if(Yii::$app->session->getFlash('alerts')):?>
        <br/>
        <?= Alert::widget([
            'options' => [
                'class' => 'alert-info',
            ],
            'body' => Yii::$app->session->getFlash('alerts'),
        ]);
        ?>
    <?php elseif(Yii::$app->session->getFlash('warning')): ?>
    <br/>
        <?= Alert::widget([
            'options' => [
                'class' => 'alert-warning',
            ],
            'body' => Yii::$app->session->getFlash('warning'),
        ]);
        ?>
    <?php endif; ?>
    <?= $content ?>
</div><!---     Content       -->