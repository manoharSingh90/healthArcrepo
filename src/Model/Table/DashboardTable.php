<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class DashboardTable extends Table
{
	public function allDoctors($hospitalID)
	{
		$hospitalUsersTable = TableRegistry::get("hospitalusers");
		$data = $hospitalUsersTable->find()
								   ->select(["hospital_user_id", "name" => $hospitalUsersTable->find()->func()->concat(["fname" => "identifier", " ", "lname" => "identifier"])])
								   ->where(["hospital_id"=>$hospitalID, "role_id"=>2])
								   ->enableHydration(false)
								   ->toArray();
		return $data;
	}
	
	public function allPatients($data)
	{
		$conn = ConnectionManager::get("default");
		
		$patientsTable = TableRegistry::get("patients");
		
		$currentDate = date("Y-m-d");
		
		//$condition = array("patients.hospital_id"=>$data["hospitalID"], "patients.is_monitored"=>1, "patients.monitoring_start <= "=>$currentDate, "patients.monitoring_end >= "=>$currentDate);
		
		$sortingOrder = "patients.fname";
		if(isset($data["sortingOrder"]) && $data["sortingOrder"]==1) // SORTING ON BASIS OF PATIENTS
		{
			$sortingOrder = "patients.fname ASC";
		}
		if(isset($data["sortingOrder"]) && $data["sortingOrder"]==2) // SORTING ON BASIS OF PROGRAM DURATION
		{
			$sortingOrder = "DATEDIFF(patients.monitoring_end,patients.monitoring_start) DESC";
		}
		
		
		$condition = array("patients.hospital_id"=>$data["hospitalID"], "patients.is_monitored"=>1);
		$complianceFilterCondition = "";
		$programDurationFilterCondition = "";
		$alertFilterCondition = "";
		if(isset($data["populationFilter"]) && !empty($data["populationFilter"])) // CHECK GENDER
		{
			$populationFilter = array("patients.gender"=>$data["populationFilter"]);
			$condition = array_merge($condition,$populationFilter);
		}
		if(isset($data["conditionFilter"]) && !empty($data["conditionFilter"])) // CHECK CONDITION
		{
			$conditionFilter = array("patientconditions.condition_id IN"=>$data["conditionFilter"]);
			$condition = array_merge($condition,$conditionFilter);
		}
		if(isset($data["payerFilter"]) && !empty($data["payerFilter"])) // CHECK PAYER TYPE
		{
			$payerFilter = array("patients.payer_type"=>$data["payerFilter"]);
			$condition = array_merge($condition,$payerFilter);
		}
		if(isset($data["providerFilter"]) && !empty($data["providerFilter"])) // CHECK DOCTOR
		{
			$providerFilter = array("hospitalusers.hospital_user_id"=>$data["providerFilter"]);
			$condition = array_merge($condition,$providerFilter);
		}
		if(isset($data["complianceFilter"]) && !empty($data["complianceFilter"])) // CHECK COMPLIANCE LEVEL
		{
			if($data["complianceFilter"]==1)
			{
				$end = 19;
			}
			if($data["complianceFilter"]==2)
			{
				$start = 20;
				$end = 40;
			}
			if($data["complianceFilter"]==3)
			{
				$start = 41;
				$end = 60;
			}
			if($data["complianceFilter"]==4)
			{
				$start = 61;
				$end = 80;
			}
			if($data["complianceFilter"]==5)
			{
				$start = 81;
			}
			
			if($data["complianceFilter"]==1)
			{
				$complianceFilterCondition = "(json_extract(patient_data, '$.vitalIDTotal')*100) / (DATEDIFF(CURDATE(),patients.monitoring_start) *patients.measure_frequency_total) <= ".$end." ";
			}
			if($data["complianceFilter"]==2 || $data["complianceFilter"]==3 || $data["complianceFilter"]==4)
			{
				$complianceFilterCondition = "(json_extract(patient_data, '$.vitalIDTotal')*100) / (DATEDIFF(CURDATE(),patients.monitoring_start) *patients.measure_frequency_total) BETWEEN ".$start." AND ".$end." ";
			}
			if($data["complianceFilter"]==5)
			{
				$complianceFilterCondition = "(json_extract(patient_data, '$.vitalIDTotal')*100) / (DATEDIFF(CURDATE(),patients.monitoring_start) *patients.measure_frequency_total) >= ".$start." ";
			}
		}
		if(isset($data["locationFilter"]) && !empty($data["locationFilter"])) // CHECK LOCATION
		{
			$locationFilter = array("hospitallocations.hospital_location_id"=>$data["locationFilter"]);
			$condition = array_merge($condition,$locationFilter);
		}
		if(isset($data["programDurationFilter"]) && !empty($data["programDurationFilter"])) // CHECK PROGRAM DURATION
		{
			if($data["programDurationFilter"]==1)
			{
				$start = 1;
				$end = 14;
			}
			if($data["programDurationFilter"]==2)
			{
				$start = 15;
				$end = 30;
			}
			if($data["programDurationFilter"]==3)
			{
				$start = 31;
				$end = 60;
			}
			if($data["programDurationFilter"]==4)
			{
				$start = 61;
				$end = 90;
			}
			if($data["programDurationFilter"]==5)
			{
				$start = 91;
				$end = 120;
			}
			if($data["programDurationFilter"]==6)
			{
				$start = 121;
			}
			
			if($data["programDurationFilter"]==1 || $data["programDurationFilter"]==2 || $data["programDurationFilter"]==3 || $data["programDurationFilter"]==4 || $data["programDurationFilter"]==5)
			{
				$programDurationFilterCondition = "DATEDIFF(patients.monitoring_end,patients.monitoring_start) BETWEEN ".$start." AND ".$end." ";
			}
			if($data["programDurationFilter"]==6)
			{
				$programDurationFilterCondition = "DATEDIFF(patients.monitoring_end,patients.monitoring_start) >= ".$start." ";
			}
		}
		if(isset($data["alertFilter"]) && !empty($data["alertFilter"])) // CHECK ALERT
		{
			$alertFilterCondition = "json_extract(patient_data, '$.vital_value_type') LIKE '%".$data["alertFilter"]."%' ";
		}
		
		$patientsData = $patientsTable->find()
						->select(["patients.patient_id", "name"=>"CONCAT(patients.fname,' ',patients.lname)", "patients.dob", "patients.image_url", "patients.monitoring_start", "patients.monitoring_end", "measure_frequency_total"=>"patients.measure_frequency_total", "patient_data"=>"patients.patient_data", "patientappointmentrequests_data"=>"patients.patientappointmentrequests_data",  "condition_abbreviation"=>"GROUP_CONCAT(DISTINCT conditionmaster.condition_abbreviation SEPARATOR  ', ')", "notes"=>"MAX(patientnotes.notes)", "doctor_id"=>"patientnursedoctor.doctor_id", "doctorName"=>"CONCAT(hospitalusers.fname,' ',hospitalusers.lname)"])
						->join([
							'patientconditions' => [
								'table' => 'patientconditions',
								'type' => 'INNER',
								'conditions' => 'patientconditions.patient_id = patients.patient_id',
							],
							'conditionmaster' => [
								'table' => 'conditionmaster',
								'type' => 'INNER',
								'conditions' => 'conditionmaster.condition_id = patientconditions.condition_id',
							],
							'patientnotes' => [
								'table' => 'patientnotes',
								'type' => 'LEFT',
								'conditions' => 'patientnotes.patient_id = patients.patient_id',
							],
							'patientnursedoctor' => [
								'table' => 'patientnursedoctor',
								'type' => 'LEFT',
								'conditions' => 'patientnursedoctor.patient_id = patients.patient_id',
							],
							'hospitalusers' => [
								'table' => 'hospitalusers',
								'type' => 'LEFT',
								'conditions' => 'CASE WHEN patientnursedoctor.doctor_id!="" THEN hospitalusers.hospital_user_id = patientnursedoctor.doctor_id ELSE hospitalusers.hospital_user_id = patientnursedoctor.nurse_id END',
							],
							'hospitallocations' => [
								'table' => 'hospitallocations',
								'type' => 'LEFT',
								'conditions' => 'hospitallocations.hospital_location_id = hospitalusers.hospital_location_id',
							]
						])
						->where($condition)
						->where($complianceFilterCondition)
						->where($programDurationFilterCondition)
						->where($alertFilterCondition)
						->group("patients.patient_id")
						->order($sortingOrder)
						->enableHydration(false);
						//->toArray();
		
		//echo "<pre>"; print_r($patientsData); die;
		return $patientsData;
	}
	
	public function updatepatientdata($data)
	{
		$patientsTable = TableRegistry::get("patients");
		
		$conn = ConnectionManager::get("default");
		$data["hospitalID"] = 1;
		$patientVitalDataQuery = $conn->execute('SELECT patient_vital_data_id, patient_id, vital_id, vital_value, vital_value_type FROM patientvitaldata WHERE hospital_id='.$data["hospitalID"].' AND patient_vital_data_id IN ( SELECT MAX(patient_vital_data_id) FROM patientvitaldata GROUP BY patient_id,vital_id ) ORDER BY patientvitaldata.patient_id');
		$patientVitalData = $patientVitalDataQuery->fetchAll("assoc");
		
		$checkPatientArray = array();
		if(!empty($patientVitalData))
		{
			foreach($patientVitalData as $key => $value)
			{
				if(!in_array($value["patient_id"],$checkPatientArray))
				{
					$checkPatientArray[] = $value["patient_id"];
				}
			}
		}
		$newArray = array();
		if(!empty($checkPatientArray))
		{
			foreach($checkPatientArray as $key => $value)
			{
				$abc = 0;
				foreach($patientVitalData as $k => $v)
				{
					if($value==$v["patient_id"])
					{
						$newArray[$key]["patient_id"] = $v["patient_id"];
						$newArray[$key]["vital_id"][$abc] = $v["vital_id"];
						$newArray[$key]["vital_value"][$abc] = $v["vital_value"];
						$newArray[$key]["vital_value_type"][$abc] = $v["vital_value_type"];
						$abc++;
					}
				}
			}
		}
		
		$countPatientVitalDataQuery = $conn->execute('SELECT patientvitaldata.patient_id, COUNT(CASE WHEN patientvitaldata.vital_id=1 THEN 1 WHEN patientvitaldata.vital_id=3 THEN 1 WHEN patientvitaldata.vital_id=4 THEN 1 WHEN patientvitaldata.vital_id=5 THEN 1 WHEN patientvitaldata.vital_id=6 THEN 1 END) AS vitalIDTotal FROM patientvitaldata INNER JOIN patients ON patients.patient_id = patientvitaldata.patient_id WHERE patients.hospital_id='.$data["hospitalID"].' AND patients.is_monitored=1 GROUP BY patients.patient_id');
		$countPatientVitalData = $countPatientVitalDataQuery->fetchAll("assoc");
		
		$finalArray = array();
		if(!empty($newArray) && !empty($countPatientVitalData))
		{
			foreach($countPatientVitalData as $key => $value)
			{
				foreach($newArray as $k => $v)
				{
					if($value["patient_id"]==$v["patient_id"])
					{
						$finalArray[$key]["patient_id"] = $v["patient_id"];
						$finalArray[$key]["vital_id"] = $v["vital_id"];
						$finalArray[$key]["vital_value"] = $v["vital_value"];
						$finalArray[$key]["vital_value_type"] = $v["vital_value_type"];
						$finalArray[$key]["vitalIDTotal"] = $value["vitalIDTotal"];
					}
				}
			}
		}
		
		$patientAppointmentRequestsQuery = $conn->execute('SELECT patient_appointment_request_id, patient_id, appointment_type, is_completed FROM patientappointmentrequests WHERE hospital_id='.$data["hospitalID"].' AND patient_appointment_request_id IN (SELECT MAX(patient_appointment_request_id) FROM patientappointmentrequests WHERE is_completed=0 GROUP BY patient_id)');
		$patientAppointmentRequestsData = $patientAppointmentRequestsQuery->fetchAll("assoc");
		
		//echo "<pre>"; print_r($patientAppointmentRequestsData);die;
		if(!empty($finalArray))
		{
			foreach($finalArray as $key => $value)
			{
				$jsonData = json_encode(array("vital_id"=>$value["vital_id"], "vital_value"=>$value["vital_value"], "vital_value_type"=>$value["vital_value_type"], "vitalIDTotal"=>$value["vitalIDTotal"]));
				
				$patientsTable->updateAll(["patient_data"=>$jsonData], ["patient_id" => $value["patient_id"]]);
				
			}
		}
		
		if(!empty($patientAppointmentRequestsData))
		{
			foreach($patientAppointmentRequestsData as $key => $value)
			{
				$jsonData = json_encode(array("patient_id"=>$value["patient_id"], "patient_appointment_request_id"=>$value["patient_appointment_request_id"], "appointment_type"=>$value["appointment_type"], "is_completed"=>$value["is_completed"]));
				
				$patientsTable->updateAll(["patientappointmentrequests_data"=>$jsonData], ["patient_id" => $value["patient_id"]]);
				
			}
		}
	}
	
	public function allLocation($hospitalID)
	{
		$conn = ConnectionManager::get("default");
		
		$locationQuery = $conn->execute('SELECT hospitallocations.hospital_location_id, hospitallocations.location_name, hospitallocations.city FROM hospitallocations INNER JOIN hospitalusers ON hospitallocations.hospital_location_id = hospitalusers.hospital_location_id WHERE hospitalusers.hospital_id='.$hospitalID.' AND hospitalusers.role_id=3 GROUP BY hospitallocations.hospital_location_id ');
		$locationData = $locationQuery ->fetchAll("assoc");
		
		return $locationData;
	}
	
	public function saveadditionaldetails($data)
	{
		$conn = ConnectionManager::get("default");
		
		$patientNotesTable = TableRegistry::get("patientnotes");
		$patientRemindersTable = TableRegistry::get("patientreminders");
		$patientBillingDetailsTable = TableRegistry::get("patientbillingdetails");
		$patientBillingTable = TableRegistry::get("patientbilling");
		$patientNurseDoctorTable = TableRegistry::get("patientnursedoctor");
		
		//SAVE DATA IN "patientnotes"
		if(!empty($data["notes"]))
		{
			$PN_Fields["patient_id"] = isset($data["patient_id"]) ? $data["patient_id"] : "";
			$PN_Fields["notes"] = isset($data["notes"]) ? $data["notes"] : "";
			$PN_Fields["recorded_dttm"] = date("Y-m-d H:i:s");
			$PN_Fields["hospital_user_id"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
			$PN_Fields["is_active"] = 1;
			$PN_Fields["created_dttm"] = date("Y-m-d H:i:s");
			$PN_Fields["modified_dttm"] = date("Y-m-d H:i:s");
			$PN_Fields["created_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
			$PN_Fields["modified_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
			$PN_Fields["hospital_id"] = isset($data["hospitalID"]) && !empty($data["hospitalID"]) ? $data["hospitalID"] : ""; //hospitalID FROM SESSION
		
			$patientNotesSave = $patientNotesTable->newEntity($PN_Fields);
			$patientNotesSaveData = $patientNotesTable->save($patientNotesSave);
		}
		//SAVE DATA IN "patientnotes"
		
		//SAVE DATA IN "patientreminders"
		if(!empty($data["reminder_date"]))
		{
			$PR_Fields["patient_id"] = isset($data["patient_id"]) ? $data["patient_id"] : "";
			$PR_Fields["hospital_user_id"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
			$PR_Fields["reminder_date"] = isset($data["reminder_date"]) ? $data["reminder_date"] : "";
			$PR_Fields["reminder_time"] = isset($data["reminder_time"]) ? $data["reminder_time"] : "";
			$PR_Fields["reminder_notes"] = isset($data["reminder_notes"]) ? $data["reminder_notes"] : "";
			$PR_Fields["is_active"] = 1;
			$PR_Fields["is_complete"] = 0;
			$PR_Fields["created_dttm"] = date("Y-m-d H:i:s");
			$PR_Fields["modified_dttm"] = date("Y-m-d H:i:s");
			$PR_Fields["created_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
			$PR_Fields["modified_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
			$PR_Fields["hospital_id"] = isset($data["hospitalID"]) && !empty($data["hospitalID"]) ? $data["hospitalID"] : ""; //hospitalID FROM SESSION
			
			$patientRemindersSave = $patientRemindersTable->newEntity($PR_Fields);
			$patientRemindersSaveData = $patientRemindersTable->save($patientRemindersSave);
		}
		//SAVE DATA IN "patientreminders"
		
		//SAVE DATA IN "patientbillingdetails"
		if(!empty($data["time_spent"]))
		{
			$PBD_Fields["patient_id"] = isset($data["patient_id"]) ? $data["patient_id"] : "";
			$PBD_Fields["hospital_user_id"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
			$PBD_Fields["time_spent"] = isset($data["time_spent"]) ? $data["time_spent"] : "";
			$PBD_Fields["recorded_dttm"] = date("Y-m-d H:i:s");
			$PBD_Fields["is_active"] = 1;
			$PBD_Fields["created_dttm"] = date("Y-m-d H:i:s");
			$PBD_Fields["modified_dttm"] = date("Y-m-d H:i:s");
			$PBD_Fields["created_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
			$PBD_Fields["modified_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
			$PBD_Fields["hospital_id"] = isset($data["hospitalID"]) && !empty($data["hospitalID"]) ? $data["hospitalID"] : ""; //hospitalID FROM SESSION
			
			$patientBillingDetailsSave = $patientBillingDetailsTable->newEntity($PBD_Fields);
			$patientBillingDetailsSaveData = $patientBillingDetailsTable->save($patientBillingDetailsSave);
		}
		//SAVE DATA IN "patientbillingdetails"
		
		//SAVE/UPDATE DATA IN "patientbilling"
		if(!empty($data["time_spent"]))
		{
			$savedQuery = $conn->execute('SELECT patient_billing_id FROM patientbilling WHERE MONTH(month_year) = MONTH(CURRENT_DATE()) AND YEAR(month_year) = YEAR(CURRENT_DATE()) AND patient_id='.$data["patient_id"].' ');
			$savedData = $savedQuery->fetch("assoc");
			if(empty($savedData))
			{
				$PB_Fields["patient_id"] = isset($data["patient_id"]) ? $data["patient_id"] : "";
				$PB_Fields["month_year"] = date("Y-m-d H:i:s");
				//$PB_Fields["billing_eligible"] = "";
				//$PB_Fields["billing_code_id"] = "";
				$PB_Fields["time_spent"] = isset($data["time_spent"]) ? $data["time_spent"] : "";
				$PB_Fields["no_of_readings"] = 1;
				$PB_Fields["is_active"] = 1;
				$PB_Fields["created_dttm"] = date("Y-m-d H:i:s");
				$PB_Fields["modified_dttm"] = date("Y-m-d H:i:s");
				$PB_Fields["created_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
				$PB_Fields["modified_by"] = isset($data["hospitalUserID"]) && !empty($data["hospitalUserID"]) ? $data["hospitalUserID"] : ""; //hospitalUserID FROM SESSION
				$PB_Fields["hospital_id"] = isset($data["hospitalID"]) && !empty($data["hospitalID"]) ? $data["hospitalID"] : ""; //hospitalID FROM SESSION
				
				$patientBillingSave = $patientBillingTable->newEntity($PB_Fields);
				$patientBillingData = $patientBillingTable->save($patientBillingSave);
			}
			else
			{
				$countQuery = $conn->execute('SELECT COUNT(patient_billing_details_id) AS totalCount, SUM(time_spent) AS totalSum FROM patientbillingdetails WHERE MONTH(created_dttm) = MONTH(CURRENT_DATE()) AND YEAR(created_dttm) = YEAR(CURRENT_DATE()) AND patient_id='.$data["patient_id"].' ');
				$countData = $countQuery->fetch("assoc");
				
				$patientBillingTable->updateAll(["time_spent"=>$countData["totalSum"], "no_of_readings"=>$countData["totalCount"]], ["patient_billing_id" => $savedData["patient_billing_id"]]);
			}
		}
		//SAVE/UPDATE DATA IN "patientbilling"
		
		//UPDATE DATA IN "patientnursedoctor"
		if(!empty($data["doctor_id"]))
		{
			$patientNurseDoctorTable->updateAll(["doctor_id"=>$data["doctor_id"]], ["patient_id" => $data["patient_id"]]);
		}
		//UPDATE DATA IN "patientnursedoctor"
		
		$checkArray = array();
		$patientNotesQuery = $conn->execute('SELECT notes FROM patientnotes WHERE patient_id='.$data["patient_id"].' ORDER BY patient_note_id DESC LIMIT 1');
		$patientNotesData = $patientNotesQuery->fetch("assoc");
		
		$doctorNameQuery = $conn->execute('SELECT CONCAT(hospitalusers.fname," ",hospitalusers.lname) AS doctorName FROM hospitalusers INNER JOIN patientnursedoctor ON hospitalusers.hospital_user_id = patientnursedoctor.doctor_id WHERE patientnursedoctor.patient_id='.$data["patient_id"].'');
		$doctorNameData = $doctorNameQuery->fetch("assoc");
		
		$checkArray["notes"] = !empty($patientNotesData["notes"]) ? $patientNotesData["notes"] : "";
		$checkArray["doctorName"] = !empty($doctorNameData["notes"]) ? $doctorNameData["notes"] : "";
		
		return $checkArray;
	}
	
	public function filterData($data)
	{
		$conn = ConnectionManager::get("default");
		//echo "<pre>"; print_r($data);die;
		$currentDate = date("Y-m-d");
		
		$condition = "";
		if(isset($data["hospitalID"]) && !empty($data["hospitalID"])) // CHECK HOSPITAL ID
		{
			$condition .= 'patients.hospital_id='.$data["hospitalID"].' ';
		}
		if(isset($data["populationFilter"]) && !empty($data["populationFilter"])) // CHECK GENDER
		{
			$condition .= 'AND patients.gender='.$data["populationFilter"].' ';
		}
		if(isset($data["conditionFilter"]) && !empty($data["conditionFilter"])) // CHECK CONDITION
		{
			$condition .= 'AND patientconditions.condition_id IN ('.$data["conditionFilter"].') ';
		}
		if(isset($data["payerFilter"]) && !empty($data["payerFilter"])) // CHECK PAYER TYPE
		{
			$condition .= 'AND patients.payer_type='.$data["payerFilter"].' ';
		}
		if(isset($data["providerFilter"]) && !empty($data["providerFilter"])) // CHECK DOCTOR
		{
			$condition .= 'AND hospitalusers.hospital_user_id='.$data["providerFilter"].' ';
		}
		if(isset($data["locationFilter"]) && !empty($data["locationFilter"])) // CHECK LOCATION
		{
			$condition .= 'AND hospitallocations.hospital_location_id='.$data["locationFilter"].' ';
		}
		
		$queryString = 'SELECT patients.patient_id, CONCAT(patients.fname," ",patients.lname) AS name, patients.dob, patients.image_url, patients.monitoring_start, patients.monitoring_end, GROUP_CONCAT(DISTINCT conditionmaster.condition_abbreviation SEPARATOR  ", ") AS condition_abbreviation, GROUP_CONCAT(DISTINCT patientappointmentrequests.appointment_type SEPARATOR  ", ") AS appointment_type, GROUP_CONCAT(DISTINCT patientappointmentrequests.is_completed SEPARATOR  ", ") AS is_completed, GROUP_CONCAT(DISTINCT patientvitaldata.vital_id SEPARATOR  ", ") AS vital_id, GROUP_CONCAT(DISTINCT patientvitaldata.vital_value SEPARATOR  ", ") AS vital_value, MAX(patientnotes.notes) AS notes, patientnursedoctor.doctor_id, CONCAT(hospitalusers.fname," ",hospitalusers.lname) AS doctorName 
		FROM patients 
		INNER JOIN patientconditions ON patientconditions.patient_id = patients.patient_id 
		INNER JOIN conditionmaster ON conditionmaster.condition_id = patientconditions.condition_id 
		LEFT JOIN patientappointmentrequests ON patientappointmentrequests.patient_id = patients.patient_id 
		LEFT JOIN patientvitaldata ON patientvitaldata.patient_id = patients.patient_id 
		LEFT JOIN patientnotes ON patientnotes.patient_id = patients.patient_id 
		LEFT JOIN patientnursedoctor ON patientnursedoctor.patient_id = patients.patient_id 
		LEFT JOIN hospitalusers ON CASE WHEN patientnursedoctor.doctor_id!="" THEN hospitalusers.hospital_user_id = patientnursedoctor.doctor_id ELSE hospitalusers.hospital_user_id = patientnursedoctor.nurse_id END
		LEFT JOIN hospitallocations ON hospitallocations.hospital_location_id = hospitalusers.hospital_location_id 
		WHERE '.$condition.' AND patients.is_monitored=1 AND "'.$currentDate.'" 
		BETWEEN patients.monitoring_start AND patients.monitoring_end 
		GROUP BY patients.patient_id';
		//echo "<pre>";echo $queryString; die;
		$patientsQuery = $conn->execute($queryString);
		$patientsData = $patientsQuery ->fetchAll("assoc");
		//echo "<pre>"; print_r($patientsData);die;
		return $patientsData;
	}
}
?> 



















