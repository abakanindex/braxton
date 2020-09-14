<?php

namespace app\classes;


use app\models\Company;
use app\models\Leads;
use app\models\Locations;
use app\models\reference_books\PropertyCategory;
use app\modules\lead\models\CompanySource;
use app\modules\lead\models\LeadSource;
use app\modules\lead\models\LeadSubStatus;
use app\modules\lead\models\LeadType;
use DateTime;
use Yii;
use yii\helpers\ArrayHelper;

class LeadsImport
{
    private $db;
    private $companyId;

    function __construct()
    {
        $this->db = Yii::$app->db;
        $companyId = Company::getCompanyIdBySubdomain();
        $this->companyId = ($companyId == 'main') ? 0 : $companyId;
    }


    public function import()
    {
        $limit = 500;
        $total = LeadSource::find()->count();
        $iter  = ceil($total / $limit);
        $locations = ArrayHelper::map(Locations::getAll(), 'name', 'id');

        for($i = 0; $i < $iter; $i++) {
            $offset = $i * $limit;
            $leadsSources = $this->db->createCommand("SELECT * FROM `lead_source` limit $limit offset $offset")->queryAll();
            $leads = $leads2 = [];

            foreach ($leadsSources as $leadsSource) {
                if (!$leadsSource['type']) {
                    $leadsItem = [];
                    $leadsItem['emirate'] = $locations[$leadsSource['emirate']];
                    $leadsItem['location'] = $locations[$leadsSource['location']];
                    $leadsItem['sub_location'] = $locations[$leadsSource['sub_location']];
                    $leadsItem['reference'] = $leadsSource['ref'];
                    $leadsItem['status'] = $this->getStatus($leadsSource['status']);
                    $leadsItem['sub_status_id'] = $this->getSubStatus($leadsSource['sub_status']);
                    $leadsItem['priority'] = $this->getPriority($leadsSource['priority']);
                    $leadsItem['hot_lead'] = $leadsSource['hot_leadhot'];
                    $leadsItem['first_name'] = $leadsSource['first_name'];
                    $leadsItem['last_name'] = $leadsSource['last_name'];
                    $leadsItem['mobile_number'] = $leadsSource['mobile_no'];
                    $leadsItem['category_id'] = $this->getCategory($leadsSource['category']);
                    $leadsItem['unit_type'] = $leadsSource['unit_type'];
                    $leadsItem['unit_number'] = $leadsSource['unit_no'];
                    $leadsItem['min_beds'] = $leadsSource['min_beds'];
                    $leadsItem['max_beds'] = $leadsSource['max_beds'];
                    $leadsItem['min_price'] = str_replace(",", "", $leadsSource['min_price']);
                    $leadsItem['max_price'] = str_replace(",", "", $leadsSource['max_price']);
                    $leadsItem['min_area'] = $leadsSource['min_area'];
                    $leadsItem['max_area'] = $leadsSource['max_area'];
                    $leadsItem['source'] = $this->getSource($leadsSource['source']);
                    $leadsItem['listing_ref'] = $leadsSource['listing_ref'];
                    $leadsItem['created_by_user_id'] = \Yii::$app->user->id;
                    $leadsItem['finance_type'] = (strlen($leadsSource['finance']) > 4) ? $this->getFinanceType($leadsSource['finance']) : 0;
                    $leadsItem['enquiry_time'] = (strlen($leadsSource['enquiry_date']) > 4) ? $this->getFinanceType($leadsSource['enquiry_date']) : 0;
                    $leadsItem['updated_time'] = (strlen($leadsSource['updated']) > 4) ? $this->getFinanceType($leadsSource['updated']) : 0;
                    $leadsItem['agent_referrala'] = $leadsSource['agent_referral'];
                    $leadsItem['shared_leads'] = $leadsSource['shared_leadS'];
                    $leadsItem['contract_company'] = (trim($leadsSource['contact_company']) != '0') ? $leadsSource['contact_company'] : '';
                    $leadsItem['email'] = $leadsSource['email_address'];
                    $leadsItem['slug'] = strtolower($leadsSource['ref']);
                    $leadsItem['is_imported'] = $this->getImportStatus($leadsSource['auto']);
                    $leadsItem['agent_1'] = $leadsSource['agent_1'];
                    $leadsItem['agent_2'] = $leadsSource['agent_2'];
                    $leadsItem['agent_3'] = $leadsSource['agent_3'];
                    $leadsItem['agent_4'] = $leadsSource['agent_4'];
                    $leadsItem['agent_5'] = $leadsSource['agent_5'];
                    $leadsItem['is_parsed'] = Leads::IS_PARSED;
                    $leadsItem['origin']    = Leads::ORIGIN_IMPORT_FROM_PROPSPACE;
                    $leads[] = $leadsItem;
                } else {
                    $leadsItem = [];
                    $leadsItem['emirate'] = $locations[$leadsSource['emirate']];
                    $leadsItem['location'] = $locations[$leadsSource['location']];
                    $leadsItem['sub_location'] = $locations[$leadsSource['sub_location']];
                    $leadsItem['reference'] = $leadsSource['ref'];
                    $leadsItem['type_id'] = $this->getType($leadsSource['type']);
                    $leadsItem['status'] = $this->getStatus($leadsSource['status']);
                    $leadsItem['sub_status_id'] = $this->getSubStatus($leadsSource['sub_status']);
                    $leadsItem['priority'] = $this->getPriority($leadsSource['priority']);
                    $leadsItem['hot_lead'] = $leadsSource['hot_leadhot'];
                    $leadsItem['first_name'] = $leadsSource['first_name'];
                    $leadsItem['last_name'] = $leadsSource['last_name'];
                    $leadsItem['mobile_number'] = $leadsSource['mobile_no'];
                    $leadsItem['category_id'] = $this->getCategory($leadsSource['category']);
                    $leadsItem['unit_type'] = $leadsSource['unit_type'];
                    $leadsItem['unit_number'] = $leadsSource['unit_no'];
                    $leadsItem['min_beds'] = $leadsSource['min_beds'];
                    $leadsItem['max_beds'] = $leadsSource['max_beds'];
                    $leadsItem['min_price'] = str_replace(",", "", $leadsSource['min_price']);
                    $leadsItem['max_price'] = str_replace(",", "", $leadsSource['max_price']);
                    $leadsItem['min_area'] = $leadsSource['min_area'];
                    $leadsItem['max_area'] = $leadsSource['max_area'];
                    $leadsItem['source'] = $this->getSource($leadsSource['source']);
                    $leadsItem['listing_ref'] = $leadsSource['listing_ref'];
                    $leadsItem['created_by_user_id'] = \Yii::$app->user->id;
                    $leadsItem['finance_type'] = (strlen($leadsSource['finance']) > 4) ? $this->getFinanceType($leadsSource['finance']) : 0;
                    $leadsItem['enquiry_time'] = (strlen($leadsSource['enquiry_date']) > 4) ? $this->getFinanceType($leadsSource['enquiry_date']) : 0;
                    $leadsItem['updated_time'] = (strlen($leadsSource['updated']) > 4) ? $this->getFinanceType($leadsSource['updated']) : 0;
                    $leadsItem['agent_referrala'] = $leadsSource['agent_referral'];
                    $leadsItem['shared_leads'] = $leadsSource['shared_leadS'];
                    $leadsItem['contract_company'] = (trim($leadsSource['contact_company']) != '0') ? $leadsSource['contact_company'] : '';
                    $leadsItem['email'] = $leadsSource['email_address'];
                    $leadsItem['slug'] = strtolower($leadsSource['ref']);
                    $leadsItem['is_imported'] = $this->getImportStatus($leadsSource['auto']);
                    $leadsItem['agent_1'] = $leadsSource['agent_1'];
                    $leadsItem['agent_2'] = $leadsSource['agent_2'];
                    $leadsItem['agent_3'] = $leadsSource['agent_3'];
                    $leadsItem['agent_4'] = $leadsSource['agent_4'];
                    $leadsItem['agent_5'] = $leadsSource['agent_5'];
                    $leadsItem['is_parsed'] = Leads::IS_PARSED;
                    $leadsItem['origin']    = Leads::ORIGIN_IMPORT_FROM_PROPSPACE;
                    $leads2[] = $leadsItem;
                }
            }
            if (count($leads) > 0) {
                $keys = array_keys($leads[0]);
                $insert = "INSERT INTO leads (`" . implode('`, `', $keys) . "`, `company_id`) VALUES ";
                foreach ($leads as $key => $datum) {
                    $insert .= "('" . implode("', '", array_values($datum)) . "', '$this->companyId'),";
                }
                $insert = rtrim($insert, ',');
                $query = $this->db->createCommand($insert);
                $query->execute();
            }

            if (count($leads2) > 0) {
                $keys = array_keys($leads2[0]);
                $insert = "INSERT INTO leads (`" . implode('`, `', $keys) . "`, `company_id`) VALUES ";
                foreach ($leads2 as $key => $datum) {
                    $insert .= "('" . implode("', '", array_values($datum)) . "', '$this->companyId'),";
                }
                $insert = rtrim($insert, ',');
                $query = $this->db->createCommand($insert);
                $query->execute();
            }
        }
    }

    private function getType($type)
    {
        if ($type) {
            $leadType = $this->db->createCommand("SELECT * FROM lead_type WHERE title = '$type'")->queryOne();
            if ($leadType)
                return $leadType['id'];
            else {
                $maxOrder = $this->db->createCommand("SELECT MAX(`order`) as max_order FROM lead_type")->queryOne();
                $maxOrder = $maxOrder['max_order'] + 1;
                $insert = "INSERT INTO lead_type (`title`, `order`) VALUES ('$type', '$maxOrder')";
                $this->db->createCommand($insert)->execute();
                return $this->db->getLastInsertID();
            }
        }
    }

    private function getStatus($status)
    {
        switch ($status) {
            case 'Open':
                return Leads::STATUS_OPEN;
            case 'Closed':
                return Leads::STATUS_CLOSED;
            default:
                return Leads::STATUS_NOT_SPECIFIED;
        }
    }

    private function getSubStatus($subStatus)
    {
        if ($subStatus) {
            $subStatusRecod = $this->db->createCommand("SELECT * FROM lead_sub_status WHERE title = '$subStatus'")->queryOne();
            if ($subStatusRecod)
                return $subStatusRecod['id'];
            else {
                $maxOrder = $this->db->createCommand("SELECT MAX(`order`) as max_order FROM lead_sub_status")->queryOne();
                $maxOrder = $maxOrder['max_order'] + 1;
                $insert = "INSERT INTO lead_sub_status (`title`, `order`) VALUES ('$subStatus', '$maxOrder')";
                $this->db->createCommand($insert)->execute();
                return $this->db->getLastInsertID();
            }
        }
    }

    private function getPriority($priority)
    {
        switch ($priority) {
            case '!Low':
                return Leads::PRIORITY_LOW;
            case 'oNormal':
                return Leads::PRIORITY_NORMAL;
            case '!!High':
                return Leads::PRIORITY_HIGH;
            case '!!!Urgent':
                return Leads::PRIORITY_URGENT;
            default:
                return 0;
        }
    }

    private function getCategory($category)
    {
        if ($category) {
            $categoryRecord = $this->db->createCommand("SELECT * FROM property_category WHERE title = '$category'")->queryOne();
            if ($categoryRecord)
                return $categoryRecord['id'];
            else {
                $maxOrder = $this->db->createCommand("SELECT MAX(`order`) as max_order FROM property_category")->queryOne();
                $maxOrder = $maxOrder['max_order'] + 1;
                $insert = "INSERT INTO property_category (`title`, `order`) VALUES ('$category', '$maxOrder')";
                $this->db->createCommand($insert)->execute();
                return $this->db->getLastInsertID();
            }
        } else return 0;
    }

    private function getSource($source)
    {
        if ($source) {
            $sourceRecord = $this->db->createCommand("SELECT * FROM company_source WHERE `title` = '$source' AND `company_id` = '$this->companyId'")->queryOne();
            if ($sourceRecord)
                return $sourceRecord['id'];
            else {
                $maxOrder = $this->db->createCommand("SELECT MAX(`order`) as max_order FROM company_source WHERE `company_id` = '$this->companyId'")->queryOne();
                $maxOrder = $maxOrder['max_order'] + 1;
                $insert = "INSERT INTO company_source (`title`, `company_id`, `order`) VALUES ('$source', '$this->companyId', '$maxOrder')";
                $this->db->createCommand($insert)->execute();
                return $this->db->getLastInsertID();
            }
        } else return 0;
    }

    private function getFinanceType($financeType)
    {
        switch ($financeType) {
            case 'Cash':
                return Leads::FINANCE_TYPE_CASH;
            case 'Loan (approved)':
                return Leads::FINANCE_TYPE_LOAN_APPROVED;
            case 'Loan (not approved)':
                return Leads::FINANCE_TYPE_LOAN_NOT_APPROVED;
            default:
                return 0;
        }
    }

    private function getEnquiryTime($enquiryTime)
    {
        $enquiryTime = DateTime::createFromFormat("d-m-Y H:i", $enquiryTime);
        return $enquiryTime->getTimestamp();
    }

    private function getUpdatedTime($updatedTime)
    {
        $updatedTime = DateTime::createFromFormat("d-m-Y H:i", $updatedTime);
        return $updatedTime->getTimestamp();
    }

    private function getImportStatus($auto)
    {
        switch ($auto) {
            case 'imported':
                return Leads::IMPORTED;
            case '- -':
                return Leads::IMPORTED_NOT;
            default:
                return Leads::IMPORTED_NOT;;
        }
    }

}