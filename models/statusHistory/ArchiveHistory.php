<?php

namespace app\models\statusHistory;

use app\models\statusHistory\StatusHistory;

class ArchiveHistory
{

    protected $anyModel;
    
    /**
     * Undocumented function
     *
     * @param $anyModel
     */
    function __construct($anyModel)
    {
        $this->anyModel = $anyModel;
    }

    /**
     *  This method gets the any table model and saves history of changed it to 
     *  the table StatusHistory
     *
     *  @param iterable $model
     *  @param array $getDirtyAttributesl, $getOldAttributes
     *  @return void
     *  
     */
    public function addArchiveProperty(
        array $getDirtyAttributes, 
        array $getOldAttributes
    ) : void
    {

        $model               = $this->anyModel;
        $attributesArchive   = [];
        $getAttributes       = array_keys($getDirtyAttributes);
        $resultOldAttributes = $getOldAttributes;

        // var_dump($getAttributes);die;

        for ($i = 0; count($getAttributes) > $i; $i++) {
            $attributesArchive[$getAttributes[$i]] = $resultOldAttributes[$getAttributes[$i]];
        }

        $date = new \DateTime();
        $modelStatusHistory = new StatusHistory();

        $values = [
            'time_change'    => $date->format('Y-m-d H:i:s'),
            'name_model'     => $model->tableName(),
            'parent_id'      => $model->id,
            'history_fields' => serialize($attributesArchive),
        ];

        $modelStatusHistory->attributes = $values;
        $modelStatusHistory->save();
    }

    /**
     * this method returns a Status History any model
     *
     * @return iterable|null
     * @throws \yii\base\Exception
     */
    protected function getModelStatusHistory(): ?iterable
    {
        $model = $this->anyModel;

        if (!$model) {
            throw new \yii\base\Exception('This page doesn\'t exist!');
        }

        $modelHistory = StatusHistory::find()->where([
            'name_model' => $model->tableName(),
            'parent_id'  => $model->id
        ])->all();

        return $modelHistory;
    }

        /**
         *  This method returns a history of changes of any model
         *
         *  @param iterable $model
         *  @return iterable $statusHistory
         *
         */
        protected function getArchiveChanges(?iterable $statusHistory) : ?iterable
        {
            $model      = $this->anyModel;
            $allArchive = [];
            $attributes = [];
            $result     = [];
            $prop       = [];
            $newres     = [];
            $time       = [];

        foreach ($statusHistory as $value) {

            $getArchiveArr      = unserialize($value->history_fields);
            $getArchiveArrFor[] = unserialize($value->history_fields);
            $getAttributes[]    = array_keys($getArchiveArr);
            $time[]             = $value->time_change;

        }

        for ($io = 0; $io < count($getAttributes); $io++) {

            for ($i = 0; $i < count($getAttributes[$io]); $i++) {

                $attributes[$io][
                        'Property change time'
                        ] = $time[$io];

                $attributes[$io][
                        $model->getAttributeLabel($getAttributes[$io][$i])
                        ] = $getArchiveArrFor[$io][$getAttributes[$io][$i]];
            }
        }
        return $attributes;
    }

    /**
     *  this method displays the status of the model change
     *
     *  @param iterable $model
     *  @return iterable $statusHistory
     *
     */
    public function outputArchiveStatus(): ?iterable
    {
        $statusHistory = $this->getModelStatusHistory();

        return $this->getArchiveChanges($statusHistory);
    }

}
