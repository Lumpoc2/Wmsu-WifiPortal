<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controll extends CI_Controller {
    public function block(){
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$layerProtocol = $API->comm("/ip/firewall/layer7-protocol/print");
		$firewall = $API->comm("/ip/firewall/filter/print");
		$dhcp = $API->comm("/ip/dhcp-server/network/print");
		$data = [
			'title' => 'blocking',
			'totallayerProtocol'=> count($layerProtocol),
			'layerProtocol' => $layerProtocol,
			'dhcp'=> $dhcp,
			'firewall' => $firewall,
			'totaldhcp'=> count($dhcp),
		];
		$this->load->view('template/main', $data);
		$this->load->view('controll/block', $data);
	}
	public function addControll(){
		$post = $this->input->post(null, true);
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');

		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$API->comm("/ip/firewall/filter/add", array(
			"chain" => $post['chain'],
			"src-address" => $post['src-address'],
			"layer7-protocol" => $post['layer7-protocol'],
			"action" => $post['action'],
		));
		redirect('controll/block'); 
	}
	public function delFilter($id){
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$API->comm("/ip/firewall/filter/remove", array(
			".id" => '*' . $id,
		)
		);
		redirect('controll/block'); 
	}
	public function addLayer7(){
		$post = $this->input->post(null, true);
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');

		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$API->comm("/ip/firewall/layer7-protocol/add", array(
			"name" => $post['name'],
			"regexp" => $post['regexp'],
		));
		redirect('controll/block'); 
	}
	public function delLayer7($id){
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$API->comm("/ip/firewall/layer7-protocol/remove", array(
			".id" => '*' . $id,
		)
		);
		redirect('controll/block'); 
	}
	public function editLayer($id){
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$getlayer = $API->comm("/ip/firewall/layer7-protocol/print",array(
			"?.id" => '*' .  $id,
		));
	
		
		$data = [
			'title' => 'edit layer',
			'layer' => $getlayer[0],
		];
		$this->load->view('template/main', $data);
		$this->load->view('controll/edit-layer', $data);
	}
	public function saveEditLayer(){
		$post = $this->input->post(null, true);
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');

		$API = new Mikweb();
		$API->connect($ip, $user, $password);

		
		$API->comm("/ip/firewall/layer7-protocol/set", array(
			".id" => $post['id'],
			"name" => $post['name'],
			"regexp" => $post['regexp'],
			

		)
		);
		redirect('controll/block'); 
	}
	public function editFilter($id){
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$getfilter = $API->comm("/ip/firewall/filter/print",array(
			"?.id" => '*' .  $id,
		));
		$layerProtocol = $API->comm("/ip/firewall/layer7-protocol/print");
		$dhcp = $API->comm("/ip/dhcp-server/network/print");
		$data = [
			'title' => 'edit Filter',
			'filter' => $getfilter[0],
			'layerProtocol' => $layerProtocol,
			'dhcp' => $dhcp,
		];
		$this->load->view('template/main', $data);
		$this->load->view('controll/edit-filter', $data);
	}
	public function saveEditFilter(){
	$post = $this->input->post(null, true);
    $ip = $this->session->userdata('ip');
    $user = $this->session->userdata('user');
    $password = $this->session->userdata('password');

    $API = new Mikweb();

    try {
        $API->connect($ip, $user, $password);

        $response = $API->comm("/ip/firewall/filter/set", array(
			".id" => $post['id'],
    		"action" => $post['action'],
            "chain" => $post['chain'],
            "src-address" => $post['src-address'],
            "layer7-protocol" => $post['layer7-protocol'],
        ));

        // Check if there are any errors in the response
        if(isset($response['!trap'])) {
            throw new Exception($response['!trap'][0]['message']);
        }

        redirect('controll/block');
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
	}
	public function editDhcp($id){
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$getdhcp = $API->comm("/ip/dhcp-server/network/print",array(
			"?.id" => '*' .  $id,
		));
		
		$data = [
			'title' => 'edit DNS Server',
			'DhcpNet' => $getdhcp[0],
		];
		$this->load->view('template/main', $data);
		$this->load->view('controll/edit-dhcp', $data);
	}
	public function saveEditDhcp(){
		$post = $this->input->post(null, true);
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
	
		$API = new Mikweb();
	
		try {
			$API->connect($ip, $user, $password);
	
			$response = $API->comm("/ip/dhcp-server/network/set", array(
				".id" => $post['id'],
				"dns-server" => $post['dns-server'],
				
			));
	
			// Check if there are any errors in the response
			if(isset($response['!trap'])) {
				throw new Exception($response['!trap'][0]['message']);
			}
	
			redirect('controll/block');
		} catch (Exception $e) {
			echo 'Error: ' . $e->getMessage();
		}
	}
	public function addDns(){
		$post = $this->input->post(null, true);
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');

		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$API->comm("/ip/dhcp-server/network/add", array(
			
			"dns-server" => $post['dns-server'],
		));
		redirect('controll/block'); 
	}
}
