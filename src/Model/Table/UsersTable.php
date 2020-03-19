<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class UsersTable extends Table
{
	public function allUsers($hospitalID)
	{
		$hospitalUsersTable = TableRegistry::get("hospitalusers");
		$hospitalUsersTable->belongsTo("rolemaster",["foreignKey"=>"role_id"]);
		$hospitalUsersTable->belongsTo("hospitallocations",["foreignKey"=>"hospital_location_id"]);
		
		$data = $hospitalUsersTable->find()
								   ->select()
								   ->where(["hospitalusers.hospital_id"=>$hospitalID, "hospitalusers.is_active"=>1])
								   ->contain(["rolemaster","hospitallocations"])
								   ->order(["hospital_user_id"=>"DESC"])
								   ->enableHydration(false)
								   ->toArray();
		return $data;
	}
	
	public function allRoles()
	{
		$roleMasterTable = TableRegistry::get("rolemaster");
		$data = $roleMasterTable->find()->select()->enableHydration(false)->toArray();
		return $data;
	}
	
	public function allLocations($hospitalID)
	{
		$hospitalLocationsTable = TableRegistry::get("hospitallocations");
		$data = $hospitalLocationsTable->find()->select(["hospital_location_id","location_name","city"])->where(["hospital_id"=>$hospitalID])->enableHydration(false)->toArray();
		return $data;
	}
	
	public function userDetails($hospitalUserID)
	{
		$hospitalUsersTable = TableRegistry::get("hospitalusers");
		$data = $hospitalUsersTable->find()->select()->where(["hospital_user_id"=>$hospitalUserID])->enableHydration(false)->first();
		return $data;
	}
	
	public function saveUser($data)
    {
		$hospitalUsersTable = TableRegistry::get('hospitalusers');
		
		$digits = "0123456789";
		$caps = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$small = "abcdefghijklmnopqrstuvwxyz";
		$specialCharacter = "!@#$&*";
		$randomString = substr(str_shuffle($digits),0,2)."".substr(str_shuffle($caps),0,2)."".substr(str_shuffle($small),0,3)."".substr(str_shuffle($specialCharacter),0,1);
		$getRandomPassword = str_shuffle($randomString);
		
        $fields["hospital_user_id"] = isset($data["hospital_user_id"]) && !empty($data["hospital_user_id"]) ? $data["hospital_user_id"] : "";
        $fields["fname"] = isset($data["fname"]) && !empty($data["fname"]) ? $data["fname"] : "";
        $fields["lname"] = isset($data["lname"]) && !empty($data["lname"]) ? $data["lname"] : "";
        $fields["email"] = isset($data["email"]) && !empty($data["email"]) ? $data["email"] : "";
        $fields["phone_code"] = isset($data["phone_code"]) && !empty($data["phone_code"]) ? $data["phone_code"] : "";
        $fields["phone"] = isset($data["phone"]) && !empty($data["phone"]) ? $data["phone"] : "";
        $fields["hospital_location_id"] = isset($data["hospital_location_id"]) && !empty($data["hospital_location_id"]) ? $data["hospital_location_id"] : "";
        $fields["role_id"] = isset($data["role_id"]) && !empty($data["role_id"]) ? $data["role_id"] : "";
        $fields["hospital_id"] = isset($data["hospitalID"]) && !empty($data["hospitalID"]) ? $data["hospitalID"] : ""; //hospitalID FROM SESSION
		
		if(isset($data["hospital_user_id"]) && empty($data["hospital_user_id"]))
		{
			$fields["password"] = base64_encode(convert_uuencode($getRandomPassword));
			$fields["is_active"] = 1;
			$fields["is_password_changed"] = 0;
		}
		
		if(isset($data["hospital_user_id"]) && empty($data["hospital_user_id"]))
		{
			$fields["created_dttm"] = date("Y-m-d H:i:s");
		}
		
		$fields["modified_dttm"] = date("Y-m-d H:i:s");
		
		if(isset($data["hospital_user_id"]) && empty($data["hospital_user_id"]))
		{
			$fields["created_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
		}
		
		$fields["modified_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
		
		$userSave = $hospitalUsersTable->newEntity($fields);
		$userSaveData = $hospitalUsersTable->save($userSave);
	}
	
    public function checkemail($hospitalID,$email)
    {
		$hospitalUsersTable = TableRegistry::get("hospitalusers");
		//$data = $hospitalUsersTable->find()->select()->where(["hospital_id"=>$hospitalID,"email"=>$email])->enableHydration(false)->first();
		$data = $hospitalUsersTable->find()->select()->where(["email"=>$email])->enableHydration(false)->first();
		return $data;
    }
	
	public function deleteUser($hospitalID,$hospitalUserID)
    {
		$hospitalUsersTable = TableRegistry::get("hospitalusers");
		//$hospitalUsersTable->deleteAll(['hospital_user_id IN'=>$hospitalUserID]);
		$hospitalUsersTable->updateAll(['is_active' => 0], ['hospital_user_id' => $hospitalUserID]);
    }
}
?> 



















