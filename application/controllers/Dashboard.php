<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function index()
	{
		$ip = $this->session->userdata('ip');
        $user = $this->session->userdata('user');
       	$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$hotspotuser = $API->comm("/ip/hotspot/user/print");
		$hotspotactive = $API->comm("/ip/hotspot/active/print");
		$resource = $API->comm("/system/resource/print");
		$resource = json_encode($resource);
		$resource = json_decode($resource, true);
		$data = [
			'hotspotuser' => count($hotspotuser),
			'hotspotactive' => count($hotspotactive),
			'cpu' => $resource['0']['cpu-load'],
			'uptime' => $resource['0']['uptime'],
		];
		$this->load->view('template/main');
		$this->load->view('dashboard', $data);
	}
}
