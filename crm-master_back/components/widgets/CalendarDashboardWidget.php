<?php

namespace app\components\widgets;

use yii\base\Widget;
use yii\data\ActiveDataProvider;

class CalendarDashboardWidget extends Widget
{
    /**
     * @var array
     */
    public $daysStartEvents;

    /**
     * @var array
     */
    public $tasksCalendar;

    /**
     * @var array
     */
    public $viewingsCalendar;

    /**
     * @var array
     */
    public $dates;

    public function init()
    {
        $days = [];
        if (!empty($this->daysStartEvents)) {
            foreach ($this->daysStartEvents as $k => $event) {
                $days['daysStartEvents'][$k] = date('Y/m/d', $event->start);
            }
        }

        if (!empty($this->tasksCalendar)) {
            foreach ($this->tasksCalendar as $k => $task) {
                $days['tasksDeadlines'][$k] = date('Y/m/d', $task->deadline);
            }
        }

        if (!empty($this->viewingsCalendar)) {
            foreach ($this->viewingsCalendar as $k => $viewing) {
                $days['viewings'][$k] = date('Y/m/d', strtotime($viewing->date));
            }
        }


        $this->dates = json_encode($days);

    }

    public function run()
    {
        return $this->render('calendarDashboard/calendar-dashboard', [
            'dates'  => $this->dates,
        ]);
    }
}
