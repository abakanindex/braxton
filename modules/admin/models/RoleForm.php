<?php
namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use app\models\Company;
use app\modules\admin\models\AuthItemChild;

class RoleForm extends Model {

    public $name;
    public $description;

    public $smsallowed;
    public $excelexport;
    public $canassignlead;

    public $contractscreate;
    public $contractsdelete;
    public $contractsupdate;
    public $contractsview;

    public $viewingcreate;
    public $viewingdelete;
    public $viewingupdate;
    public $viewingview;

    public $leadscreate;
    public $leadsupdate;
    public $leadsview;
    public $leadsdelete;

    public $contactscreate;
    public $contactsupdate;
    public $contactsview;
    public $contactsdelete;

    public $salecreate;
    public $saleupdate;
    public $saleview;
    public $saledelete;

    public $rentalscreate;
    public $rentalsupdate;
    public $rentalsview;
    public $rentalsdelete;

    public $calendarview;

    public $commercialsalescreate;
    public $commercialsalesupdate;
    public $commercialsalesview;
    public $commercialsalesdelete;

    public $dealscreate;
    public $dealsupdate;
    public $dealsview;
    public $dealsdelete;

    public $commercialrentalscreate;
    public $commercialrentalsupdate;
    public $commercialrentalsview;
    public $commercialrentalsdelete;

    public $reportscreate;
    public $reportsupdate;
    public $reportsview;
    public $reportsdelete;

    public $taskmanagercreate;
    public $taskmanagerupdate;
    public $taskmanagerview;
    public $taskmanagerdelete;

    public $myremindersview;

    /**
     *
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'name', 
                    'description',
                    'smsallowed',
                    'excelexport',
                    'canassignlead',
                    'contractscreate',
                    'contractsdelete',
                    'contractsupdate',
                    'contractsview',
                    'viewingcreate',
                    'viewingdelete',
                    'viewingupdate',
                    'viewingview',
                    'group',
                    'leadscreate',
                    'leadsupdate',
                    'leadsview',
                    'leadsdelete',
                    'contactscreate',
                    'contactsupdate',
                    'contactsview',
                    'contactsdelete',
                    'salecreate',
                    'saleupdate',
                    'saleview',
                    'saledelete',
                    'rentalscreate',
                    'rentalsupdate',
                    'rentalsview',
                    'rentalsdelete',
                    'calendarview',
                    'commercialsalescreate',
                    'commercialsalesupdate',
                    'commercialsalesview',
                    'commercialsalesdelete',
                    'commercialrentalscreate',
                    'commercialrentalsupdate',
                    'commercialrentalsview',
                    'commercialrentalsdelete',
                    'reportscreate',
                    'reportsupdate',
                    'reportsview',
                    'reportsdelete',
                    'taskmanagercreate',
                    'taskmanagerupdate',
                    'taskmanagerview',
                    'taskmanagerdelete',
                    'myremindersview',
                    'dealscreate',
                    'dealsupdate',
                    'dealsview',
                    'dealsdelete'
                ], 
                'safe'
            ],
        ];
    }


    /**
     * Undocumented function
     *
     * @return void
     */
    public function setCheck($name) 
    {
        $companyId = Company::getCompanyIdBySubdomain();

        /****************************/
        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'leadsСreate', 'company_id' => $companyId]);
        $this->leadscreate = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'leadsDelete', 'company_id' => $companyId]);
        $this->leadsdelete = $result['child'];
        
        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'leadsUpdate', 'company_id' => $companyId]);
        $this->leadsupdate = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'leadsView', 'company_id' => $companyId]);
        $this->leadsview = $result['child'];

        /****************************/
        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'contactsCreate', 'company_id' => $companyId]);
        $this->contactscreate = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'contactsDelete', 'company_id' => $companyId]);
        $this->contactsdelete = $result['child'];
        
        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'contactsUpdate', 'company_id' => $companyId]);
        $this->contactsupdate = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'contactsView', 'company_id' => $companyId]);
        $this->contactsview = $result['child'];

        /****************************/
        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'smsAllowed', 'company_id' => $companyId]);
        $this->smsallowed = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'excelExport', 'company_id' => $companyId]);
        $this->excelexport = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'canAssignLead', 'company_id' => $companyId]);
        $this->canassignlead = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'contractsCreate', 'company_id' => $companyId]);
        $this->contractscreate = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'contractsDelete', 'company_id' => $companyId]);
        $this->contractsdelete = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'contractsUpdate', 'company_id' => $companyId]);
        $this->contractsupdate = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'contractsView', 'company_id' => $companyId]);
        $this->contractsview = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'viewingCreate', 'company_id' => $companyId]);
        $this->viewingcreate = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'viewingDelete', 'company_id' => $companyId]);
        $this->viewingdelete = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'viewingUpdate', 'company_id' => $companyId]);
        $this->viewingupdate = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'viewingView', 'company_id' => $companyId]);
        $this->viewingview = $result['child'];


        /****************************/
        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'saleCreate', 'company_id' => $companyId]);
        $this->salecreate = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'saleDelete', 'company_id' => $companyId]);
        $this->saledelete = $result['child'];
        
        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'saleUpdate', 'company_id' => $companyId]);
        $this->saleupdate = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'saleView', 'company_id' => $companyId]);
        $this->saleview = $result['child'];

        /****************************/
        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'rentalsCreate', 'company_id' => $companyId]);
        $this->rentalscreate = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'rentalsDelete', 'company_id' => $companyId]);
        $this->rentalsdelete = $result['child'];
        
        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'rentalsUpdate', 'company_id' => $companyId]);
        $this->rentalsupdate = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'rentalsView', 'company_id' => $companyId]);
        $this->rentalsview = $result['child'];

        /****************************/
        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'calendarView', 'company_id' => $companyId]);
        $this->calendarview = $result['child'];

        /****************************/
        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'commercialsalesCreate', 'company_id' => $companyId]);
        $this->commercialsalescreate = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'commercialsalesDelete', 'company_id' => $companyId]);
        $this->commercialsalesdelete = $result['child'];
        
        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'commercialsalesUpdate', 'company_id' => $companyId]);
        $this->commercialsalesupdate = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'commercialsalesView', 'company_id' => $companyId]);
        $this->commercialsalesview = $result['child'];

        /****************************/
        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'commercialrentalsCreate', 'company_id' => $companyId]);
        $this->commercialrentalscreate = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'commercialrentalsDelete', 'company_id' => $companyId]);
        $this->commercialrentalsdelete = $result['child'];
        
        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'commercialrentalsUpdate', 'company_id' => $companyId]);
        $this->commercialrentalsupdate = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'commercialrentalsView', 'company_id' => $companyId]);
        $this->commercialrentalsview = $result['child'];

          /****************************/
        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'dealsCreate', 'company_id' => $companyId]);
        $this->dealscreate = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'dealsDelete', 'company_id' => $companyId]);
        $this->dealsdelete = $result['child'];
        
        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'dealsUpdate', 'company_id' => $companyId]);
        $this->dealsupdate = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'dealsView', 'company_id' => $companyId]);
        $this->dealsview = $result['child'];


        
        /****************************/
        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'reportsCreate', 'company_id' => $companyId]);
        $this->reportscreate = $result['child'];

        /****************************/
        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'taskmanagerCreate', 'company_id' => $companyId]);
        $this->taskmanagercreate = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'taskmanagerDelete', 'company_id' => $companyId]);
        $this->taskmanagerdelete = $result['child'];
        
        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'taskmanagerUpdate', 'company_id' => $companyId]);
        $this->taskmanagerupdate = $result['child'];

        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'taskmanagerView', 'company_id' => $companyId]);
        $this->taskmanagerview = $result['child'];

        /****************************/
        $result =  AuthItemChild::findOne(['parent' => $name, 'child' => 'myremindersView', 'company_id' => $companyId]);
        $this->myremindersview = $result['child'];
        
    }

}