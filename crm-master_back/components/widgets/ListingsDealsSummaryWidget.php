<?php

namespace app\components\widgets;

use app\models\Sale;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\data\{ArrayDataProvider, ActiveDataProvider};
use Yii;

class ListingsDealsSummaryWidget extends Widget
{
    public $model;
    public $data = [];

    public function init()
    {
        $model           = $this->model;
        $categories      = $model::getTopCategories(3);
        $totalRecord     = $model::find()->count();
        $totalPercentCat = $totalPercentPrice = 0;
        $dataPercentCat  = $dataPercentPrice  = [];
        $dataTitleCat    = $dataTitlePrice    = [];
        $topLocations    = $model::getTopLocation(3);
        $topRegions      = $model::getTopRegions(3);
        $topAgents       = $model::getTopAgent(3);

        foreach($categories as &$c) {
            if ($c['total'] > 0) {
                $percent      = round(($c['total'] * 100) / $totalRecord, 2);
                $totalPercentCat += $percent;
                $c['percent']     = $percent;
                array_push($dataPercentCat, $percent);
                array_push($dataTitleCat, $c['title']);
            }
        }

        $restPercentCat = 100 - $totalPercentCat;
        array_push($dataPercentCat, $restPercentCat);
        array_push($dataTitleCat, Yii::t('app', 'Other'));

        $dataPriceRange[] = array(
            'total' => $model::getByPriceInRange(0, 500000),
            'title' => '0 - 500 000'
        );
        $dataPriceRange[] = array(
            'total' => $model::getByPriceInRange(500000, 1000000),
            'title' => '500 000 - 1 000 000'
        );
        $dataPriceRange[] = array(
            'total' => $model::getByPriceInRange(1000000, 1500000),
            'title' => '1 000 000 - 1 500 000'
        );
        $dataPriceRange[] = array(
            'total' => $model::getByPriceInRange(1500000, 2000000),
            'title' => '1 500 000 - 2 000 000'
        );

        foreach($dataPriceRange as $dP) {
            if ($dP['total'] > 0) {
                $percent      = round(($dP['total'] * 100) / $totalRecord, 2);
                $totalPercentPrice += $percent;
                $dP['percent']     = $percent;
                array_push($dataPercentPrice, $percent);
                array_push($dataTitlePrice, $dP['title']);
            }
        }

        $restPercentPrice = 100 - $totalPercentPrice;
        array_push($dataPercentPrice, $restPercentPrice);
        array_push($dataTitlePrice, Yii::t('app', 'Other'));


        $this->data = array(
            'countPublished'   => $model::getCountByStatus(),
            'topLocations'     => $topLocations,
            'topAgents'        => $topAgents,
            'topCategories'    => $categories,
            'topRegions'       => $topRegions,
            'priceRange1'      => $model::getByPriceInRange(100000, 150000),
            'priceRange2'      => $model::getByPriceInRange(200000, 250000),
            'priceRange3'      => $model::getByPriceInRange(400000, false),
            'categoriesPercentData' => $dataPercentCat,
            'categoriesTitleData'   => $dataTitleCat,
            'pricePercentData' => $dataPercentPrice,
            'priceTitleData'   => $dataTitlePrice,
            'topLocationsProvider' => new ArrayDataProvider(['allModels' => $topLocations]),
            'topRegionsProvider'   => new ArrayDataProvider(['allModels' => $topRegions]),
            'topAgentsProvider'    => new ArrayDataProvider(['allModels' => $topAgents]),
        );
    }

    public function run()
    {
        return $this->render('listingsDealsSummary/listings-summary', [
            'data' => $this->data
        ]);
    }
}
