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

class ChatsController extends AppController
{
	public function initialize()
    {
        parent::initialize();
	}
	
	public function index()
	{
		//print_r($this->request->getSession()->read('hospital_user_id'));die;
	}

	function sendbirdCreateGroup()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		$data = $this->request->getData();
		$user_id = $this->request->getSession()->read('hospital_user_id');				
		$dataBody = [
			"name"=> "Manohar members",
			"channel_url"=> "public_chat_room_".$user_id."",
			//"cover_url": "https://sendbird.com/main/img/cover/cover_08.jpg",
			"custom_type"=> "sports",
			//"is_distinct"=> true,
			//"inviter_id"=> "Mac",
			"is_public"=> true,
			//"user_ids"=> ["Mac", "Nick", "John"],
			"invitation_status"=> [
				"Nick"=> "invited_by_friend",
				"John"=> "invited_by_non_friend"
				],
				"hidden_status"=> [
					"Mac"=> "hidden_allow_auto_unhide"
				],
				"operator_ids"=> ["Mac"]
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


		echo '<pre>';print_r($result);die;
    	//return $output;

    	

	}

	function addUserSendbird()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		$uid = mt_rand(1000,999999);
		$chars     = "abcdefghijkmnpqrstuvwxyzABCDEFGIHJKLMNPQRSTUVWXYZ123456789-";
        $nickname  = substr(str_shuffle($chars), 0, 9);
		$dataBody = ["user_id"=>$uid,
					"nickname" => $nickname,
					"profile_url" =>''
		];
		$dataBody = json_encode($dataBody);
		$data = $this->request->getData();
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
		$result = json_decode($response);
		echo '<pre>';print_r($result);die;


	}

	function inviteMembers(){
		//https://api-{application_id}.sendbird.com/v3/group_channels/{channel_url}/invite  
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		$uid = mt_rand(1000,999999);
		$chars     = "abcdefghijkmnpqrstuvwxyzABCDEFGIHJKLMNPQRSTUVWXYZ123456789-";
        $nickname  = substr(str_shuffle($chars), 0, 9);
		$dataBody = ["channel_url"=>$uid,
					"nickname" => $nickname,
					"profile_url" =>''
		];
		$dataBody = json_encode($dataBody);
		$data = $this->request->getData();
		$url = "https://api-CFABD9CE-7713-4228-B930-4C3858CB41A4.sendbird.com/v3/group_channels/public_chat_room_10/invite";
		$apiKey = 'f7d852febbd35afb9dcdf900d2abe084aee68a27'; 
		$headers = array(
		     'Api-Token: '.$apiKey
		);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $dataBody);
		//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		$response = curl_exec($ch);
		$result = json_decode($response);
		echo '<pre>';print_r($result);die;
	}
	

	function sendMessage()
	{
		//	POST https://api-{application_id}.sendbird.com/v3/{channel_type}/{channel_url}/messages
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		$data = $this->request->getData();
		//print_r($data);die;
		//$dataBody = ["channel_type"=>"group_channels","channel_url"=>"public_chat_room_10"]
		$dataBody = ["message_type"=>"MESG","user_id"=>"1234","message"=>$data['msg']];
		$dataBody = json_encode($dataBody);
		$url = "https://api-CFABD9CE-7713-4228-B930-4C3858CB41A4.sendbird.com/v3/group_channels/public_chat_room_10/messages";
		$apiKey = 'f7d852febbd35afb9dcdf900d2abe084aee68a27'; 
		$headers = array(
		     'Api-Token: '.$apiKey
		);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $dataBody);
		//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		$response = curl_exec($ch);
		//$result = json_decode($response);
		//echo '<pre>';print_r($result);die;
		echo $response;die;


	}

	function getMessage()
	{
		// GET https://api-{application_id}.sendbird.com/v3/{channel_type}/{channel_url}/messages
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		$data = $this->request->getData();
		$dataBody = ["channel_type"=>"group_channels","channel_url"=>"public_chat_room_10","message_ts"=>'',"message_id"=>$data['message_id']];
		$dataBody = json_encode($dataBody);
		$url = "https://api-CFABD9CE-7713-4228-B930-4C3858CB41A4.sendbird.com/v3/group_channels/public_chat_room_10/messages";
		$apiKey = 'f7d852febbd35afb9dcdf900d2abe084aee68a27'; 
		$headers = array(
		     'Api-Token: '.$apiKey
		);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $dataBody);
		//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		$response = curl_exec($ch);
		//$result = json_decode($response);
		//echo '<pre>';print_r($result);die;
		echo $response;die;


	}

	function userList()
	{
		//GET https://api-{application_id}.sendbird.com/v3/users
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);
		$data = $this->request->getData();
		//$dataBody = ["channel_type"=>"group_channels","channel_url"=>"public_chat_room_10","message_ts"=>'',"message_id"=>$data['message_id']];
		//$dataBody = json_encode($dataBody);
		$url = "https://api-CFABD9CE-7713-4228-B930-4C3858CB41A4.sendbird.com/v3/users";
		$apiKey = 'f7d852febbd35afb9dcdf900d2abe084aee68a27'; 
		$headers = array(
		     'Api-Token: '.$apiKey
		);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $dataBody);
		//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		$response = curl_exec($ch);
		//$result = json_decode($response);
		//echo '<pre>';print_r($result);die;
		echo $response;die;
	}

	function groupList()
	{
		//	GET https://api-{application_id}.sendbird.com/v3/group_channels
	}
}










