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

class UsersController extends AppController
{
	public function initialize()
    {
        parent::initialize();
		
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		if(!$hospitalID)
		{
			$this->redirect(['controller'=>'Login','action'=>'index']);
		}
	}
	
	public function index()
	{
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		
		//GET ALL USERS
		$allUsers = $this->Users->allUsers($hospitalID);
		//echo "<pre>"; print_r($allUsers);die;
		//GET ALL USERS
		
		$this->set(compact("allUsers"));
	}
	
	public function register()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		$hospitalUserID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_user_id") : "";
		
		//SAVE USER
		$data = $this->request->getData();
		$data["hospitalID"] = $hospitalID; //FROM SESSION
		$data["hospitalUserID"] = $hospitalUserID; //FROM SESSION
		$saveUser = $this->Users->saveUser($data);
		//SAVE USER
		
		//SHOW ALL USER
		$allUsers = $this->Users->allUsers($hospitalID);
		//SHOW ALL USER
		
		$this->set(compact("allUsers"));
		
		$this->render('/Element/Users/allusers');
	}
	
	public function getUserDetails()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		
		$hospitalUserID = $this->request->getData("id");
		
		//GET USER DETAILS
		$userDetails = $this->Users->userDetails($hospitalUserID);
		//GET USER DETAILS
		
		//GET ALL ROLES
		$rolesData = $this->Users->allRoles();
		//GET ALL ROLES
		
		//GET ALL LOCATIONS
		$locationsData = $this->Users->allLocations($hospitalID);
		//GET ALL LOCATIONS
		
		$this->set(compact("userDetails","rolesData","locationsData"));
		
		$this->render('/Element/Users/adduser');
	}
	
	public function checkemail()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		
		$checkemail = $this->Users->checkemail($hospitalID,$this->request->getData("emailValue"));
		if(!empty($checkemail))
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
	
	public function deleteUser()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		$hospitalUserID = $this->request->getData("id");
		
		$deleteUser = $this->Users->deleteUser($hospitalID,$hospitalUserID);
	}
	
	public function adduserHtml()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		
		//GET ALL ROLES
		$rolesData = $this->Users->allRoles();
		//GET ALL ROLES
		
		//GET ALL LOCATIONS
		$locationsData = $this->Users->allLocations($hospitalID);
		//GET ALL LOCATIONS
		
		$this->set(compact("rolesData","locationsData"));
		
		$this->render('/Element/Users/adduser');
	}
	
}










