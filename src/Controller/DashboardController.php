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

class DashboardController extends AppController
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
		$data["hospitalID"] = $hospitalID;
		
		//GET MASTERS DATA
		$mastersData = $this->Common->mastersdata($hospitalID);
		
		$conditionsData = $mastersData["conditionsData"];
		//GET MASTERS DATA
		
		
		//GET ALL DOCTORS
		$doctorsData = $this->Dashboard->allDoctors($hospitalID);
		//GET ALL DOCTORS
		
		
		//GET ALL PATIENTS
		$this->paginate = ["limit"=>10];
		//$patientsData = $this->Dashboard->allPatients($data);
		$patientsData = $this->paginate($this->Dashboard->allPatients($data));
		//echo "<pre>"; print_r($patientsData);die;
		//echo "<pre>"; print_r($this->request->getParam('paging'));die;
		
		$pag_det = $this->request->getParam('paging');
		$parem = $pag_det['patients'];
		$total_page = $parem['pageCount'];
		$current_page = $parem['page'];
		$records = $parem['current'];
		$total_records = $parem['count'];
		if($current_page==1)
		{
			$pageinfo = 'Showing 1 to '.$records.' of '.$total_records.' Records';
		}
		else if($total_records==0)
		{
			$pageinfo = '';
		}
		else 
		{
			$start = (($current_page-1)*10)+1; 
			$pageinfo = 'Showing '.$start.' to '.(($start+$records)-1).' of '.$total_records.' Records';
		}
		//GET ALL PATIENTS
		
		
		//GET LOCATION OF NURSES
		$locationData = $this->Dashboard->allLocation($hospitalID);
		//GET LOCATION OF NURSES
		
		//echo "<pre>"; print_r($patientsData);die;
		$this->set(compact("conditionsData","doctorsData","patientsData","locationData","pageinfo"));
	}
	
	public function applyFilters()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		
		$data = $this->request->getData();
		$data["hospitalID"] = $hospitalID; //FROM SESSION
		
		$patientsData = $this->Dashboard->allPatients($data);
		//echo "<pre>"; print_r($filterData);die;
		
		$this->set(compact("patientsData"));
		
		$this->render('/Element/Dashboard/allpatients');
	}
	
	public function refreshdata()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		
		$data = $this->request->getData();
		$data["hospitalID"] = $hospitalID; //FROM SESSION
		
		$patientsData = $this->Dashboard->allPatients($data);
		//echo "<pre>"; print_r($filterData);die;
		
		$this->set(compact("patientsData"));
		
		$this->render('/Element/Dashboard/allpatients');
	}
	
	public function patientdata()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		
		$data = $this->request->getData();
		$data["hospitalID"] = $hospitalID; //FROM SESSION
		
		$patientsData = $this->Dashboard->updatepatientdata($data);
	}
	
	public function saveadditionaldetails()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		$hospitalUserID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_user_id") : "";
		
		$data = $this->request->getData();
		//echo "<pre>"; print_r($data);die;
		$data["hospitalID"] = $hospitalID; //FROM SESSION
		$data["hospitalUserID"] = $hospitalUserID; //FROM SESSION
		
		$updateData = $this->Dashboard->saveadditionaldetails($data);
		
		echo json_encode($updateData);
	}
	
}










