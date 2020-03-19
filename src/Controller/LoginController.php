<?php
namespace App\Controller;

use Cake\Event\Event;
use Cake\View\Helper\FormHelper;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\Folder;
use Cake\Mailer\Email;
use Cake\Routing\Router;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class LoginController extends AppController
{
	public function initialize()
    {
        parent::initialize();
	}
	
	public function index()
	{
	}
	
	public function checklogin()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		
		$data = $this->request->getData();
		//$data["sub_domain"] = $_SERVER["SERVER_NAME"];
		
		$checklogin = $this->Login->checklogin($data);
		
		if(!empty($checklogin))
		{
			if(isset($data["remember_me"]))
			{
				setcookie("email",$data["email"],time()+31556926 ,'/');
				setcookie("remember_me",1,time()+31556926 ,'/');
			}
			else
			{
				setcookie("email", null, -31556926, '/');
				setcookie("remember_me", null, -31556926, '/');
			}
			
			$this->request->getSession()->write("hospital_id", $checklogin["hospital"]["hospital_id"]);
			$this->request->getSession()->write("hospital_name", $checklogin["hospital"]["hospital_name"]);
			$this->request->getSession()->write("hospital_logo_url", $checklogin["hospital"]["logo_url"]);
			$this->request->getSession()->write("sub_domain", $checklogin["hospital"]["sub_domain"]);
			$this->request->getSession()->write("hospital_user_id", $checklogin["hospital_user_id"]);
			$this->request->getSession()->write("email", $checklogin["email"]);
			$this->request->getSession()->write("role_id", $checklogin["role_id"]);
			$this->request->getSession()->write("fname", $checklogin["fname"]);
			
			$details = array();
			$details["role_id"] = $checklogin["role_id"];
			$details["is_active"] = !empty($checklogin["is_active"]) ? 1 : 0;
			$details["is_password_changed"] = !empty($checklogin["is_password_changed"]) ? 1 : 0;
			echo json_encode($details);
		}
		else
		{
			echo 0;
		}
	}
	
	public function logout()
	{
		$this->request->getSession()->destroy();
		$this->redirect(array('controller'=>'Login','action'=>'index'));
	}
	
	public function forgotpassword()
	{
	}
	
	public function resetpassword()
	{
	}
	
	public function checkcognitouser()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		
		$getEmail = $this->Login->checkcognitouser($this->request->getData("email"));
		if(!empty($getEmail["email"]))
		{
			$this->request->getSession()->write("email", $getEmail["email"]);
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
	
	public function updatepasswordfield()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		
		$getEmail = $this->Login->updatepasswordfield($this->request->getData("email"),$this->request->getData("password"));
	}
}










