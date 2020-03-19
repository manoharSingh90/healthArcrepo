<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class CommonComponent extends Component
{
	public function mastersdata($hospitalID)
    {
		//GET ALL CONDITIONS
		$conditionMasterTable = TableRegistry::get("conditionmaster");
		$conditionsData = $conditionMasterTable->find()->select(["condition_id","condition_name"])->enableHydration(false)->toArray();
		//GET ALL CONDITIONS
		
		//GET ALL DEVICES
		$deviceMasterTable = TableRegistry::get("devicemaster");
		$deviceData = $deviceMasterTable->find()->select(["device_id","device_manufacturer","device_name"])->enableHydration(false)->toArray();
		//GET ALL DEVICES
		
		//GET ALL VITALS
		$vitalMasterTable = TableRegistry::get("vitalmaster");
		$vitalsData = $vitalMasterTable->find()->select(["vital_id","vital_name"])->order(["vital_display_order"=>"ASC"])->enableHydration(false)->toArray();
		//GET ALL VITALS
		
		//GET ALL NURSES
		$hospitalUsersTable = TableRegistry::get("hospitalusers");
		$nurseData = $hospitalUsersTable->find()->select(["hospital_user_id","fname","lname"])->where(["hospital_id"=>$hospitalID, "role_id"=>3])->enableHydration(false)->toArray();
		//GET ALL NURSES
		
		$data = array("conditionsData"=>$conditionsData, "deviceData"=>$deviceData, "vitalsData"=>$vitalsData, "nurseData"=>$nurseData);
		return $data;
	}
	public function vitalMasterData()
    {
		$vitalMasterTable = TableRegistry::get("vitalmaster");
		$vitalsData = $vitalMasterTable->find()->select(["vital_id","vital_name","vital_min_default","vital_max_default","vital_unit"])->order(["vital_display_order"=>"ASC"])->enableHydration(false)->toArray();
		return $vitalsData;
	}
	public function templatesData($hospitalID)
    {
		$templateMasterTable = TableRegistry::get("hospitaltemplatealerts");
		$templatesData = $templateMasterTable->find()->select()->where(["hospital_id"=>$hospitalID])->enableHydration(false)->toArray();
		return $templatesData;
	}
}