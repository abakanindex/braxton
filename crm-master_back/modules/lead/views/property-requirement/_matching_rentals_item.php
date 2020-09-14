<div class="panel panel-default">
    <div class="panel-body">
        <?php
        use yii\helpers\Html;

        if ($model->category_id) echo $model->categoryRel . "<br>";
        if ($model->beds) echo $model->beds . ' ' . Yii::t('app', 'Beds') . "<br>";
      //  if ($model->area) echo Yii::t('app', 'Area') . ': ' . $model->area . "<br>";
        if ($model->baths) echo Yii::t('app', 'Bathes') . ': ' . $model->baths . "<br>";
        echo Html::a($model->ref, ['/rentals/view', 'id' => $model->id]) . "<br>";
        if ($model->unit) echo Yii::t('app', 'Unit') . ': ' . $model->unit . "<br>";
     //   if ($model->type) echo Yii::t('app', 'Type') . ': ' . $model->type . "<br>";
        if ($model->price) echo Yii::t('app', 'Price') . ': ' . $model->price . ' ' . Yii::t('app', 'AE') . "<br>";
        ?>
    </div>
</div>
