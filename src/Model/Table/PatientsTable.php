<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class PatientsTable extends Table
{
    public function savePatients($data)
    {
		$patientsTable = TableRegistry::get("patients");
		$patientCaregiversTable = TableRegistry::get("patientcaregivers");
		$patientDevicesTable = TableRegistry::get("patientdevices");
		$patientConditionsTable = TableRegistry::get("patientconditions");
		$patientNurseDoctorTable = TableRegistry::get("patientnursedoctor");
		$patientVitalSettingsTable = TableRegistry::get("patientvitalsettings");
		
		$bp_measure_frequency = isset($data["bp_measure_frequency"]) && !empty($data["bp_measure_frequency"]) && in_array(1,$data["vital_id"]) ? $data["bp_measure_frequency"] : 0;
		$pulse_measure_frequency = isset($data["pulse_measure_frequency"]) && !empty($data["pulse_measure_frequency"]) && in_array(3,$data["vital_id"]) ? $data["pulse_measure_frequency"] : 0;
		$weight_measure_frequency = isset($data["weight_measure_frequency"]) && !empty($data["weight_measure_frequency"]) && in_array(4,$data["vital_id"]) ? $data["weight_measure_frequency"] : 0;
		$spo_measure_frequency = isset($data["spo_measure_frequency"]) && !empty($data["spo_measure_frequency"]) && in_array(5,$data["vital_id"]) ? $data["spo_measure_frequency"] : 0;
		$glucose_measure_frequency = isset($data["glucose_measure_frequency"]) && !empty($data["glucose_measure_frequency"]) && in_array(6,$data["vital_id"]) ? $data["glucose_measure_frequency"] : 0;
		
		$measure_frequency_total = $bp_measure_frequency + $pulse_measure_frequency + $weight_measure_frequency + $spo_measure_frequency + $glucose_measure_frequency;
		
		if(!empty($data["dob"]))
		{
			$dateDOB = str_replace('/', '-', $data["dob"]);
			$explode = explode('-',$dateDOB);
			$dateDOB = $explode[2]."-".$explode[1]."-".$explode[0];
		}
		else
		{
			$dateDOB = date("Y-m-d");
		}
		
		//SAVE DATA IN "patients"
        $patientFields["patient_id"] = isset($data["patient_id"]) && !empty($data["patient_id"]) ? $data["patient_id"] : "";
        $patientFields["mrn_no"] = isset($data["mrn_no"]) ? $data["mrn_no"] : "";
        $patientFields["fname"] = isset($data["fname"]) ? $data["fname"] : "";
        $patientFields["mname"] = isset($data["mname"]) ? $data["mname"] : "";
        $patientFields["lname"] = isset($data["lname"]) ? $data["lname"] : "";
        $patientFields["email"] = isset($data["email"]) ? $data["email"] : "";
        $patientFields["mobile_code"] = isset($data["mobile_code"]) ? $data["mobile_code"] : "";
        $patientFields["mobile"] = isset($data["mobile"]) ? $data["mobile"] : "";
        $patientFields["gender"] = isset($data["gender"]) ? $data["gender"] : "";
        $patientFields["dob"] = $dateDOB ? $dateDOB : "";
        $patientFields["payer_type"] = isset($data["payer_type"]) ? $data["payer_type"] : "";
        $patientFields["payer_details"] = isset($data["payer_details"]) ? $data["payer_details"] : "";
		$patientFields["is_monitored"] = isset($data["is_monitored"]) ? 1 : 0;
		$patientFields["monitoring_start"] = isset($data["monitoring_start"]) ? $data["monitoring_start"] : "";
		$patientFields["monitoring_end"] = isset($data["monitoring_end"]) ? $data["monitoring_end"] : "";
		
		if(isset($data["patient_id"]) && empty($data["patient_id"]))
		{
			$patientFields["code"] = $data["code"];
			$patientFields["code_expiry"] = date("Y-m-d H:i:s", time() + 86400);
			$patientFields["is_active"] = 0;
		}
		
		$patientFields["password"] = hash("sha512",$data["fname"]);
		$patientFields["mobile_token"] = "";
		$patientFields["hospital_id"] = isset($data["hospitalID"]) && !empty($data["hospitalID"]) ? $data["hospitalID"] : ""; //hospitalID FROM SESSION
		$patientFields["measure_frequency_total"] = $measure_frequency_total;
		$patientFields["created_dttm"] = date("Y-m-d H:i:s");
		$patientFields["modified_dttm"] = date("Y-m-d H:i:s");
		$patientFields["created_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
		$patientFields["modified_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
		
		$patientsSave = $patientsTable->newEntity($patientFields);
		$patientsSaveData = $patientsTable->save($patientsSave);
		//SAVE DATA IN "patients"
		
		
		//SAVE DATA IN "patientconditions"
		if(isset($data["patient_id"]) && !empty($data["patient_id"])) // IN CASE OF UPDATE PATIENT
		{
			$patientConditionsTable->updateAll(['is_active' => 0], ['patient_id' => $data["patient_id"]]);
			
			$patientConditionsTableData = $patientConditionsTable->find()->select(["condition_id"])->where(["patient_id"=>$data["patient_id"]])->enableHydration(false)->toArray();
			
			$conditionsData = array();
			if(!empty($patientConditionsTableData)) {
				foreach($patientConditionsTableData as $key => $value) {
				$conditionsData[] = $value["condition_id"];
			} }
			
			if(!empty($data["condition_id"])){
				foreach($data["condition_id"] as $key => $value) {
					if(in_array($value,$conditionsData))
					{
						$patientConditionsTable->updateAll(['is_active' => 1], ['patient_id' => $data["patient_id"], 'condition_id' => $value]);
					}
					else
					{
						$PC_Fields["patient_id"] = $patientsSaveData->patient_id;
						$PC_Fields["condition_id"] = $value;
						$PC_Fields["measure_frequency"] = "";
						$PC_Fields["is_active"] = 1;
						$PC_Fields["created_dttm"] = date("Y-m-d H:i:s");
						$PC_Fields["modified_dttm"] = date("Y-m-d H:i:s");
						$PC_Fields["created_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
						$PC_Fields["modified_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
						$PC_Fields["hospital_id"] = isset($data["hospitalID"]) && !empty($data["hospitalID"]) ? $data["hospitalID"] : ""; //hospitalID FROM SESSION
						
						$patientConditionsSave = $patientConditionsTable->newEntity($PC_Fields);
						$patientConditionsSaveData = $patientConditionsTable->save($patientConditionsSave);
					}
			} }
		}
		if(isset($data["condition_id"]) && !empty($data["condition_id"]) && empty($data["patient_id"])) // IN CASE OF SAVE PATIENT
		{
			foreach($data["condition_id"] as $key => $value)
			{
				if(!empty($value))
				{
					$PC_Fields["patient_id"] = $patientsSaveData->patient_id;
					$PC_Fields["condition_id"] = $value;
					$PC_Fields["measure_frequency"] = "";
					$PC_Fields["is_active"] = 1;
					$PC_Fields["created_dttm"] = date("Y-m-d H:i:s");
					$PC_Fields["modified_dttm"] = date("Y-m-d H:i:s");
					$PC_Fields["created_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
					$PC_Fields["modified_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
					$PC_Fields["hospital_id"] = isset($data["hospitalID"]) && !empty($data["hospitalID"]) ? $data["hospitalID"] : ""; //hospitalID FROM SESSION
					
					$patientConditionsSave = $patientConditionsTable->newEntity($PC_Fields);
					$patientConditionsSaveData = $patientConditionsTable->save($patientConditionsSave);
				}
			}
		}
		//SAVE DATA IN "patientconditions"
		
		
		//SAVE DATA IN "patientvitalsettings"
		if(isset($data["patient_id"]) && !empty($data["patient_id"]))
		{
			$patientVitalSettingsTable->deleteAll(["patient_id"=>$data["patient_id"]]);
		}
		if(isset($data["vital_id"]) && !empty($data["vital_id"]))
		{
			foreach($data["vital_id"] as $key => $value)
			{
				if(!empty($value))
				{
					if($value==1) //BLOOD PRESSURE
					{
						$count = 0;
						foreach($data["bp_normal_min"] as $bpKey => $bpValue)
						{
							$count++;
							$PVS_Fields["patient_id"] = $patientsSaveData->patient_id;
							$PVS_Fields["vital_id"] = $count;
							$PVS_Fields["is_active"] = 1;
							$PVS_Fields["created_dttm"] = date("Y-m-d H:i:s");
							$PVS_Fields["modified_dttm"] = date("Y-m-d H:i:s");
							$PVS_Fields["created_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
							$PVS_Fields["modified_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
							$PVS_Fields["hospital_id"] = isset($data["hospitalID"]) && !empty($data["hospitalID"]) ? $data["hospitalID"] : ""; //hospitalID FROM SESSION
							
							$PVS_Fields["warning_min"] = $data["bp_warning_min"][$bpKey];
							$PVS_Fields["warning_max"] = $data["bp_warning_max"][$bpKey];
							$PVS_Fields["emergency_min"] = $data["bp_emergency_min"][$bpKey];
							$PVS_Fields["emergency_max"] = $data["bp_emergency_max"][$bpKey];
							$PVS_Fields["normal_min"] = $bpValue;
							$PVS_Fields["normal_max"] = $data["bp_normal_max"][$bpKey];
							$PVS_Fields["intervention_notes"] = $data["bp_intervention_notes"];
							$PVS_Fields["measure_frequency"] = $data["bp_measure_frequency"];
							
							$patientVitalSettingsSave = $patientVitalSettingsTable->newEntity($PVS_Fields);
							$patientVitalSettingsSaveData = $patientVitalSettingsTable->save($patientVitalSettingsSave);
						}
					}
					if($value==3) //PULSE PRESSURE
					{
						$PVS_Fields["warning_min"] = isset($data["pulse_warning_min"]) && !empty($data["pulse_warning_min"]) ? $data["pulse_warning_min"] : "";
						$PVS_Fields["warning_max"] = isset($data["pulse_warning_max"]) && !empty($data["pulse_warning_max"]) ? $data["pulse_warning_max"] : "";
						$PVS_Fields["emergency_min"] = isset($data["pulse_emergency_min"]) && !empty($data["pulse_emergency_min"]) ? $data["pulse_emergency_min"] : "";
						$PVS_Fields["emergency_max"] = isset($data["pulse_emergency_max"]) && !empty($data["pulse_emergency_max"]) ? $data["pulse_emergency_max"] : "";
						$PVS_Fields["normal_min"] = isset($data["pulse_normal_min"]) && !empty($data["pulse_normal_min"]) ? $data["pulse_normal_min"] : "";
						$PVS_Fields["normal_max"] = isset($data["pulse_normal_max"]) && !empty($data["pulse_normal_max"]) ? $data["pulse_normal_max"] : "";
						$PVS_Fields["intervention_notes"] = isset($data["pulse_intervention_notes"]) && !empty($data["pulse_intervention_notes"]) ? $data["pulse_intervention_notes"] : "";
						$PVS_Fields["measure_frequency"] = isset($data["pulse_measure_frequency"]) && !empty($data["pulse_measure_frequency"]) ? $data["pulse_measure_frequency"] : "";
					}
					if($value==4) //WEIGHT PRESSURE
					{
						$PVS_Fields["warning_min"] = isset($data["weight_warning_min"]) && !empty($data["weight_warning_min"]) ? $data["weight_warning_min"] : "";
						$PVS_Fields["warning_max"] = isset($data["weight_warning_max"]) && !empty($data["weight_warning_max"]) ? $data["weight_warning_max"] : "";
						$PVS_Fields["emergency_min"] = isset($data["weight_emergency_min"]) && !empty($data["weight_emergency_min"]) ? $data["weight_emergency_min"] : "";
						$PVS_Fields["emergency_max"] = isset($data["weight_emergency_max"]) && !empty($data["weight_emergency_max"]) ? $data["weight_emergency_max"] : "";
						$PVS_Fields["normal_min"] = isset($data["weight_normal_min"]) && !empty($data["weight_normal_min"]) ? $data["weight_normal_min"] : "";
						$PVS_Fields["normal_max"] = isset($data["weight_normal_max"]) && !empty($data["weight_normal_max"]) ? $data["weight_normal_max"] : "";
						$PVS_Fields["intervention_notes"] = isset($data["weight_intervention_notes"]) && !empty($data["weight_intervention_notes"]) ? $data["weight_intervention_notes"] : "";
						$PVS_Fields["measure_frequency"] = isset($data["weight_measure_frequency"]) && !empty($data["weight_measure_frequency"]) ? $data["weight_measure_frequency"] : "";
					}
					if($value==5) //SPO PRESSURE
					{
						$PVS_Fields["warning_min"] = isset($data["spo_warning_min"]) && !empty($data["spo_warning_min"]) ? $data["spo_warning_min"] : "";
						$PVS_Fields["warning_max"] = isset($data["spo_warning_max"]) && !empty($data["spo_warning_max"]) ? $data["spo_warning_max"] : "";
						$PVS_Fields["emergency_min"] = isset($data["spo_emergency_min"]) && !empty($data["spo_emergency_min"]) ? $data["spo_emergency_min"] : "";
						$PVS_Fields["emergency_max"] = isset($data["spo_emergency_max"]) && !empty($data["spo_emergency_max"]) ? $data["spo_emergency_max"] : "";
						$PVS_Fields["normal_min"] = isset($data["spo_normal_min"]) && !empty($data["spo_normal_min"]) ? $data["spo_normal_min"] : "";
						$PVS_Fields["normal_max"] = isset($data["spo_normal_max"]) && !empty($data["spo_normal_max"]) ? $data["spo_normal_max"] : "";
						$PVS_Fields["intervention_notes"] = isset($data["spo_intervention_notes"]) && !empty($data["spo_intervention_notes"]) ? $data["spo_intervention_notes"] : "";
						$PVS_Fields["measure_frequency"] = isset($data["spo_measure_frequency"]) && !empty($data["spo_measure_frequency"]) ? $data["spo_measure_frequency"] : "";
					}
					if($value==6) //GLUCOSE PRESSURE
					{
						$PVS_Fields["warning_min"] = isset($data["glucose_warning_min"]) && !empty($data["glucose_warning_min"]) ? $data["glucose_warning_min"] : "";
						$PVS_Fields["warning_max"] = isset($data["glucose_warning_max"]) && !empty($data["glucose_warning_max"]) ? $data["glucose_warning_max"] : "";
						$PVS_Fields["emergency_min"] = isset($data["glucose_emergency_min"]) && !empty($data["glucose_emergency_min"]) ? $data["glucose_emergency_min"] : "";
						$PVS_Fields["emergency_max"] = isset($data["glucose_emergency_max"]) && !empty($data["glucose_emergency_max"]) ? $data["glucose_emergency_max"] : "";
						$PVS_Fields["normal_min"] = isset($data["glucose_normal_min"]) && !empty($data["glucose_normal_min"]) ? $data["glucose_normal_min"] : "";
						$PVS_Fields["normal_max"] = isset($data["glucose_normal_max"]) && !empty($data["glucose_normal_max"]) ? $data["glucose_normal_max"] : "";
						$PVS_Fields["intervention_notes"] = isset($data["glucose_intervention_notes"]) && !empty($data["glucose_intervention_notes"]) ? $data["glucose_intervention_notes"] : "";
						$PVS_Fields["measure_frequency"] = isset($data["glucose_measure_frequency"]) && !empty($data["glucose_measure_frequency"]) ? $data["glucose_measure_frequency"] : "";
					}
					
					if($value!=1)
					{
						$PVS_Fields["patient_id"] = $patientsSaveData->patient_id;
						$PVS_Fields["vital_id"] = $value;
						$PVS_Fields["is_active"] = 1;
						$PVS_Fields["created_dttm"] = date("Y-m-d H:i:s");
						$PVS_Fields["modified_dttm"] = date("Y-m-d H:i:s");
						$PVS_Fields["created_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
						$PVS_Fields["modified_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
						$PVS_Fields["hospital_id"] = isset($data["hospitalID"]) && !empty($data["hospitalID"]) ? $data["hospitalID"] : ""; //hospitalID FROM SESSION
						
						$patientVitalSettingsSave = $patientVitalSettingsTable->newEntity($PVS_Fields);
						$patientVitalSettingsSaveData = $patientVitalSettingsTable->save($patientVitalSettingsSave);
					}
				}
			}
		}
		//SAVE DATA IN "patientvitalsettings"
		
		
		//SAVE DATA IN "patientdevices"
		if(isset($data["patient_id"]) && !empty($data["patient_id"])) // IN CASE OF UPDATE PATIENT
		{
			$patientDevicesTable->updateAll(['is_active' => 0], ['patient_id' => $data["patient_id"]]);
			
			$patientDevicesTableData = $patientDevicesTable->find()->select(["device_id"])->where(["patient_id"=>$data["patient_id"]])->enableHydration(false)->toArray();
			
			$deviceData = array();
			if(!empty($patientDevicesTableData)) {
				foreach($patientDevicesTableData as $key => $value) {
				$deviceData[] = $value["device_id"];
			} }
			
			if(!empty($data["device_id"])){
				foreach($data["device_id"] as $key => $value) {
					if(in_array($value,$deviceData))
					{
						$patientDevicesTable->updateAll(['is_active' => 1], ['patient_id' => $data["patient_id"], 'device_id' => $value]);
					}
					else
					{
						$PD_Fields["patient_id"] = $patientsSaveData->patient_id;
						$PD_Fields["device_id"] = $value;
						$PD_Fields["procured_by"] = $data["procured_by"];
						$PD_Fields["serial_no"] = $data["serial_no"][$key];
						$PD_Fields["is_active"] = 1;
						$PD_Fields["created_dttm"] = date("Y-m-d H:i:s");
						$PD_Fields["modified_dttm"] = date("Y-m-d H:i:s");
						$PD_Fields["created_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
						$PD_Fields["modified_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
						$PD_Fields["hospital_id"] = isset($data["hospitalID"]) && !empty($data["hospitalID"]) ? $data["hospitalID"] : ""; //hospitalID FROM SESSION
						
						$patientDevicesSave = $patientDevicesTable->newEntity($PD_Fields);
						$patientDevicesSaveData = $patientDevicesTable->save($patientDevicesSave);
					}
			} }
		}
		if(isset($data["device_id"]) && !empty($data["device_id"]) && empty($data["patient_id"])) // IN CASE OF SAVE PATIENT
		{
			foreach($data["device_id"] as $key => $value)
			{
				if(!empty($value))
				{
					$PD_Fields["patient_id"] = $patientsSaveData->patient_id;
					$PD_Fields["device_id"] = $value;
					$PD_Fields["procured_by"] = $data["procured_by"];
					$PD_Fields["serial_no"] = $data["serial_no"][$key];
					$PD_Fields["is_active"] = 1;
					$PD_Fields["created_dttm"] = date("Y-m-d H:i:s");
					$PD_Fields["modified_dttm"] = date("Y-m-d H:i:s");
					$PD_Fields["created_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
					$PD_Fields["modified_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
					$PD_Fields["hospital_id"] = isset($data["hospitalID"]) && !empty($data["hospitalID"]) ? $data["hospitalID"] : ""; //hospitalID FROM SESSION
					
					$patientDevicesSave = $patientDevicesTable->newEntity($PD_Fields);
					$patientDevicesSaveData = $patientDevicesTable->save($patientDevicesSave);
				}
			}
		}
		//SAVE DATA IN "patientdevices"
		
		
		//SAVE DATA IN "patientcaregivers"
		if(isset($data["caregiver_fname"]) && !empty($data["caregiver_fname"]))
		{
			foreach($data["caregiver_fname"] as $key => $value)
			{
				if(!empty($value))
				{
					$PC_Fields["patient_caregiver_id"] = isset($data["patient_caregiver_id"]) ? $data["patient_caregiver_id"][$key] : "";;
					$PC_Fields["patient_id"] = $patientsSaveData->patient_id;
					$PC_Fields["fname"] = $value;
					$PC_Fields["lname"] = $data["caregiver_lname"][$key];
					$PC_Fields["email"] = $data["caregiver_email"][$key];
					$PC_Fields["phone_code"] = $data["caregiver_phone_code"][$key];
					$PC_Fields["phone"] = $data["caregiver_phone"][$key];
					$PC_Fields["is_primary"] = count($data["caregiver_fname"]==1) ? 1 : ((isset($data["is_primary"]) && $data["is_primary"][0]==$key+1) ? 1 : 0);
					$PC_Fields["is_active"] = 1;
					$PC_Fields["created_dttm"] = date("Y-m-d H:i:s");
					$PC_Fields["modified_dttm"] = date("Y-m-d H:i:s");
					$PC_Fields["created_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
					$PC_Fields["modified_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
					$PC_Fields["hospital_id"] = isset($data["hospitalID"]) && !empty($data["hospitalID"]) ? $data["hospitalID"] : ""; //hospitalID FROM SESSION
					
					$patientCaregiversSave = $patientCaregiversTable->newEntity($PC_Fields);
					$patientCaregiversSaveData = $patientCaregiversTable->save($patientCaregiversSave);
				}
			}
		}
		//SAVE DATA IN "patientcaregivers"
		
		//SAVE DATA IN "patientnursedoctor"
		$PND_Fields["patient_nurse_doctor_id"] = isset($data["patient_nurse_doctor_id"]) && !empty($data["patient_nurse_doctor_id"]) ? $data["patient_nurse_doctor_id"] : "";
		$PND_Fields["patient_id"] = $patientsSaveData->patient_id;
		$PND_Fields["nurse_id"] = isset($data["nurse_id"]) && !empty($data["nurse_id"]) ? $data["nurse_id"] : "";
		$PND_Fields["doctor_id"] = "";
		$PND_Fields["is_active"] = 1;
		$PND_Fields["created_dttm"] = date("Y-m-d H:i:s");
		$PND_Fields["modified_dttm"] = date("Y-m-d H:i:s");
		$PND_Fields["created_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
		$PND_Fields["modified_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
		$PND_Fields["hospital_id"] = isset($data["hospitalID"]) && !empty($data["hospitalID"]) ? $data["hospitalID"] : ""; //hospitalID FROM SESSION
		
		$patientNurseDoctorSave = $patientNurseDoctorTable->newEntity($PND_Fields);
		$patientNurseDoctorSaveData = $patientNurseDoctorTable->save($patientNurseDoctorSave);
		//SAVE DATA IN "patientnursedoctor"

		/*	CODE START EDIT BY MANOHAR	*/
		return $patientsSaveData->patient_id;
		/*	CODE END EDIT BY MANOHAR	*/
    }
	
	public function allPatients($hospitalID,$patientMonitored,$patientActive)
	{
		$monitoredCondition = array();
		$activeCondition = array();
		$condition = array("hospital_id"=>$hospitalID);
		
		if($patientMonitored==0 || $patientMonitored==1)
		{
			$monitoredCondition = array("is_monitored"=>$patientMonitored);
		}
		if($patientActive==0 || $patientActive==1)
		{
			$activeCondition = array("is_active"=>$patientActive);
		}
		
		$patientsTable = TableRegistry::get("patients");
		$data = $patientsTable->find()
						      ->select(["patient_id","fname","mname","lname","mobile_code","mobile","is_active"])
							  ->where(array_merge($monitoredCondition,$activeCondition,$condition))
							  ->enableHydration(false)
							  ->toArray();
		return $data;
	}
	
	public function getPatientDetails($patientID)
	{
		$patients = TableRegistry::get("patients");
		$patients->hasMany("patientconditions",["foreignKey"=>"patient_id"]);
		$patients->hasMany("patientcaregivers",["foreignKey"=>"patient_id"]);
		$patients->hasMany("patientdevices",["foreignKey"=>"patient_id"]);
		$patients->hasMany("patientvitalsettings",["foreignKey"=>"patient_id"]);
		$patients->hasOne("patientnursedoctor",["foreignKey"=>"patient_id"]);
		
		$data = $patients->find()
					     ->select()
						 ->where(["patients.patient_id"=>base64_decode($patientID)])
						 ->contain(["patientconditions","patientcaregivers","patientdevices","patientvitalsettings","patientnursedoctor"])
						 ->enableHydration(false)
						 ->first();
		return $data;
	}
	
	public function gettemplatedata($hospitalID,$vitalID)
	{
		$hospitalTemplateAlertsTable = TableRegistry::get("hospitaltemplatealerts");
		$data = $hospitalTemplateAlertsTable->find()
											->where(["hospital_id"=>$hospitalID, "vital_id"=>$vitalID])
											->enableHydration(false)
											->toArray();
		return $data;
	}
	
	public function checkemail($hospitalID,$email)
    {
		$patientsTable = TableRegistry::get("patients");
		//$data = $hospitalUsersTable->find()->select()->where(["hospital_id"=>$hospitalID,"email"=>$email])->enableHydration(false)->first();
		$data = $patientsTable->find()->select()->where(["email"=>$email])->enableHydration(false)->first();
		return $data;
    }
	
	public function checkmobile($hospitalID,$mobile)
    {
		$patientsTable = TableRegistry::get("patients");
		//$data = $hospitalUsersTable->find()->select()->where(["hospital_id"=>$hospitalID,"mobile"=>$mobile])->enableHydration(false)->first();
		$data = $patientsTable->find()->select()->where(["mobile"=>$mobile])->enableHydration(false)->first();
		return $data;
    }
	
	
	//Added by Vimlesh
	public function patientDetails($patientID)
	{
		$conn = ConnectionManager::get("default");
		$patientsQuery = $conn->execute('SELECT patients.patient_id, CONCAT(patients.fname," ",patients.mname," ",patients.lname) AS name,patients.mrn_no, CONCAT_WS(" ",patients.mobile_code,patients.mobile) AS mobile, patients.email, patients.dob, patients.image_url,patients.image_url,CASE WHEN patients.payer_type=1 THEN "Medicare"  WHEN patients.payer_type=2 THEN "Commercial" ELSE "" END AS payer_type,patients.payer_details, GROUP_CONCAT(DISTINCT conditionmaster.condition_name SEPARATOR  ", ") AS condition_name,CASE WHEN patientnursedoctor.doctor_id IS NULL THEN patientnursedoctor.nurse_id  WHEN patientnursedoctor.doctor_id IS NOT NULL THEN patientnursedoctor.doctor_id ELSE "" END AS providerId, CONCAT(hospitalusers.fname," ",hospitalusers.lname) AS prviderName , CONCAT_WS(" ",hospitalusers.phone_code,hospitalusers.phone) AS prviderPhone,CONCAT_WS(" ",patientcaregivers.phone_code,patientcaregivers.phone) AS caregiverPhone ,CONCAT_WS(" ",patientcaregivers.fname,patientcaregivers.lname) AS caregiverName,patientnotes.notes FROM patients INNER JOIN patientconditions ON patientconditions.patient_id = patients.patient_id INNER JOIN conditionmaster ON conditionmaster.condition_id = patientconditions.condition_id LEFT JOIN patientcaregivers ON patientcaregivers.patient_id = patients.patient_id LEFT JOIN patientnotes ON patientnotes.patient_id = patients.patient_id LEFT JOIN patientnursedoctor ON patientnursedoctor.patient_id = patients.patient_id LEFT JOIN hospitalusers ON hospitalusers.hospital_user_id = patientnursedoctor.doctor_id WHERE patients.patient_id='.$patientID);

		$patientsData = $patientsQuery ->fetchAll("assoc");
		return $patientsData;
	}
	public function allPatientNotes($patientID,$hospitalID)
	{
		$condition = array("patient_id"=>$patientID,"hospital_id"=>$hospitalID,"is_active"=>1);
		$patientsTable = TableRegistry::get("patientnotes");
		$data = $patientsTable->find()
						      ->select(["patient_id","notes","recorded_dttm","created_dttm","is_active"])
							  ->where($condition)
    						  ->order(['created_dttm' => 'DESC'])
							  ->enableHydration(false)
							  ->toArray();
		return $data;
	}
	
	public function patientVitalSettingsData($patientID)
	{
		$patientvitalsettings = TableRegistry::get("patientvitalsettings");
		$patientvitalsettings->belongsTo("vitalmaster",["foreignKey"=>"vital_id"]);
		
		$patientVitalSettingsData = $patientvitalsettings->find()
								   ->select(["patientvitalsettings.patient_id","patientvitalsettings.vital_id","patientvitalsettings.warning_min","patientvitalsettings.warning_max","patientvitalsettings.emergency_min","patientvitalsettings.emergency_max","patientvitalsettings.normal_min","patientvitalsettings.normal_max","patientvitalsettings.intervention_notes","vitalmaster.vital_name"])
								   ->where(["patientvitalsettings.patient_id"=>$patientID,"patientvitalsettings.is_active"=>1])
								   ->contain(["vitalmaster"])
								   ->order(["vitalmaster.vital_display_order"=>"ASC"])
								   ->enableHydration(false)
								   ->toArray();
		return $patientVitalSettingsData;
		
	}
	public function patientDeviceData($patientID)
	{
		$patientdevices = TableRegistry::get("patientdevices");
		$patientdevices->belongsTo("devicemaster",["foreignKey"=>"device_id"]);
		
		$patientDeviceData = $patientdevices->find()
								   ->select(["patientdevices.patient_id","patientdevices.device_id","devicemaster.device_model","patientdevices.serial_no"])
								   ->where(["patientdevices.patient_id"=>$patientID])
								   ->contain(["devicemaster"])
								   ->enableHydration(false)
								   ->toArray();
		return $patientDeviceData;
		
	}
	
	public function patientVitalsData($data)
	{
		$conn = ConnectionManager::get("default");
		$con ="patientvitaldata.patient_id=".$data['patientID'];
		if(!empty($data)){
			$vitalID = $data['vitalID'];

			if(isset($data['fromDate']) && $data['fromDate']!='' && $data['toDate']==''){
				$con .= " and STR_TO_DATE(patientvitaldata.recorded_dttm, '%Y-%m-%d') >='".date('Y-m-d',strtotime($data['fromDate']))."'";
			}
			elseif(isset($data['fromDate']) && $data['fromDate']=='' &&$data['toDate']!=''){
				$con .= " and STR_TO_DATE(patientvitaldata.recorded_dttm, '%Y-%m-%d') <='".date('Y-m-d',strtotime($data['toDate']))."'";
			}
			elseif( isset($data['fromDate']) && $data['fromDate']!='' && $data['toDate']!=''){
				$con .= " and STR_TO_DATE(patientvitaldata.recorded_dttm, '%Y-%m-%d') between '".date('Y-m-d',strtotime($data['fromDate']))."' and '".date('Y-m-d',strtotime($data['toDate']))."'";
			}else{
				  $con .=" AND MONTH(patientvitaldata.recorded_dttm) ='".date('m')."'";
			}
		}
		if(isset($data['vitalID']))
			$con .=" AND patientvitaldata.vital_id IN (".$data['vitalID'].")";

		$patientVitalsQuery = $conn->execute("SELECT patientvitaldata.*,vitalmaster.vital_unit,vitalmaster.vital_min_default,vitalmaster.vital_max_default  from patientvitaldata JOIN vitalmaster ON patientvitaldata.vital_id=vitalmaster.vital_id WHERE ".$con." ORDER BY patientvitaldata.recorded_dttm DESC");
		//return $patientVitalsQuery;

		$patientVitalData = $patientVitalsQuery ->fetchAll("assoc");

		$con="is_active='1' AND patient_id=".$data['patientID']."";
		if(isset($data['vitalID']))
			$con .=" AND vital_id IN (".$data['vitalID'].")";

		$patientsQuery = $conn->execute("SELECT count(patient_vital_data_id) as total,YEAR(recorded_dttm) as recordedYear FROM `patientvitaldata` WHERE $con group by YEAR(recorded_dttm) ");
		//return $patientsQuery;
		$patientSummaryData = $patientsQuery ->fetchAll("assoc");

		$patientLastMonthQuery = $conn->execute("SELECT  count(*) as lastImonthRec FROM patientvitaldata WHERE $con AND recorded_dttm BETWEEN NOW() - INTERVAL 30 DAY AND NOW()");
		$patientLastMonthRec = $patientLastMonthQuery ->fetchAll("assoc");
		
		$data = array("patientVitalData"=>$patientVitalData, "patientSummaryData"=>$patientSummaryData,"patientLastMonthRec"=>$patientLastMonthRec);
		return $data;
	}
	public function readingCompliances($data)
    {
    	$conn = ConnectionManager::get("default");
		//if(!empty($data)){
			$vitalID = $data['vitalID'];
			$con="is_active='1' AND patient_id=".$data['patientID']."";
			if(isset($data['vitalID']))
				$con .=" AND vital_id IN (".$data['vitalID'].")";
			

			$compliancesQuery = $conn->execute("SELECT monitoring_start,monitoring_end ,total_frequency , total_reading_taken , total_frequency * 100 / total_reading_taken AS percentage FROM (SELECT SUM(measure_frequency) total_frequency FROM patientvitalsettings where $con) a , (SELECT count(*) total_reading_taken FROM patientvitaldata where $con) b, (SELECT monitoring_start,monitoring_end FROM patients where is_active='1' AND patient_id=".$data['patientID'].") c ");
			$readingCompliances = $compliancesQuery ->fetchAll("assoc");
			$readingCompliancesPercnt=0;
			if(!empty($readingCompliances) && $readingCompliances[0]['total_frequency']!=''){
				$datediff=strtotime($readingCompliances[0]['monitoring_end'])-strtotime($readingCompliances[0]['monitoring_start']);
				$totalDays=round($datediff / (60 * 60 * 24));
				$total_frequency=$readingCompliances[0]['total_frequency']*$totalDays;
			    $readingCompliancesPercnt=ceil(($readingCompliances[0]['total_reading_taken']*100)/$total_frequency);
			}
			return $readingCompliancesPercnt;
		//}
	}
	public function vitalGraphData($data)
    {
    	$conn = ConnectionManager::get("default");
    	$patientsTable = TableRegistry::get("patients");
		//if(!empty($data)){
			$vitalID = $data['vitalID'];
			$con="is_active='1' AND patient_id=".$data['patientID']."";
			if(isset($data['vitalID']))
				$con .=" AND vital_id IN (".$data['vitalID'].")";
			$patientsData = $patientsTable->find()->select(["monitoring_start","monitoring_end"])->where(["patient_id"=>$data['patientID']])->enableHydration(false)->first();
			if(!empty($patientsData))
				$con .= " and STR_TO_DATE(patientvitaldata.recorded_dttm, '%Y-%m-%d') >='".date('Y-m-d',strtotime($patientsData['monitoring_start']))."' and STR_TO_DATE(patientvitaldata.recorded_dttm, '%Y-%m-%d') <='".date('Y-m-d')."'";

			$vitalsQuery = $conn->execute("SELECT AVG(vital_value) as avg_vital_value,MAX(vital_value) as max_vital ,recorded_dttm,count(*) as total_readings FROM patientvitaldata where $con order by patient_vital_data_id desc");
			$patientvitaldata = $vitalsQuery ->fetch("assoc");

			$measure_timeQuery = $conn->execute("SELECT measure_time FROM measurefrequencymaster where vital_id='".$data['vitalID']."' and measure_time >='". date('H:i:s')."' order by measure_time ASC");
			$frequencyData = $measure_timeQuery ->fetch("assoc");
			$lastReadingDay=0;
			if(!empty($patientvitaldata) && $patientvitaldata['recorded_dttm']!=''){
				$datediff=strtotime($patientvitaldata['recorded_dttm'])-strtotime(date('Y-m-d H:i:s'));
				$lastReadingDay=abs(round($datediff / (60 * 60 * 24)));
			}

			$data=array('patientvitaldata'=>$patientvitaldata,'frequencyData'=>$frequencyData,'lastReadingDay'=>$lastReadingDay);
			return $data;
		//}
	}
	//end Vimlesh
}
?> 



















