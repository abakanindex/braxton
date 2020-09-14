<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\LeadsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Leads');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leads-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Leads'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'auto',
            'Ref',
            'Type',
            'Status',
        //    'Sub Status',
            'Priority',
         //   'Hot LeadHot',
         //   'First Name',
         //   'Last Name',
         //   'Mobile No',
            'Category',
            'Emirate',
            'Location',
          //  'Sub-location',
          //  'Unit Type',
          //  'Unit No',
          //  'Min Beds',
          //  'Max Beds',
          //  'Min Price',
          //  'Max Price',
          //  'Min Area',
          //  'Max Area',
          //  'Listing Ref',
            'Source',
          //  'Agent 1',
          //  'Agent 2',
          //  'Agent 3',
          //  'Agent 4',
          //  'Agent 5',
          //  'Created By',
            'Finance',
          //  'Enquiry Date',
            'Updated',
         //   'Agent Referrala',
          //  'Shared LeadS',
          //  'Contact Company',
          //  'Email Address:email',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
