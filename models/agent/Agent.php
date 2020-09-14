<?php 

namespace app\models\agent;

use app\models\{User, Company};
use yii\helpers\ArrayHelper;
use Yii;
use app\models\owner\Owner;


class Agent
{


    /**
    *   this method is return the user agent
    * 
    *   @return array
    *
    */
    public function getAgentUserCompany() : array
    {
//        return ArrayHelper::map((new User())->getByRole('Agent'), 'id', 'username');
        return ArrayHelper::map((new User())->getAllCompanyUsers(), 'id', 'username');
    }
    
    /**
     * 
     * this method return name Agent by id 
     * 
     * @param iterable $model
     * @return array
     */
    public function getNameAgentById(iterable $model) : array 
    {
        $companyId = Company::getCompanyIdBySubdomain(); 
        
        $result = User::find()->select([
            'id',
            'username',
        ])->where([
            'id'         => $model->agent_id,
            'company_id' => $companyId,
        ])->asArray()->all();
        
        return $result;
    }

    /**
     * 
     */
    public function getNameOneAgentById($id)
    {
        $companyId = Company::getCompanyIdBySubdomain(); 

        if ($companyId == 'main' ) {
            $modelUser = User::findOne($id);
        } else {   
            $modelUser = User::findOne([
                'id'         => $id,
                'role'       => 'Agent', 
                'company_id' => $companyId,
            ]);
            
        }
        return $modelUser->username; 
    }
}