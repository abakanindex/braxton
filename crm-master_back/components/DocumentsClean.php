<?php

namespace app\components;

use Yii;
use app\models\DocumentsGenerated;

class DocumentsClean extends \yii\base\Component
{
    /**
     * check if generated files created more than 3 hours ago - clean if true
     */
    public function init()
    {
//        TODO make it on cron
        $documents = DocumentsGenerated::getAll();

        foreach($documents as $d) {
            if (((time() - $d->created_at)) >= (60*60*2)) {
                unlink(Yii::$app->basePath . $d->path . $d->name);
                $d->delete();
            }
        }
    }
}