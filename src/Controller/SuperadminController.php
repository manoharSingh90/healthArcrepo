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

class SuperadminController extends AppController
{
	public function initialize()
    {
        /* parent::initialize();
		
		$hospitalID = $this->request->getSession()->read("hospital_id") ? $this->request->getSession()->read("hospital_id") : "";
		if(!$hospitalID)
		{
			$this->redirect(['controller'=>'Login','action'=>'index']);
		} */
	}
	
	public function index()
	{
	}
	
	public function createadmin()
	{
	}
	
	public function register()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		
		//SAVE ADMIN
		$data = $this->request->getData();
		//echo "<pre>"; print_r($data);die;
		
		$saveUser = $this->Superadmin->saveAdmin($data);
		//SAVE ADMIN
		
		$returnData["hospital_id"] = $saveUser["hospital_id"];
		$returnData["password"] = convert_uudecode(base64_decode($saveUser["password"]));
		echo json_encode($returnData); die;
	}
	
	public function checkemail()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		
		$checkemail = $this->Superadmin->checkemail($this->request->getData("emailValue"));
		if(!empty($checkemail))
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
}










