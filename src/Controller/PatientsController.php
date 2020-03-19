<?php
namespace App\Controller;

use Cake\Event\Event;
use Cake\View\Helper\FormHelper;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\Folder;
use Cake\Mailer\Email;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class PatientsController extends AppController
{
	public function initialize()
    {
        parent::initialize();
		$this->loadComponent("Common");
		
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		if(!$hospitalID)
		{
			$this->redirect(['controller'=>'Login','action'=>'index']);
		}
	}
	
	public function index()
	{
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		
		//GET MASTERS DATA
		$data = $this->Common->mastersdata($hospitalID);
		
		$conditionsData = $data["conditionsData"];
		$deviceData = $data["deviceData"];
		$vitalsData = $data["vitalsData"];
		$nurseData = $data["nurseData"];
		//GET MASTERS DATA
		
		if(isset($this->request->getParam('pass')[0]))
		{
			$patientData = $this->Patients->getPatientDetails($this->request->getParam('pass')[0]);
			
			if(isset($patientData["patientconditions"]) && !empty($patientData["patientconditions"]))
			{
				foreach($patientData["patientconditions"] as $key => $value)
				{
					if($value["is_active"]==1)
					{
						$savedConditions[] = $value["condition_id"];
					}
				}
			}
			
			if(isset($patientData["patientvitalsettings"]) && !empty($patientData["patientvitalsettings"]))
			{
				foreach($patientData["patientvitalsettings"] as $key => $value)
				{
					$savedVitals[] = $value["vital_id"];
				}
			}
			
			if(isset($patientData["patientdevices"]) && !empty($patientData["patientdevices"]))
			{
				foreach($patientData["patientdevices"] as $key => $value)
				{
					if($value["is_active"]==1)
					{
						$savedDevices[] = $value["device_id"];
						$serialNo[] = $value["serial_no"];
					}
				}
			}
			//echo "<pre>"; print_r($patientData); die;
			$this->set(compact("patientData","savedConditions","savedVitals","savedDevices","serialNo"));
		}
		
		$this->set(compact("conditionsData","deviceData","vitalsData","nurseData"));
	}
	
	public function save()
	{
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		$hospitalUserID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_user_id") : "";
		
		$data = $this->request->getData();
		
		$str_result = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$data["code"] = substr(str_shuffle($str_result),0,6);
		
		$data["hospitalID"] = $hospitalID; //FROM SESSION
		$data["hospitalUserID"] = $hospitalUserID; //FROM SESSION
		//echo "<pre>"; print_r($data); die;
		
		$saveData = $this->Patients->savePatients($data);
		//print_r($saveData);die;
		
		if(empty($data["patient_id"]))
		{
			$mobileNo = $data["mobile_code"]." ".$data["mobile"];
			$message = "Thanks for being part of HealthArc community. Your verification code is: ".$data["code"].". Please download the app from the link below and use this verification code to register and start using the app.
			http://".$_SERVER["SERVER_NAME"]."/web-portal/download.php";
			
			$sendSMS = $this->sendSms($mobileNo,$message);
		}

		/*  CODE START EDIT BY MANOHAR */

		if(empty($data["patient_id"]))
		{
			$nurseID = $data["nurse_id"];
			$patientID = $saveData;
			// Create Sendbird User
			$this->addSendbirdUsers($hospitalID,$nurseID,$patientID);
			//$this->addSendbirdUsers($nurseID,$patientID);
		}

		/*  CODE END EDIT BY MANOHAR */
		echo $this->redirect(["controller"=>"Patients", "action"=>"listing"]);
	}
	
	function sendSms($mobileNo=null, $message=null)
	{
		if($mobileNo!='')
		{
			require_once(ROOT . DS . 'webroot' . DS  . 'aws' . DS . 'aws-autoloader.php');
			$params = array('credentials' => array('key' => healthArcAccessKey,'secret' =>healthArcSecretKey,),'region' =>healthArcRegion,'version' => healthArcVersion);
			$args = array(
				'MessageAttributes' => [
					'AWS.SNS.SMS.SenderID' => [
						   'DataType' => 'String',
						   'StringValue' => 'Unikove'
					]
				 ],
				"SMSType" => "Transactional",
				"PhoneNumber" =>$mobileNo,
				"Message" => $message
			);
			$sns = new \Aws\Sns\SnsClient($params);
			$result = $sns->publish($args);
			unset($sns);
		}
		return 'success';
	}
	
	function resendCode()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		
		$patientsTable = TableRegistry::get("patients");
		
		$str_result = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$code = substr(str_shuffle($str_result),0,6);
		
		$patientID = $this->request->getData("patient_id");
		
		$mobileNo = $this->request->getData("mobile");
		$message = "Thanks for being part of HealthArc community. Your verification code is: ".$code.". Please download the app from the link below and use this verification code to register and start using the app.
		".invitationLink."";
		
		$sendSMS = $this->sendSms($mobileNo,$message);
		
		//UPDATE DATA IN "patients"
		$patientsTable->updateAll(["code" => $code, "code_expiry" => date("Y-m-d H:i:s", time() + 86400)], ["patient_id"=>$patientID]);
		//UPDATE DATA IN "patients"
	}

	/*  CODE START EDIT BY MANOHAR 	*/

	private function addSendbirdUsers($hospitalID,$nurseID,$patientID)
	{
		$hospitalID = base64_encode($hospitalID);
		$nurseID = base64_encode($nurseID);
		$patientID = base64_encode($patientID);

		$statusCode = $this->checkSendbirdUser($hospitalID.'_'.$nurseID);
		//print_r($statusCode);die;
		if(isset($statusCode->error) && $statusCode->error==1)
		{
			//	Nurse not  register 
			$dataBody = [["user_id"=>$hospitalID.'_'.$nurseID,
					"nickname" => 'Nurse_'.$nurseID,
					"profile_url" =>''],
					["user_id"=>$hospitalID.'_'.$patientID,
					"nickname" => 'patient_'.$patientID,
					"profile_url" =>'']
			];			
		}else{
			$dataBody = ["user_id"=>$hospitalID.'_'.$patientID,
					"nickname" => 'patient_'.$patientID,
					"profile_url" =>''
			];
			
		}
		$dataBody = json_encode($dataBody);
		$url = "https://api-CFABD9CE-7713-4228-B930-4C3858CB41A4.sendbird.com/v3/users";
		$apiKey = 'f7d852febbd35afb9dcdf900d2abe084aee68a27'; 
		$headers = array(
		     'Api-Token: '.$apiKey
		);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $dataBody);
		$response = curl_exec($ch);
		$this->sendbirdCreateGroup($hospitalID,$nurseID,$patientID);
	}


	 function sendbirdCreateGroup($hospitalID,$nurseID,$patientID)
	{
		/*$hospitalID = base64_encode($hospitalID);
		$nurseID = base64_encode($nurseID);
		$patientID = base64_encode($patientID);*/
		$users = [$hospitalID.'_'.$nurseID, $hospitalID.'_'.$patientID];
		$hospitalID = base64_decode($hospitalID);
		$nurseID = base64_decode($nurseID);
		$patientID = base64_decode($patientID);

		$dataBody = [
			"name"=> 'ChatRoom'.$hospitalID.'-'.$nurseID.'-'.$patientID,
			"channel_url"=> 'GroupChannel'.$hospitalID.'_'.$nurseID.'_'.$patientID,			
			"custom_type"=> "sports",
			//"is_distinct"=> true,
			//"inviter_id"=> "Mac",
			"is_public"=> true,
			"user_ids"=> $users,
			
			];
		$dataBody = json_encode($dataBody);

		$url = "https://api-CFABD9CE-7713-4228-B930-4C3858CB41A4.sendbird.com/v3/group_channels";
		$apiKey = 'f7d852febbd35afb9dcdf900d2abe084aee68a27'; 
		$headers = array(
		     'Api-Token: '.$apiKey
		);
		// Send request to Server
		$ch = curl_init($url);
		// To save response in a variable from server, set headers;
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $dataBody);
		// Get response
		$response = curl_exec($ch);
		// Decode
		$result = json_decode($response);
		//echo"<pre>";print_r($result);die;
	}

	function checkSendbirdUser($nurseID)
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		//	https://api-CFABD9CE-7713-4228-B930-4C3858CB41A4.sendbird.com/v3/users/Mz7=

		$url = "https://api-CFABD9CE-7713-4228-B930-4C3858CB41A4.sendbird.com/v3/users/".$nurseID;
		$apiKey = 'f7d852febbd35afb9dcdf900d2abe084aee68a27'; 
		$headers = array(
		     'Api-Token: '.$apiKey
		);
		// Send request to Server
		$ch = curl_init($url);
		// To save response in a variable from server, set headers;
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $dataBody);
		// Get response
		$response = curl_exec($ch);
		// Decode
		$result = json_decode($response);
		return $result;
		//echo"<pre>";print_r($result);die;
	}

	function sendbirdCheck()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		$nurseID = base64_decode('Mzk=');
		$patientID = base64_decode('MzI=');
		//echo $nurseID;die;
		//$hospitalID = base64_encode($hospitalID);
		//$nurseID = base64_encode($nurseID);
		//$patientID = base64_encode($patientID);

		//$this->addSendbirdUsers($hospitalID,$nurseID,$patientID);
		$this->sendbirdCreateGroup($hospitalID,$nurseID,$patientID);
	}
	/*  CODE END EDIT BY MANOHAR */
	
	public function listing()
	{
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		
		$patientMonitored = 1;
		$patientActive = 1;
		
		//GET ALL PATIENTS
		$patientsData = $this->Patients->allPatients($hospitalID,$patientMonitored,$patientActive);
		//GET ALL PATIENTS
		
		//echo "<pre>"; print_r($patientsData);die;
		$this->set(compact("patientsData"));
	}
	
	public function filterPatients()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		
		$patientMonitored = $this->request->getData("is_monitored");
		$patientActive = $this->request->getData("is_active");
		
		//GET ALL PATIENTS
		$patientsData = $this->Patients->allPatients($hospitalID,$patientMonitored,$patientActive);
		//GET ALL PATIENTS
		
		$this->set(compact("patientsData"));
		
		$this->render('/Element/Patients/allpatients');
	}
	
	public function deletecaregiver()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		
		$patientCaregiversTable = TableRegistry::get("patientcaregivers");
		
		$patientCaregiversTable->deleteAll(["patient_caregiver_id" => $this->request->getData("caregiverID")]);
	}
	
	public function gettemplatedata()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		
		//GET TEMPLATE DATA
		$templateData = $this->Patients->gettemplatedata($hospitalID,$this->request->getData("vitalID"));
		//GET TEMPLATE DATA
		
		echo json_encode($templateData);
	}
	
	public function checkemail()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		
		$checkemail = $this->Patients->checkemail($hospitalID,$this->request->getData("emailValue"));
		if(!empty($checkemail))
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
	
	public function checkmobile()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		
		$checkmobile = $this->Patients->checkmobile($hospitalID,$this->request->getData("mobileValue"));
		if(!empty($checkmobile))
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
	
	
	//Added by Vimlesh
	//Added by Vimlesh
	public function patientdetails($patientID)
	{
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		$patientsData = $this->Patients->patientDetails(base64_decode($patientID));
		$patientNotesData = $this->Patients->allPatientNotes(base64_decode($patientID),$hospitalID);
		$patientVitalsDataa = $this->Patients->patientVitalSettingsData(base64_decode($patientID));
		$patientDeviceData = $this->Patients->patientDeviceData(base64_decode($patientID));
		$vitalsData = $this->Common->vitalMasterData();
		$patientID=base64_decode($patientID);
		foreach ($patientVitalsDataa as $values) {
		    $key = $values['vital_id'];
		    $patientVitalsData[$key][] = $values;
		}
		// Don't want the vital_id in the keys? Reset them:
		$patientVitalsData = array_values($patientVitalsData);
		//$patientVitalsRecord = $this->Patients->patientVitalsData(base64_decode($patientID),'3',date('Y-m-d'));
		//$patientVitalsRecord=$patientVitalsRecord['patientVitalData'];
		//print_r($patientVitalsRecord);die;
		$data['patientID']=$patientID;
		$this->set(compact("patientsData","patientNotesData","patientVitalsData","patientDeviceData","patientID","vitalsData","data"));
		//$this->render('/Element/Patients/patientData');
		
	}
	public function savePatientNotes()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		$patientNotesTable = TableRegistry::get("patientnotes");
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		$hospitalUserID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_user_id") : "";
		$data = $this->request->getData();

		$patientID = $data['patientID'];
		if(isset($data['notes']) && $data['notes']!=""){
			$saveNotesData['patient_id']	=$patientID;
			$saveNotesData['notes']			=$this->request->getData("notes");
			$saveNotesData['recorded_dttm']	=date('Y-m-d H:i:s');
			$saveNotesData['hospital_user_id']	=$hospitalUserID;
			$saveNotesData['is_active']		='1';
			$saveNotesData['hospital_id']	=$hospitalID;
			$saveNotesData['created_dttm']	= date('Y-m-d H:i:s');
			$saveNotesData['created_by']	= $hospitalID;
			$notesSave = $patientNotesTable->newEntity($saveNotesData);
			$savedData = $patientNotesTable->save($notesSave);
		}
		//GET ALL PATIENT NOTES
		$patientNotesData = $this->Patients->allPatientNotes($patientID,$hospitalID);
		$this->set(compact("patientNotesData"));
		$this->render('/Element/Patients/allpatientNotes');
	}
	
	public function patientVitalsData($patientID='',$vitalID='')
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		$hospitalUserID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_user_id") : "";
		$data = $this->request->getData();
		$date=date('Y-m-d');
		$patientID = $data['patientID'];
		if(!empty($data) && isset($data['vitalID']) && $data['vitalID']!=""){
			$vitalID = $data['vitalID'];
			$date=date('Y-m-d',strtotime($data['date']));
		}
		$patientVitalsRecord = $this->Patients->patientVitalsData($patientID,'3',$date);
		//print_r($patientVitalsRecord);
		//$patientVitalsRecord = $this->Patients->patientVitalsData($patientID,$vitalID);
		$patientID=base64_decode($patientID);
		$this->set(compact("patientVitalsRecord","patientID"));
		$this->render('/Element/Patients/bodyWeight');
	}
	
	public function pulse()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		$data = $this->request->getData();
		$patientVitalsRecord = $this->Patients->patientVitalsData($data);
		$readingCompliancesPercnt = $this->Patients->readingCompliances($data);

		$trendPercnt=0;
		if(!empty($patientVitalsRecord) && isset($patientVitalsRecord['patientVitalData']) && !empty($patientVitalsRecord['patientVitalData']))
		$trendPercnt=ceil(array_sum(array_column($patientVitalsRecord['patientVitalData'], 'vital_value'))/count($patientVitalsRecord['patientVitalData']));
		$this->set(compact("patientVitalsRecord","readingCompliancesPercnt","trendPercnt","data"));
		$this->render('/Element/Patients/pulse');
	}
	public function spo2()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		$data = $this->request->getData();
		$patientVitalsRecord = $this->Patients->patientVitalsData($data);
		$readingCompliancesPercnt = $this->Patients->readingCompliances($data);
		$trendPercnt=0;
		if(!empty($patientVitalsRecord) && isset($patientVitalsRecord['patientVitalData']) && !empty($patientVitalsRecord['patientVitalData']))
		$trendPercnt=ceil(array_sum(array_column($patientVitalsRecord['patientVitalData'], 'vital_value'))/count($patientVitalsRecord['patientVitalData']));
		$this->set(compact("patientVitalsRecord","readingCompliancesPercnt","trendPercnt","data"));
		$this->render('/Element/Patients/spo2');
	}
	public function weight()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		$data = $this->request->getData();
		$patientVitalsRecord = $this->Patients->patientVitalsData($data);
		$readingCompliancesPercnt = $this->Patients->readingCompliances($data);
		$trendPercnt=0;
		if(!empty($patientVitalsRecord) && isset($patientVitalsRecord['patientVitalData']) && !empty($patientVitalsRecord['patientVitalData']))
		$trendPercnt=ceil(array_sum(array_column($patientVitalsRecord['patientVitalData'], 'vital_value'))/count($patientVitalsRecord['patientVitalData']));
	    //print_r($data);die;
		$this->set(compact("patientVitalsRecord","readingCompliancesPercnt","trendPercnt","data"));
		$this->render('/Element/Patients/weight');
		//die;
	}
	public function weightOld($patientID='',$vitalID='')
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		$data = $this->request->getData();
		$date=date('Y-m-d');
		$patientID = $data['patientID'];
		if(!empty($data) && isset($data['vitalID']) && $data['vitalID']!=""){
			$vitalID = $data['vitalID'];
			$date=date('Y-m-d',strtotime($data['date']));
		}
		$patientVitalsRecord = $this->Patients->patientVitalsData($patientID,'3',$date);
		//print_r($patientVitalsRecord);
		//$patientVitalsRecord = $this->Patients->patientVitalsData($patientID,$vitalID);
		$patientID=base64_decode($patientID);
		$this->set(compact("patientVitalsRecord","patientID"));
		$this->render('/Element/Patients/bodyWeight');
	}
	public function glucose()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		$data = $this->request->getData();
		$patientVitalsRecord = $this->Patients->patientVitalsData($data);
		$readingCompliancesPercnt = $this->Patients->readingCompliances($data);
		$trendPercnt=0;
		if(!empty($patientVitalsRecord) && isset($patientVitalsRecord['patientVitalData']) && !empty($patientVitalsRecord['patientVitalData']))
		$trendPercnt=ceil(array_sum(array_column($patientVitalsRecord['patientVitalData'], 'vital_value'))/count($patientVitalsRecord['patientVitalData']));
		$this->set(compact("patientVitalsRecord","readingCompliancesPercnt","trendPercnt","data"));
		$this->render('/Element/Patients/glucose');

	}
	public function bloodpressure(){
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		$data = $this->request->getData();
		$patientVitalsRecord = $this->Patients->patientVitalsData($data);
		$readingCompliancesPercnt = $this->Patients->readingCompliances($data);
		$trendPercnt=0;
		if(!empty($patientVitalsRecord) && isset($patientVitalsRecord['patientVitalData']) && !empty($patientVitalsRecord['patientVitalData']))
		$trendPercnt=ceil(array_sum(array_column($patientVitalsRecord['patientVitalData'], 'vital_value'))/count($patientVitalsRecord['patientVitalData']));
		$this->set(compact("patientVitalsRecord","readingCompliancesPercnt","trendPercnt","data"));
		$this->render('/Element/Patients/bloodPressure');
	}

	public function patientGraphView()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		$data = $this->request->getData();
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		$patientsData = $this->Patients->patientDetails($data['patientID']);
		

	}
	public function weightGraphView()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		$data = $this->request->getData();
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		$patientsData = $this->Patients->patientDetails($data['patientID']);
		$vitalGraphData = $this->Patients->vitalGraphData($data);
		$patientVitalsRecord = $this->Patients->patientVitalsData($data);
		$readingCompliancesPercnt = $this->Patients->readingCompliances($data);
		$trendPercnt=0;
		if(!empty($patientVitalsRecord) && isset($patientVitalsRecord['patientVitalData']) && !empty($patientVitalsRecord['patientVitalData']))
		$trendPercnt=ceil(array_sum(array_column($patientVitalsRecord['patientVitalData'], 'vital_value'))/count($patientVitalsRecord['patientVitalData']));
		
		/*echo "<pre>";
		print_r($vitalGraphData);
		die;*/
		$this->set(compact("patientsData","data","vitalGraphData","patientVitalsRecord","readingCompliancesPercnt","trendPercnt"));
		$this->render('/Element/Patients/weight_graph_view');
	}

	public function pulseGraphView()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		$data = $this->request->getData();
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		$patientsData = $this->Patients->patientDetails($data['patientID']);
		$vitalGraphData = $this->Patients->vitalGraphData($data);
		$patientVitalsRecord = $this->Patients->patientVitalsData($data);
		$readingCompliancesPercnt = $this->Patients->readingCompliances($data);
		$trendPercnt=0;
		if(!empty($patientVitalsRecord) && isset($patientVitalsRecord['patientVitalData']) && !empty($patientVitalsRecord['patientVitalData']))
		$trendPercnt=ceil(array_sum(array_column($patientVitalsRecord['patientVitalData'], 'vital_value'))/count($patientVitalsRecord['patientVitalData']));
		
		/*echo "<pre>";
		print_r($vitalGraphData);
		die;*/
		$this->set(compact("patientsData","data","vitalGraphData","patientVitalsRecord","readingCompliancesPercnt","trendPercnt"));
		$this->render('/Element/Patients/pulse_graph_view');

	}

	public function spo2GraphView()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		$data = $this->request->getData();
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		$patientsData = $this->Patients->patientDetails($data['patientID']);
		$vitalGraphData = $this->Patients->vitalGraphData($data);
		$patientVitalsRecord = $this->Patients->patientVitalsData($data);
		$readingCompliancesPercnt = $this->Patients->readingCompliances($data);
		$trendPercnt=0;
		if(!empty($patientVitalsRecord) && isset($patientVitalsRecord['patientVitalData']) && !empty($patientVitalsRecord['patientVitalData']))
		$trendPercnt=ceil(array_sum(array_column($patientVitalsRecord['patientVitalData'], 'vital_value'))/count($patientVitalsRecord['patientVitalData']));
		
		/*echo "<pre>";
		print_r($vitalGraphData);
		die;*/
		$this->set(compact("patientsData","data","vitalGraphData","patientVitalsRecord","readingCompliancesPercnt","trendPercnt"));
		$this->render('/Element/Patients/spo2_graph_view');

	}
	public function glucoseGraphView()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		$data = $this->request->getData();
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		$patientsData = $this->Patients->patientDetails($data['patientID']);
		$vitalGraphData = $this->Patients->vitalGraphData($data);
		$patientVitalsRecord = $this->Patients->patientVitalsData($data);
		$readingCompliancesPercnt = $this->Patients->readingCompliances($data);
		$trendPercnt=0;
		if(!empty($patientVitalsRecord) && isset($patientVitalsRecord['patientVitalData']) && !empty($patientVitalsRecord['patientVitalData']))
		$trendPercnt=ceil(array_sum(array_column($patientVitalsRecord['patientVitalData'], 'vital_value'))/count($patientVitalsRecord['patientVitalData']));
		
		/*echo "<pre>";
		print_r($vitalGraphData);
		die;*/
		$this->set(compact("patientsData","data","vitalGraphData","patientVitalsRecord","readingCompliancesPercnt","trendPercnt"));
		$this->render('/Element/Patients/glucose_graph_view');

	}
	public function bloodpressureGraphView()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		$data = $this->request->getData();
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		$patientsData = $this->Patients->patientDetails($data['patientID']);
		$vitalGraphData = $this->Patients->vitalGraphData($data);
		$patientVitalsRecord = $this->Patients->patientVitalsData($data);
		$readingCompliancesPercnt = $this->Patients->readingCompliances($data);
		$trendPercnt=0;
		if(!empty($patientVitalsRecord) && isset($patientVitalsRecord['patientVitalData']) && !empty($patientVitalsRecord['patientVitalData']))
		$trendPercnt=ceil(array_sum(array_column($patientVitalsRecord['patientVitalData'], 'vital_value'))/count($patientVitalsRecord['patientVitalData']));
		
		/*echo "<pre>";
		print_r($vitalGraphData);
		die;*/
		$this->set(compact("patientsData","data","vitalGraphData","patientVitalsRecord","readingCompliancesPercnt","trendPercnt"));
		$this->render('/Element/Patients/bloodpressure_graph_view');

	}
	public function graph($patientID='',$vitalID='')
	{
		$data = $this->request->getData();
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		$patientsData = $this->Patients->patientDetails(base64_decode($patientID));
		$vitalsData = $this->Common->vitalMasterData();
		$vitalmasterTable = TableRegistry::get("vitalmaster");
		$vitalData = $vitalmasterTable->find()->select(["vital_name"])->where(["vital_id"=>$vitalID])->enableHydration(false)->toArray();
		//print_r($vitalData);
		$this->set(compact("patientsData","vitalsData","vitalID","vitalData"));

	}
	//end Vimlesh
}










