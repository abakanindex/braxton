<?php
namespace app\interfaces\leads;

interface iLeads
{
    const ACTIVITY_ACTIVE = 1;
    const ACTIVITY_NOT_ACTIVE = 2;

    const STATUS_OPEN = 1;
    const STATUS_CLOSED = 2;
    const STATUS_NOT_SPECIFIED = 3;

    const PRIORITY_URGENT = 1;
    const PRIORITY_HIGH = 2;
    const PRIORITY_NORMAL = 3;
    const PRIORITY_LOW = 4;

    const FINANCE_TYPE_CASH = 1;
    const FINANCE_TYPE_LOAN_APPROVED = 2;
    const FINANCE_TYPE_LOAN_NOT_APPROVED = 3;

    const IMPORTED = 1;
    const IMPORTED_NOT = 2;

    public function getLeadType();

    public function getSubStatus();

    public function getCategory();

    public function getCompanySource();

    public function getCreatedByUser();

    public function getAdditionalEmailsList();

    public function getLeadSocialMeadiaContacts();

    public function getStatus();

    public function getPriority();

    public function getFinanceType();

    public function getType();

    public static function findType($type);

    public function getPropertyRequirements();

    public function getCreatedUserFullname();

    public function getEmirateRecord();

    public function getLocationRecord();

    public function getSubLocationRecord();

}