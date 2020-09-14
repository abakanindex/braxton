<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 04.12.2017
 * Time: 21:33
 */

namespace app\components;


use yii\base\Behavior;
use app\models\Company;

class CompanyBehavior extends Behavior
{
    public $companyId;

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->companyId = Company::getCompanyIdBySubdomain();
    }
}