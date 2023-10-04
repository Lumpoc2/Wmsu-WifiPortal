<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hotspot extends CI_Controller
{
	//view all controllers from the mikrotik 
	public function users()
	{

		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$hotspotuser = $API->comm("/ip/hotspot/user/print");
		$server = $API->comm("/ip/hotspot/print");
		$profile = $API->comm("/ip/hotspot/user/profile/print");

		$data = [
			'title' => 'User Hotspot',
			'totalhotspotuser' => count($hotspotuser),
			'hotspotuser' => $hotspotuser,
			'server' => $server,
			'profile' => $profile,
		];
		$this->load->view('template/main', $data);
		$this->load->view('hotspot/users', $data);
		//$this->load->view('template/footer');
	}
	//this controll is intended in adding a user from the mikrtotik hotspot
	public function addUser()
	{
		
		$post = $this->input->post(null, true);
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');

		$API = new Mikweb();
		$API->connect($ip, $user, $password);

		if ($post['timelimit'] == "") {
			$timelimit = "0";

		} else {
			$timelimit = $post['timelimit'];
		}
		$API->comm("/ip/hotspot/user/add", array(
			"name" => $post['user'],
			"password" => $post['password'],
			"server" => $post['server'],
			"profile" => $post['profile'],
			"limit-uptime" => $timelimit,
			"comment" => $post['comment'],  
			
		));
		// $data = array(
		// 	'name' => $post['user'],
		// 	'password' => $post['password'],
		// 	'server' => $post['server'],
		// 	'profile' => $post['profile'],
		// 	'limit-uptime' => $timelimit,
		// 	'comment' => $post['comment']
		// );
		
	
		
		// $this->load->model('UserModal','emp');
		// $this->emp->insertUser($data);
		redirect('hotspot/users');   

	}

	//delete user hotspot	
	public function delUser($id)
	{
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$API->comm("/ip/hotspot/user/remove", array(
			".id" => '*' . $id,
		));
		
		// $this->load->model('UserModal');
    	// $deleteResult = $this->UserModal->deleteUser($id);

		// echo $deleteResult;

		redirect('hotspot/users');
	}
	//edit user 
	public function editUser($id){
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$getuser = $API->comm("/ip/hotspot/user/print",array(
			"?.id" => '*' .  $id,
		));
		// var_dump($getuser);
		// dim;
		$server = $API->comm("/ip/hotspot/print");
		$profile = $API->comm("/ip/hotspot/user/profile/print");

		$data = [
			'title' => 'Edit User',
			'user' => $getuser[0],
			'server' => $server,
			'profile' => $profile,
		];
		$this->load->view('template/main', $data);
		$this->load->view('hotspot/edit-user', $data);
	}
	public function saveEditUser(){
		$post = $this->input->post(null, true);
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');

		$API = new Mikweb();
		$API->connect($ip, $user, $password);

		if ($post['timelimit'] == "") {
			$timelimit = "0";

		} else {
			$timelimit = $post['timelimit'];
		}
		$API->comm("/ip/hotspot/user/set", array(
			".id" => $post['id'],
			"name" => $post['user'],
			"password" => $post['password'],
			"server" => $post['server'],
			"profile" => $post['profile'],
			"limit-uptime" => $timelimit,
			"comment" => $post['comment'],

		)
		);
		redirect('hotspot/users');
	}
	public function active()
	{

		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$hotspotactive = $API->comm("/ip/hotspot/active/print");


		$data = [
			'title' => 'Active Hotspot',
			'totalhotspotactive' => count($hotspotactive),
			'hotspotactive' => $hotspotactive,
		];
		$this->load->view('template/main', $data);
		$this->load->view('hotspot/active', $data);
	}
	public function delActive($id)
	{
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$API->comm("/ip/hotspot/active/remove", array(
			".id" => '*' . $id,
		)
		);
		redirect('hotspot/active');
	}
	public function profile()
	{

		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$hotspotprofile = $API->comm("/ip/hotspot/user/profile/print");


		$data = [
			'title' => 'user profile',
			'totalhotspotprofile' => count($hotspotprofile),
			'hotspotprofile' => $hotspotprofile,


		];
		$this->load->view('template/main', $data);
		$this->load->view('hotspot/profile', $data);
	}
	public function addUserProfile (){
		$post = $this->input->post(null, true);
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');

		$API = new Mikweb();
		$API->connect($ip, $user, $password);

		
		$API->comm("/ip/hotspot/user/profile/add", array(
			"name" => $post['user'],
			"rate-limit" => $post['rate_limit'],
			"shared-users" => $post['shared_user'],
			"session-timeout" => $post['session_limit']

		)
		);
		redirect('hotspot/profile');
	}
	public function delProfile($id){
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$API->comm("/ip/hotspot/user/profile/remove", array(
			".id" => '*' . $id,
		)
		);
		redirect('hotspot/profile');
	}
	public function editUserProfile($id){
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$getProfile = $API->comm("/ip/hotspot/user/profile/print",array(
			"?.id" => '*' .  $id,
		));
		// var_dump($getuser);
		// dim;
		
		

		$data = [
			'title' => 'Edit User',
			'profile' => $getProfile[0],	
		];
		$this->load->view('template/main', $data);
		$this->load->view('hotspot/edit-userprofile', $data);
	}
	public function saveEditUserProfile(){
		$post = $this->input->post(null, true);
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');

		$API = new Mikweb();
		$API->connect($ip, $user, $password);

	
		$API->comm("/ip/hotspot/user/profile/set", array(
			".id" => $post['id'],
			"name" => $post['name'],
			"shared-users" => $post['shared-users'],
			"rate-limit" => $post['rate-limit'],
			"session-timeout" => $post['session-timeout'],
			"comment" => $post['comment'],
		)
		);
		redirect('hotspot/users');
	}
	
	
}
ini_set("display_errors", 'off');

