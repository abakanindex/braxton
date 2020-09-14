<?php

namespace app\models\ref;

use app\models\Company;

class Ref
{
    const REF_SALE   = '-S-';
    const REF_RENTAL = '-R-';
    const REF_LEAD   = '-L-';
    
    /**
     * 
     * this method get reference name of company 
     * 
     * @return string 
     * @param $model 
     */
    public function getRefCompany(iterable $model = null) : ?string
    { 
        $company = new Company();
        $companyName = $company->getCompanyNameWithProfile();
        return strtoupper($companyName[0] . $companyName[1]
            . '-' . $model->tableName()[0]
            . '-' . $model->id
        );
    }
}
