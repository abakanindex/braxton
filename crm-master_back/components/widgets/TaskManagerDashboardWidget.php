<?php

namespace app\components\widgets;

use yii\base\Widget;
use yii\data\ActiveDataProvider;

class TaskManagerDashboardWidget extends Widget
{

    /**
     * @var array
     */
    public $tasks;

    /**
     * @var int
     */
    public $taskPages;

    public function init()
    {

    }

    public function run()
    {
        return $this->render('taskManagerDashboard/task-manager-dashboard', [
            'tasks' => $this->tasks,
            'taskPages' => $this->taskPages,
        ]);
    }
}
