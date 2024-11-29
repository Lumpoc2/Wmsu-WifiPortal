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

	public function userlog()
	{

		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$hotspotuser = $API->comm("/ip/hotspot/user/print");
		$hotspotactive = $API->comm("/ip/hotspot/active/print");
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
		$this->load->view('hotspot/userlog', $data);
		//$this->load->view('template/footer');
	}

	public function history()
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
		$this->load->view('hotspot/history', $data);
		//$this->load->view('template/footer');
	}

	public function historylist($id, $mac_address)
	{
		$data = [
			'title' => 'View History',
			'active_id' => $id,
			'mac_address' => $mac_address,
		];
		$this->load->view('template/main', $data);
		$this->load->view('hotspot/historylist', $data);
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
		$API->comm(
			'/ip/hotspot/user/add',
			array(
				"name" => $post['user'],
				"password" => $post['password'],
				"server" => $post['server'],
				"profile" => $post['profile'],
				"limit-uptime" => $timelimit,
				
			)
		);
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
		$API->comm(
			"/ip/hotspot/user/remove",
			array(
				".id" => '*' . $id,
			)
		);

		// $this->load->model('UserModal');
		// $deleteResult = $this->UserModal->deleteUser($id);

		// echo $deleteResult;

		redirect('hotspot/users');
	}
	//edit user 
	public function editUser($id)
	{
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$getuser = $API->comm(
			"/ip/hotspot/user/print",
			array(
				"?.id" => '*' . $id,
			)
		);
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
	public function saveEditUser()
	{
		try{
			$post = $this->input->post(null, true);
			$ip = $this->session->userdata('ip');
			$user = $this->session->userdata('user');
			$password = $this->session->userdata('password');

			$API = new Mikweb();
			$API->connect($ip, $user, $password);

			if ($post['timelimit'] == "") {
				$timelimit = "0s";

			} else {
				$timelimit = $post['timelimit'];
			}
			$API->comm(
				"/ip/hotspot/user/set", array(
					".id" => $post['id'],
					"name" => $post['user'],
					"password" => $post['password'],
					"server" => $post['server'],
					"profile" => $post['profile'],
					"limit-uptime" => $timelimit,
					"comment" => $post['comment'],

				)
			);
			$this->load->view('template/main', $data);
			$this->load->view('hotspot/users', $data);
		}catch(Exception $e){
			echo "<script>alert('".$e->getMessage()."');</script>";
		}
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
		$API->comm(
			"/ip/hotspot/active/remove",
			array(
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
	public function addUserProfile()
	{
		try{
			$post = $this->input->post(null, true);
			$ip = $this->session->userdata('ip');
			$user = $this->session->userdata('user');
			$password = $this->session->userdata('password');

			$API = new Mikweb();
			$API->connect($ip, $user, $password);

			$patternRateLimit = '/^\d+[md]*\/\d+[md]*$/i'; // Matches: 1m/2m, 10d/20d, etc.
			$patternSessionTimeout = '/^\d+d\s\d{2}:\d{2}:\d{2}$/'; // Matches: 1d 09:02:00, 10d 12:34:56, etc.

			// All inputs are in the correct format, proceed with the API call
			$API->comm("/ip/hotspot/user/profile/add", array(
				"name" => $post['user'],
				"rate-limit" => $post['rate_limit'],
				"shared-users" => $post['shared_user'],
				"session-timeout" => $post['session_limit']
			)
			);

			$response = [
				'success' => true,
				'message' => 'User Profile added successfully.',
				
			];

			header('Content-Type: application/json');
			echo json_encode($response);
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}

	public function update_userlog()
	{
		date_default_timezone_set('Asia/Manila');
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$hotspotactive = $API->comm("/ip/hotspot/active/print");


		// Specify the SQLite database file path
		$dbFilePath = '/etc/pihole/pihole-FTL.db';

		try {
			// Create a new PDO instance to connect to the database
			$pdo = new PDO('sqlite:' . $dbFilePath);

			// Set the PDO error mode to exception
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Prepare and execute a SELECT query
			$query = "SELECT * FROM queries WHERE client LIKE '10.10.10.%' ORDER BY `timestamp` DESC LIMIT 10";
			$statement = $pdo->prepare($query);
			$statement->execute();

			// Fetch all rows as associative arrays
			$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

			for ($i = count($rows) - 1; $i >= 0; $i--) {
				$row = $rows[$i];
				$datetime = date("Y-m-d H:i:s", $row['timestamp']);
				$captured_mac_address = '------';

				foreach ($hotspotactive as $data) {
					if($data['address'] == $row['client']){
						$captured_mac_address = $data['mac-address'];
						break;
					}else{
						$captured_mac_address = "Unknown MAC Address";
					}
				}

				$this->load->model('UserModel');
				if($this->UserModel->insert_log_data($row['id'], $row['domain'], $row['client'], $captured_mac_address, $row['timestamp'])){
					echo "DateTime: {$datetime} ; ID: {$row['id']} ; Domain: {$row['domain']} ; IP Address: {$row['client']} ; Captured MAC - Address: {$captured_mac_address}\n";
				}
			}
		} catch (PDOException $e) {
			// Handle database connection or query errors
			echo "Error: " . $e->getMessage();
		} finally {
			// Close the database connection
			$pdo = null;
		}
	}

	public function update_userlog_realtime()
	{
		date_default_timezone_set('Asia/Manila');
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$hotspotactive = $API->comm("/ip/hotspot/active/print");


		// Specify the SQLite database file path
		$dbFilePath = '/etc/pihole/pihole-FTL.db';

		try {
			// Create a new PDO instance to connect to the database
			$pdo = new PDO('sqlite:' . $dbFilePath);

			// Set the PDO error mode to exception
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Prepare and execute a SELECT query
			$query = "SELECT * FROM queries WHERE client LIKE '10.10.10.%' ORDER BY `timestamp` DESC LIMIT 10";
			$statement = $pdo->prepare($query);
			$statement->execute();

			// Fetch all rows as associative arrays
			$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

			for ($i = count($rows) - 1; $i >= 0; $i--) {
				$row = $rows[$i];
				$datetime = date("Y-m-d H:i:s", $row['timestamp']);
				$captured_mac_address = '------';

				foreach ($hotspotactive as $data) {
					if($data['address'] == $row['client']){
						$captured_mac_address = $data['mac-address'];
						break;
					}else{
						$captured_mac_address = "Unknown MAC Address";
					}
				}

				$this->load->model('UserModel');
				if($this->UserModel->insert_log_data($row['id'], $row['domain'], $row['client'], $captured_mac_address, $row['timestamp'])){
					//echo "DateTime: {$datetime} ; ID: {$row['id']} ; Domain: {$row['domain']} ; IP Address: {$row['client']} ; Captured MAC - Address: {$captured_mac_address}\n";
				}
			}
		} catch (PDOException $e) {
			// Handle database connection or query errors
			echo "Error: " . $e->getMessage();
		} finally {
			// Close the database connection
			$pdo = null;
		}
	}

	public function delProfile($id)
	{
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$API->comm(
			"/ip/hotspot/user/profile/remove",
			array(
				".id" => '*' . $id,
			)
		);
		redirect('hotspot/profile');
	}
	public function editUserProfile($id)
	{
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$getProfile = $API->comm(
			"/ip/hotspot/user/profile/print",
			array(
				"?.id" => '*' . $id
			)
		);
		 //var_dump($getProfile);
		// dim;



		$data = [
			'title' => 'Edit User Profile',
			'profile' => $getProfile[0],
		];
		$this->load->view('template/main', $data);
		$this->load->view('hotspot/edit-userprofile', $data);
	}
	public function saveEditUserProfile()
	{
		try{
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
					"session-timeout" => $post['session-timeout']
				)
			);
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}


}
ini_set("display_errors", 'off');