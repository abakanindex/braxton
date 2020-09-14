<?php
namespace app\components\widgets;

use yii\base\Widget;

class ChangeStatusWidget extends Widget
{
    public $model;
    public $archiveModel;
    public $pendingModel;
    public $id;
    public $status = false;
    public $isChangedStatus = false;
    public $statusToCheck = false;

    public function init()
    {
        $model           = $this->model;
        $archiveModel    = $this->archiveModel;
        $pendingModel    = $this->pendingModel;
        $isChangedStatus = $this->isChangedStatus;

        $archiveModel->setAttributes($model->attributes);
        if ($pendingModel)
            $pendingModel->setAttributes($model->attributes);

        if (!$isChangedStatus) {
            $archiveModel->save();
            $model->delete();
        } else {
            //remove old elements
            if ($model->hasProperty('ref')) {
                $archiveModel::deleteAll(['ref' => $model->ref]);
                if ($pendingModel)
                    $pendingModel::deleteAll(['ref' => $model->ref]);
            } else if ($model->hasProperty('reference')) {
                $archiveModel::deleteAll(['reference' => $model->reference]);
                if ($pendingModel)
                    $pendingModel::deleteAll(['reference' => $model->reference]);
            }

            //add new element - depending on status
            if ($model->hasProperty('status')) {
                if ($model->status == "Unpublished") {
                    $model->delete();
                    $archiveModel->save();
                } else if ($model->status == "Pending") {
                    $model->delete();
                    $pendingModel->save();
                }
            }
        }
    }

    public function run()
    {
    }
}