<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class LoginTable extends Table
{
    public function checklogin($data)
    {
		$hospitalUsersTable = TableRegistry::get('hospitalusers');
		$hospitalUsersTable->belongsTo("hospitals",["foreignKey"=>"hospital_id"]);
		
		$data = $hospitalUsersTable->find()
									->select()
									->contain(["hospitals"])
									->where(["hospitals.sub_domain"=>$data["sub_domain"], "hospitalusers.email"=>$data["email"], "hospitalusers.hospital_id"=>$data["hospital_id"]])
									->enableHydration(false)
									->first();
		
		return $data;
    }
	
	public function checkcognitouser($email)
    {
		$hospitalUsersTable = TableRegistry::get("hospitalusers");
		//$data = $hospitalUsersTable->find()->select()->where(["hospital_id"=>$hospitalID,"email"=>$email])->enableHydration(false)->first();
		$data = $hospitalUsersTable->find()->select()->where(["email"=>$email])->enableHydration(false)->first();
		return $data;
    }
	
	public function updatepasswordfield($email,$password)
    {
		$hospitalUsersTable = TableRegistry::get("hospitalusers");
		$hospitalUsersTable->updateAll(['password' => base64_encode(convert_uuencode($password)), 'is_password_changed' => 1], ['email' => $email]);
    }
}
?> 



















