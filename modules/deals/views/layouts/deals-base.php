<?php

use yii\bootstrap\Tabs;
use yii\helpers\Url;

/**
 * @var $content
 */

?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>
    <div style="margin-top: 15px" class="deals-head">
        <?= $this->blocks['deals-head-block'] ?>
    </div>
        <?php

        try {
            echo Tabs::widget([
                'navType' => 'nav-tabs',
                'id' => 'deals-head-tabs',
                'items' => [
                    [
                        'label' => Yii::t('app', 'Deals'),
                        'content' => $this->context->id === 'deals' ? '<br>' . $content : '',
                        'url' => Url::to(['/deals/deals/index']),
                        'active' => $this->context->id === 'deals' ? true : false,
                        'options' => [
//                                'id' => 'recently-viewed-reports',
//                                'class' => 'fade in active',
                        ],
                    ],
//                    [
//                        'label' => Yii::t('app', 'Deals International'),
//                        'content' => $this->context->id === 'deals-international' ? '<br>' . $content : '',
//                        'url' => Url::to(['/deals/deals-international/index']),
//                        'active' => $this->context->id === 'deals-international' ? true : false,
//                    ],
//                    [
//                        'label' => Yii::t('app', 'Addendum Templates'),
//                        'content' => $this->context->id === 'addendum-templates' ? '<br>' . $content : '',
//                        'url' => Url::to(['/deals/addendum-templates/index']),
//                        'active' => $this->context->id === 'addendum-templates' ? true : false,
//                    ],
                ],
            ]);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        ?>
<?php $this->endContent(); ?>