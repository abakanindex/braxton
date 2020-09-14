<?php
namespace app\components\widgets;

use app\models\Leads;
use app\models\reference_books\PropertyCategory;
use app\modules\lead\models\PropertyRequirement;
use Yii;
use yii\base\Widget;
use yii\data\ArrayDataProvider;


class MatchLeadsWidget extends Widget
{
    public  $record;
    private $provider;
    private $providerCompany;

    public function init()
    {
        $this->provider = new ArrayDataProvider([
            'allModels'  => PropertyRequirement::getMatchLeads(
                    $this->record->beds,
                    $this->record->baths,
                    $this->record->category_id,
                    $this->record->region_id,
                    $this->record->area_location_id,
                    $this->record->sub_area_location_id,
                    $this->record->size,
                    $this->record->price,
                    true
                ),
            'pagination' => [
                'pageSize' => 10000,
            ]
        ]);

        $this->providerCompany = new ArrayDataProvider([
            'allModels'  => PropertyRequirement::getMatchLeads(
                    $this->record->beds,
                    $this->record->baths,
                    $this->record->category_id,
                    $this->record->region_id,
                    $this->record->area_location_id,
                    $this->record->sub_area_location_id,
                    $this->record->size,
                    $this->record->price,
                    false
                ),
            'pagination' => [
                'pageSize' => 10000,
            ]
        ]);
    }

    public function run()
    {
        return $this->render("matchLeads/index", [
            'provider'        => $this->provider,
            'providerCompany' => $this->providerCompany,
            'leadStatuses'    => Leads::getStatuses()
        ]);
    }
}