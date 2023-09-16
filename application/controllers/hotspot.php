<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hotspot extends CI_Controller
{
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

		)
		);
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
			'title' => 'User Hotspot',
			'totalhotspotactive' => count($hotspotactive),
			'hotspotactive' => $hotspotactive,


		];
		$this->load->view('template/main', $data);
		$this->load->view('hotspot/active', $data);
	}
}
ini_set("display_errors", 'off');