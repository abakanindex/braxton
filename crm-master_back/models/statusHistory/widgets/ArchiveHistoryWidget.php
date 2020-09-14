<?php

namespace app\models\statusHistory\widgets;

use yii\base\Widget;

class ArchiveHistoryWidget extends Widget
{
    public $modelHistory;
    public $tag_id;
    public $tag_class;
    public $icon;

    public function init()
    {
        parent::init();
        if ($this->modelHistory === null) {
            echo 'No data to display.';
        }
    }
    
    public function run()
    {
        return $this->render('archive_history', [
            'modelHistory' => $this->modelHistory,
            'tag_id'       => $this->tag_id,
            'tag_class'    => $this->tag_class,
            'icon'         => $this->icon
        ]);
    }
}