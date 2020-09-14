<?php
namespace app\components\widgets;

use app\models\Note;
use yii\base\Widget;
use yii\helpers\Url;
use app\components\widgets\NotesWidgetAsset;

class NotesWidget extends Widget
{
    public $model;
    public $ref;
    public $notes;

    public function init()
    {
        $this->notes = Note::getByRef($this->ref);
    }

    public function run()
    {
        NotesWidgetAsset::register($this->view);

        return $this->render('notes/notes', [
            'model' => $this->model,
            'urlCreateNote' => Url::to(['note/create']),
            'ref' => $this->ref,
            'notes' => $this->notes
        ]);
    }
}