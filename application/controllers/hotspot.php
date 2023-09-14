<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
		$hotspotuser = json_encode($hotspotuser);
		$hotspotuser = json_decode($hotspotuser, true);
		$data = [
			'title' => 'User Hotspot',
			'totalhotspotuser' => count($hotspotuser),
            'hotspotuser' => $hotspotuser
		];
		$this->load->view('template/main', $data);
		$this->load->view('hotspot/user', $data);
    }
}
ini_set('display_errors','off');