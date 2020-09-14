<?php

namespace app\components\rbac;

use app\models\Company;
use yii\db\Query;
use yii\rbac\DbManager;

class AuthManager extends DbManager
{
    public $companyId;

    /**
     * this method returns current company id
     *
     * @return companyId
     */
    public function getCompanyId()
    {
        return $this->companyId = Company::getCompanyIdBySubdomain();
    }

    /**
     *
     * @param [type] $item
     * @return bool
     */
    public function addItem($item)
    {
        $time = time();
        if ($item->createdAt === null) {
            $item->createdAt = $time;
        }
        if ($item->updatedAt === null) {
            $item->updatedAt = $time;
        }
        $this->db->createCommand()
            ->insert($this->itemTable, [
                'name'        => $item->name,
                'type'        => $item->type,
                'description' => $item->description,
                'rule_name'   => $item->ruleName,
                'data'        => $item->data === null ? null : serialize($item->data),
                'created_at'  => $item->createdAt,
                'updated_at'  => $item->updatedAt,
                'company_id'  => $this->getCompanyId(),
            ])->execute();
        $this->invalidateCache();
        return true;
    }
}