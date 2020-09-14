<?php

namespace app\modules\reports\components;

class ColorSerialColumn extends \yii\grid\SerialColumn
{
    protected function renderDataCellContent($model, $key, $index)
    {
        $pagination = $this->grid->dataProvider->getPagination();
        if ($pagination !== false) {
            $index = $pagination->getOffset() + $index + 1;
            return '<span class="icon-blank report-color-' . $index . '"></span>';
        }
        return '<span class="icon-blank report-color-' . ($index + 1) . '"></span>';
    }
}