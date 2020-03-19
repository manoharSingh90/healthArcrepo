<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Datasource\ConnectionManager;

class SuperadminTable extends Table
{
    public function saveAdmin($data)
    {
		$hospitalsTable = TableRegistry::get("hospitals");
		$hospitalUsersTable = TableRegistry::get("hospitalusers");
		
		$path = WWW_ROOT.'img/admin/';
		$dir = new Folder($path, true, 0755);
		
		//SAVE DATA IN "hospitals"
        $hospitalsFields["hospital_name"] = isset($data["hospital_name"]) && !empty($data["hospital_name"]) ? $data["hospital_name"] : "";
        $hospitalsFields["phone_no"] = isset($data["phone_no"]) && !empty($data["phone_no"]) ? $data["phone_no"] : "";
        $hospitalsFields["sub_domain"] = isset($data["sub_domain"]) && !empty($data["sub_domain"]) ? $data["sub_domain"] : "";
		$hospitalsFields["is_active"] = 1;
		$hospitalsFields["created_dttm"] = date("Y-m-d H:i:s");
		$hospitalsFields["modified_dttm"] = date("Y-m-d H:i:s");
		$hospitalsFields["created_by"] = "";
		$hospitalsFields["modified_by"] = "";
		
		if(!empty($data["logo_url"]["name"]))
		{
			$imageName = $data["logo_url"]["name"] ? date("Y-m-d_H-i-s").$data["logo_url"]["name"] : "";
			$tmpName = $data["logo_url"]["tmp_name"] ? $data["logo_url"]["tmp_name"] : "";
			
			move_uploaded_file($tmpName, $path . $imageName);
			
			$hospitalsFields["logo_url"] = $imageName;
		}
		
		$hospitalsSave = $hospitalsTable->newEntity($hospitalsFields);
		$hospitalsSaveData = $hospitalsTable->save($hospitalsSave);
		//SAVE DATA IN "hospitals"
		
		
		//SAVE DATA IN "hospitalusers"
		
		$digits = "0123456789";
		$caps = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$small = "abcdefghijklmnopqrstuvwxyz";
		$specialCharacter = "!@#$&*";
		$randomString = substr(str_shuffle($digits),0,2)."".substr(str_shuffle($caps),0,2)."".substr(str_shuffle($small),0,3)."".substr(str_shuffle($specialCharacter),0,1);
		$getRandomPassword = str_shuffle($randomString);
		
        $hospitalsUsersFields["fname"] = isset($data["hospital_name"]) && !empty($data["hospital_name"]) ? $data["hospital_name"] : "";
        $hospitalsUsersFields["lname"] = isset($data["hospital_name"]) && !empty($data["hospital_name"]) ? $data["hospital_name"] : "";
        $hospitalsUsersFields["email"] = isset($data["email"]) && !empty($data["email"]) ? $data["email"] : "";
        $hospitalsUsersFields["phone_code"] = isset($data["phone_code"]) && !empty($data["phone_code"]) ? $data["phone_code"] : "";
        $hospitalsUsersFields["phone"] = isset($data["phone_no"]) && !empty($data["phone_no"]) ? $data["phone_no"] : "";
        $hospitalsUsersFields["hospital_location_id"] = 1;
        $hospitalsUsersFields["role_id"] = 1;
        $hospitalsUsersFields["hospital_id"] = $hospitalsSaveData->hospital_id;
		$hospitalsUsersFields["password"] = base64_encode(convert_uuencode($getRandomPassword));
		$hospitalsUsersFields["is_active"] = 1;
		$hospitalsUsersFields["is_password_changed"] = 0;
		$hospitalsUsersFields["created_dttm"] = date("Y-m-d H:i:s");
		$hospitalsUsersFields["modified_dttm"] = date("Y-m-d H:i:s");
		//$hospitalsUsersFields["created_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
		//$hospitalsUsersFields["modified_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
		
		$userSave = $hospitalUsersTable->newEntity($hospitalsUsersFields);
		$userSaveData = $hospitalUsersTable->save($userSave);
		//SAVE DATA IN "hospitalusers"
		
		return $userSaveData;
	}
	
	public function checkemail($email)
    {
		$hospitalUsersTable = TableRegistry::get("hospitalusers");
		$data = $hospitalUsersTable->find()->select()->where(["email"=>$email])->enableHydration(false)->first();
		return $data;
    }
}
?> 



















