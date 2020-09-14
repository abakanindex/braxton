<?php

namespace app\classes\existrecord;

use app\models\Company;
use app\modules\deals\models\Deals;

class ExistRecordModel
{

    /**
     * This method determines whether there is an entry in modell, if yes, there is it returns true
     *
     * @param string $modelName
     * @param int|null $isInternational
     * @return bool
     */
    public function getExistRecordModel(string $modelName, int $isInternational = null) : bool
    {
        $companyId = Company::getCompanyIdBySubdomain();

        if (is_null($isInternational)) {
            $record = $modelName::find()->where([
                'company_id' => $companyId
            ])->one();
        } else {
            $record = $modelName::find()->where([
                'company_id' => $companyId,
                'is_international' => $isInternational
            ])->one();
        }

        return (bool)$record;
    }
}