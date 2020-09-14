<?php
use yii\helpers\Html;
use yii\bootstrap\Tabs;

/**
 * @var $eventsProvider
 * @var $taskManagerProvider
 * @var $viewingsProvider
 */
echo Tabs::widget([
    'items' => [
        [
            'label' => Yii::t('app', 'Events'),
            'active' => true,
            'content' => $this->render('@app/components/widgets/views/calendarDashboard/partials/events-list-table', [
                'eventsProvider' => $eventsProvider,
            ]),
        ],
        [
            'label' => Yii::t('app', 'Tasks'),
            'content' => $this->render('@app/components/widgets/views/calendarDashboard/partials/deadline-list-table', [
                'eventsProvider' => $taskManagerProvider,
            ]),
        ],
        [
            'label' => Yii::t('app', 'Viewings'),
            'content' => $this->render('@app/components/widgets/views/calendarDashboard/partials/viewings-list-table', [
                'eventsProvider' => $viewingsProvider,
            ]),
        ]
    ]
]);
