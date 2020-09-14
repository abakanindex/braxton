<?php 

namespace app\models\owner;

use app\models\{Contacts, Company};

class Owner
{

    /**
    *   this method is return Owner
    *   
    *   @return array
    *
    */
    public function getOwnerCompany() : ?array
    {
        $companyId = Company::getCompanyIdBySubdomain();
        $res       = [];

        if ($companyId == 'main' ) {
            $modelContact = Contacts::find()->select([
                'id', 
                'first_name', 
                'last_name'
            ])->asArray()->all();
        } else {   
            $modelContact = Contacts::find()->select([
                'id', 
                'first_name', 
                'last_name'
            ])->where([
                'company_id' => $companyId
            ])->asArray()->all();
        }

        foreach($modelContact as $value) {
            $res[$value['id']] = "{$value['first_name']} {$value['last_name']}";
        }

        return $res;
    }
    
    /**
     * 
     * @param iterable $model
     * @return array
     */
    public function getNameOwnerById(iterable $model) : ?array
    {
        $companyId = Company::getCompanyIdBySubdomain(); 
        if ($companyId == 'main' ) {
            $result = Contacts::find()->select([
                'id', 
                'first_name', 
                'last_name',
                'personal_mobile',
                'personal_phone',
                'personal_email',
    
            ])->where([
                'id' => $model->landlord_id,
            ])->asArray()->all();

        } else {   
            $result = Contacts::find()->select([
                'id', 
                'first_name', 
                'last_name',
                'personal_mobile',
                'personal_phone',
                'personal_email',
    
            ])->where([
                'id'         => $model->landlord_id,
                'company_id' => $companyId,
            ])->asArray()->all();
        }
        
        return $result[0];
    }

}