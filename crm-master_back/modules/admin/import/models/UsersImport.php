<?php
/**
 * Created by PhpStorm.
 * User: Slavi
 * Date: 3/1/2018
 * Time: 2:39 PM
 */

namespace app\modules\admin\import\models;


use app\components\rbac\AuthManager;
use app\models\AuthAssignment;
use app\models\Company;
use app\models\User;
use app\modules\admin\Users;
use yii\helpers\ArrayHelper;
use Yii;

class UsersImport
{

    public function getUsers($username, $password, $clientId)
    {
        $curl = new Curl([], $username, $password, $clientId, Curl::USERS);
        $data = $curl->loginAndDownload();
        return $data ? $data['aaData'] : null;
    }

    /**
     * @param $data
     * @return bool | array
     */
    public function associateUsersArray($data)
    {
        $keys = $this->getArrayKeys();

        foreach ($data as $key => $datum) {
            ArrayHelper::remove($data[$key], 'DT_RowClass');
            ArrayHelper::remove($data[$key], 'DT_RowId');
            ArrayHelper::remove($data[$key], '0');
            /*$data[$key] = array_slice($data[$key], 0, 6, true) +
                array("7" => "--") +
                array_slice($data[$key], 3, count($data[$key]) - 1, true) ;*/
        }

        //   var_dump('<pre>', $data);

        $users = false;
        foreach ($data as $key => $datum) {
            foreach ($datum as $col => $value) {
                $users[$key][$keys[$col]] = strip_tags($value);
            }
        }
        return $users;
    }

    public function saveUsers($data)
    {
        $data = $this->associateUsersArray($data);
        $company_id = Company::getCompanyIdBySubdomain();
        $company_id = ($company_id == 'main') ? 0 : $company_id;

        foreach($data as &$d) {
            $d['email'] = str_replace(' ', '', $d['email']);
            $user = new User();
            $user->attributes = $d;
            $user->company_id = $company_id;
            $user->status     = ($d['status'] == 'Active') ? User::STATUS_ACTIVE : User::STATUS_DISABLED;
            $user->password_hash = Yii::$app->getSecurity()->generatePasswordHash("123456");

            if ($user->username == "admin")
                $user->username = "kane";

            if ($user->username == "camelia")
                $user->email = "not.exist@example.com";

            $user->save();

            if ($user->save()) {
                $authAssignment = new AuthAssignment();
                $authAssignment->item_name = $d['access_level'];
                $authAssignment->user_id   = $user->id;
                $authAssignment->save();
            } else {
                var_dump($user->errors);
            }
        }

        return true;

//        $insert = "INSERT INTO users_source (`" . implode("`, `", array_keys(array_shift($data))) . "`, `company_id`) VALUES ";
//        foreach ($data as $datum) {
//            $insert .= "('" . implode("', '", array_values($datum)) . "', $company_id),";
//        }
//        $insert = rtrim($insert, ',');
//        $query = Yii::$app->db->createCommand($insert);
//        if ($query->execute()) {
//           $this->assignUsers();
//            return true;
//        }
//        return null;
    }

    public function getArrayKeys()
    {
        return require 'keys_users.php';
    }

    public function migrateToUserTable()
    {
        $company_id = Company::getCompanyIdBySubdomain();
        $company_id = ($company_id == 'main') ? 0 : $company_id;
        $query = " INSERT INTO `user` 
                    (`username`, `first_name`, `last_name`, `job_title`, `office_no`, `country_dialing`, `mobile_no`, `email`, `company_id`, `status`, `role`)
                        SELECT `username`, `first_name`, `last_name`, `job_title`, `office_no`, `country_dialing`, `mobile_no`, `email`, `company_id`, 2, `access_level`
                            FROM `users_source` 
                            WHERE `company_id` = $company_id";
        $db = Yii::$app->db->createCommand($query);
        if ($db->execute()) {
            return 'User table updated';
        }
        return null;
    }

    public function assignUsers()
    {
        $authManager = new AuthManager();
        $company_id = Company::getCompanyIdBySubdomain();
        $users = User::find()->select(['id', 'role'])->where(['company_id' => $company_id])->all();
        foreach ($users as $user) {
            $authRole = $authManager->getRole(strtolower($user->role));
            $authManager->assign($authRole, $user->id);
        }
        return $users;
    }
}