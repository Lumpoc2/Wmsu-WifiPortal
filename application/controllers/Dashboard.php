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
		$interface = $API->comm("/interface/print");
		$resource = json_encode($resource);
		$resource = json_decode($resource, true);
		$data = [
			'hotspotuser' => count($hotspotuser),
			'hotspotactive' => count($hotspotactive),
			'cpu' => $resource['0']['cpu-load'],
			'uptime' => $resource['0']['uptime'],
			'interface' => $interface,
		];
		$this->load->view('template/main');
		$this->load->view('dashboard', $data);
	}
	public function traffic(){
		$post = $this->input->post(null, true);
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$getinterfacetraffic = $API->comm("/interface/monitor-traffic",array(
			'interface' => 'wlan1',
			'once'=>'',
		));

		$rx=$getinterfacetraffic[0]['rx-bits-per-second'];
		$tx=$getinterfacetraffic[0]['tx-bits-per-second'];
		// echo 'rx =' .$rx.'<br>';
		// echo 'tx =' .$tx.'<br>';
		// var_dump($getinterfacetraffic);
		// die;
		$data =[
			'tx' =>$tx,
			'rx' =>$rx,
		];
		$this->load->view('traffic',$data);
	}
}
