<?php

namespace app\components;


use app\models\UserDashboardWidgets;
use app\widgets\agent\LeadsWidget;
use Yii;

class DashboardWidgets
{

    const KEY_PERSONAL_REPORTS = 1;
    const KEY_GAMIFICATION = 2;
    const KEY_LEADS = 3;
    const KEY_PROPERTIES = 4;
    const KEY_TO_DO_LIST = 5;

    public static function getWidgets()
    {
        $widgets = UserDashboardWidgets::find()->where(['user_id' => Yii::$app->user->id])->all();
        foreach ($widgets as $widget) {
            print_r('zzzzzzzzzz');
            switch ($widget->widget) {
                case self::KEY_LEADS:
                    return LeadsWidget::widget(['message' => 'Good morning']);
            };
        }
    }

    public static function getTitle($key)
    {
        switch ($key) {
            case self::KEY_PERSONAL_REPORT:
                return Yii::t('app', 'My Reports');
            case self::KEY_GAMIFICATION:
                return Yii::t('app', 'Gamification');
            case self::KEY_LEADS:
                return Yii::t('app', 'My leads');
            case self::KEY_PROPERTIES:
                return Yii::t('app', 'My properties');
            case self::KEY_TO_DO_LIST:
                return Yii::t('app', 'My To-do List');
        }
    }

}