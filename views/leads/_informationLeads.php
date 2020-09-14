<?php
    use app\models\agent\Agent;
    use app\models\Reminder;
    use app\modules\lead_viewing\models\LeadViewing;
    use app\components\widgets\ReminderWidget;
    use lo\widgets\modal\ModalAjax;
    use rmrevin\yii\fontawesome\FA;
    use yii\bootstrap\Tabs;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\DetailView;
    use yii\widgets\ListView;
    use yii\widgets\Pjax;
    use yii\helpers\ArrayHelper;

    $types  = \app\modules\lead\models\LeadType::find()->all();
    $items  = ArrayHelper::map($types, 'id', 'title');
    $params = [
        'prompt' => Yii::t('app', 'Select type')
    ];
?>

<div class="container-fluid contact-left-block col-md-4"><!-- Left Contact part-->
    <div class="contact-top-column-height">
        <div class="contact-big-block"><!-- Owner -->
            <div class="owner-head">
                <div class="owner-name">
                    <h4>Lead</h4>
                </div>
            </div>
            <div class="owner-property property-list">
                <p><i class="fa fa-user"></i><?= $model->first_name ?> <?= $model->last_name ?></p>
                <p><i class="fa fa-mobile"></i><?= $model->mobile_number ?></p>
                <p><i class="fa fa-envelope"></i><?= $model->email ?></p>
            </div>
        </div><!--/Owner-->
    </div>
    <div class="contact-bottom-column-height">
        <div class="contact-small-block">
            <h3>Lead information</h3>
            <div class="property-list">
                <?= DetailView::widget([
                    'model'    => $model,
                    'attributes' => $attributesDetailView,
//                    'template' => function($attribute, $index, $widget) use ($model) {
//                            if($attribute['value']) {
//                                switch($attribute['attribute']) {
//                                    case 'type_id':
//                                        $label = $attribute['label'];
//                                        $value = $model->getType();
//                                        break;
//                                }
//                                if ($label && $value)
//                                    return "<tr><th>{$label}</th><td>{$value}</td></tr>";
//                            }
//                        },
                ])?>
            </div>
        </div>
    </div>
</div><!-- /Left Contact part-->