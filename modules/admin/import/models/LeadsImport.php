<?php

namespace app\modules\admin\import\models;


use app\models\Company;
use yii\base\Model;
use Yii;
use yii\helpers\ArrayHelper;

class LeadsImport extends Model
{
    public $data;

    /**
     * @param $username
     * @param $password
     * @param $clientId
     * @return mixed
     * @throws \Exception
     * @throws \yii\base\Exception
     */
    public function getLeads($username, $password, $clientId)
    {
        $model = new Curl([], $username, $password, $clientId, Curl::LEADS);
        $leads = $model->loginAndDownload();
        return $leads['aaData'];
    }

    /**
     * @return mixed
     */
    public static function getLeadsArrayKeys()
    {
        return require('keys_leads.php');
    }

    /**
     * @param $data
     * @return bool | array
     */
    public function associateLeadsArray($data)
    {
        $keys = LeadsImport::getLeadsArrayKeys();
        foreach ($data as $key => $datum) {
            ArrayHelper::remove($data[$key], 0);
            ArrayHelper::remove($data[$key], 1);
            ArrayHelper::remove($data[$key], 38);
            ArrayHelper::remove($data[$key], 39);
            ArrayHelper::remove($data[$key], 40);
            ArrayHelper::remove($data[$key], 41);
            //ArrayHelper::remove($data[$key], 42);
            ArrayHelper::remove($data[$key], 43);
            ArrayHelper::remove($data[$key], 44);
            ArrayHelper::remove($data[$key], 'DT_RowClass');
            ArrayHelper::remove($data[$key], 'DT_RowId');
            ArrayHelper::remove($data[$key], 199);
        }
        $leads = false;
        foreach ($data as $key => $datum) {
            foreach ($datum as $col => $value) {
                if ($keys[$col])
                    $leads[$key][$keys[$col]] = str_replace("'", '', strip_tags($value));
            }
        }//var_dump('<pre>', $leads);
        return $leads;
    }

    /**
     * @param $data
     * @return bool|null
     * @throws \yii\db\Exception
     */
    public function saveLeads($data)
    {
        $leads      = $this->associateLeadsArray($data);
        $company_id = Company::getCompanyIdBySubdomain();
        $company_id = ($company_id == 'main') ? 0 : $company_id;

        $insert     = "INSERT INTO lead_source (`" . implode('`, `', array_keys(array_shift($leads))) . "`, `company_id`) VALUES ";
        foreach ($leads as $key => $datum) {
            $insert .= "('" . implode("', '", array_values($datum)) . "', '" . $company_id . "'),";
        }
//        $insert = str_replace("'- -', '- -', $company_id", "'- -', $company_id", $insert);
//        $insert = str_replace('``,', '', $insert);
        $insert = rtrim($insert, ',');
        $query  = Yii::$app->db->createCommand($insert);
        if($query->execute()) {
            return true;
        }
        return null;
    }
}