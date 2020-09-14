<?php
use yii\bootstrap\Modal;
use yii\bootstrap\Tabs;

Modal::begin([
    'id'     => 'modal-share-matching-properties-alert',
    'header' => '<h4>' . Yii::t('app', 'Share matching properties') . '</h4>'
]);
echo Yii::t('app', 'Please, check data for sharing');
Modal::end();

Modal::begin([
    'id'     => 'modal-share-matching-properties',
    'header' => '<h4>' . Yii::t('app', 'Share matching properties') . '</h4>'
]);
?>

<?= Tabs::widget([
    'items' => [
        [
            'label'   => Yii::t('app', 'Send links'),
            'content' => $this->render('@app/views/modals/shareMatchingProperties/parts/_sendLinks', [
                    'model' => $model
                ])
        ],
        [
            'label'   => Yii::t('app', 'Send PDF'),
            'content' => $this->render('@app/views/modals/shareMatchingProperties/parts/_sendPdf', [
                    'model' => $model
                ])
        ]
    ]
])?>

<?php
Modal::end();
?>