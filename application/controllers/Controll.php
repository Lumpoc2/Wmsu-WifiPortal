<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controll extends CI_Controller {

	

    

    public function block(){
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		
		$tlshost = $API->comm("/ip/firewall/tls-host/print");
		$firewall = $API->comm("/ip/firewall/filter/print");
		$dhcp = $API->comm("/ip/dhcp-server/network/print");
		$addressLists = $API->comm("/ip/firewall/address-list/print");
		//echo '<pre>';
		//var_dump($addressLists);
		//echo '<pre>';
		$data = [
			'title' => 'blocking',
			'totaltlshost'=> count($tlshost),
			'tlshost' => $tlshost,
			'dhcp'=> $dhcp,
			'firewall' => $firewall,
			'totaldhcp'=> count($dhcp),
			'addressLists' => $addressLists,
			
		];
		
		

		$this->load->view('template/main', $data);
		$this->load->view('controll/block', $data);
	}
	public function deleteDomainList($id){
		$post = $this->input->post(null, true);
		
		$this->load->view('template/main', $data);
		$this->load->view('controll/block', $data);
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
	public function addBlockSite(){
		
		
		$dbFilePath = '/etc/pihole/gravity.db';

		try {
		// Create a new PDO instance to connect to the database
		$pdo = new PDO('sqlite:' . $dbFilePath);

		// Set the PDO error mode to exception
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// Prepare and execute a SELECT query
		$query = "INSERT OR IGNORE INTO domainlist (`domain`,`type`,`enabled`,`comment`) VALUES ('roblox', '3', '1', 'roblox')";
		$statement = $pdo->prepare($query);
		if($statement->execute()){
			echo "<script> alert('Added Successfully.') </script>";
		}else{
			echo "<script> alert('domainList SQL Error!') </script>";
		}
		} catch (PDOException $e) {
		// Handle database connection or query errors
		echo "Error: " . $e->getMessage();
		} finally {
		// Close the database connection
		$pdo = null;
		}


		/*
		system("pihole -b example.ph", $result);
		//system("ls -l", $result);

		echo "--------------------------------------------> ".$result;
		*/

		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$tlshost = $API->comm("/ip/firewall/tls-host/print");
		$firewall = $API->comm("/ip/firewall/filter/print");
		$dhcp = $API->comm("/ip/dhcp-server/network/print");

		$data = [
			'title' => 'blocking',
			'totaltlshost'=> count($tlshost),
			'tlshost' => $tlshost,
			'dhcp'=> $dhcp,
			'firewall' => $firewall,
			'totaldhcp'=> count($dhcp),
		];

		$this->load->view('template/main', $data);
		$this->load->view('controll/block', $data);
	}
	public function delLayer7($id){
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$API->comm("/ip/firewall/tls-host/remove", array(
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
		$getlayer = $API->comm("/ip/firewall/tls-host/print",array(
			"?.id" => '*' .  $id,
		));
		$data = [
			'title' => 'edit layer',
			'layer' => $getlayer[0],
		];
		$this->load->view('template/main', $data);
		$this->load->view('controll/edit-layer', $data);
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
		
		$firewall = $API->comm("/ip/firewall/filter/print");
		$dhcp = $API->comm("/ip/dhcp-server/network/print");
		
		$data = [
			'title' => 'edit Filter',
			'filter' => $getfilter[0],
			'firewall' => $firewall,
			'dhcp' => $dhcp,
		];
		
		$this->load->view('template/main', $data);
		$this->load->view('controll/edit-filter', $data);
	}

	public function saveEditFilter() {
    $post = $this->input->post(null, true);
    $ip = $this->session->userdata('ip');
    $user = $this->session->userdata('user');
    $password = $this->session->userdata('password');

    $API = new Mikweb();

    try {
        $API->connect($ip, $user, $password);
		
        // Test with a simplified command structure first
        $response = $API->comm("/ip/firewall/filter/set", [
            ".id" => $post['id'],
            "action" => $post['action'],
			"chain" => $post['chain'],
			"dst-address-list" => $post['dst-address-list'],
        ]);
		
        // Check for errors
        if (isset($response['!trap'])) {
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
	
	public function addLayer7(){
		$post = $this->input->post(null, true);
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');

		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$API->comm("/ip/firewall/filter/add", array(
			"action" => $post['action'],
			"chain" => $post['chain'],
			"dst-address-list" => $post['dst-address-list'],

		));
		redirect('controll/block'); 
	}
	

	public function addControll() {
    // Get POST data (form submission)
    $post = $this->input->post(null, true);
    $ip = $this->session->userdata('ip');
    $user = $this->session->userdata('user');
    $password = $this->session->userdata('password');

    // Instantiate the Mikweb API object
    $API = new Mikweb();
    
    // Attempt to connect to MikroTik router
    $connected = $API->connect($ip, $user, $password);

    if ($connected) {
        // List of valid protocols for MikroTik
        $validProtocols = ['tcp', 'udp', 'icmp', 'ip', 'gre'];

        // Validate the 'protocol' input from the POST data
        $protocol = isset($post['protocol']) ? strtolower($post['protocol']) : null;
        
        // Check if the provided protocol is valid, if not, set a default protocol (e.g., tcp)
        if (!in_array($protocol, $validProtocols)) {
            // If protocol is invalid, set a default (tcp)
            $protocol = 'tcp';
            echo "Invalid protocol specified. Defaulting to 'tcp'.<br>";
        }

        // Prepare the data for the firewall rule
        $data = array(
            "action" => isset($post['action']) ? $post['action'] : 'drop', // Default to 'drop' action if not specified
            "chain" => isset($post['chain']) ? $post['chain'] : 'input', // Default to 'input' chain if not specified
            "src-address" => isset($post['src-address']) ? $post['src-address'] : '', // Handle missing src-address
            "tls-host" => isset($post['tls-host']) ? $post['tls-host'] : '', // Handle missing tls-host
            "protocol" => $protocol,
            "dst-port" => isset($post['dst-port']) ? $post['dst-port'] : '', // Handle missing dst-port
            "address-list" => isset($post['address-list']) ? $post['address-list'] : '', // Handle missing address-list
            "address-list-timeout" => isset($post['address-list-timeout']) ? $post['address-list-timeout'] : '00:00:00', // Default timeout
        );

        // Send the command to MikroTik to add a firewall rule
       $response = $API->comm("/ip/firewall/filter/add", $data);

        // Debugging: Check the response from MikroTik
       // echo "<pre>";
       // print_r($response); // This will print the response from MikroTik
       // echo "</pre>";

        // Optionally handle the response (for example, check if the command was successful)
       if ($response) {
          redirect('controll/block'); 
       } else {
           echo "Failed to add firewall rule.<br>";
       }

        // Disconnect from MikroTik
        //$API->disconnect();
 //   } else {
        //echo "Failed to connect to MikroTik.<br>";
   // }
	}
}
public function enableFirewallRule($id) {
    $ip = $this->session->userdata('ip');
    $user = $this->session->userdata('user');
    $password = $this->session->userdata('password');
    $API = new Mikweb();

    log_message('debug', 'EnableFirewallRule called with ID: ' . $id);

    try {
        // Connect to MikroTik
        if (!$API->connect($ip, $user, $password)) {
            log_message('error', 'Unable to connect to MikroTik router at IP: ' . $ip);
            show_error('Unable to connect to MikroTik router.');
        }

        log_message('debug', 'Connected to MikroTik router at IP: ' . $ip);

        // Log the ID to verify it's correct
        log_message('debug', 'ID passed for enabling rule: ' . $id);

        // Check if rule exists in the firewall filter table
        $check_rule = $API->comm("/ip/firewall/filter/print", [
            "? .id" => $id,
        ]);

        if (empty($check_rule)) {
            log_message('error', 'No rule found with ID: ' . $id);
            show_error('No rule found with ID: ' . $id);
        }

        // Enable the rule by its ID
        $response = $API->comm("/ip/firewall/filter/enable", [
            ".id" => $id,  // ID of the rule to enable
        ]);

        // Log the full response for debugging
        log_message('debug', 'API Response for enabling rule: ' . print_r($response, true));

        // Check for API errors
        if (isset($response['!trap'])) {
            log_message('error', 'MikroTik API error while enabling rule: ' . print_r($response, true));
            show_error('Error enabling rule: ' . $response['!trap'][0]['message']);
        } elseif (isset($response['!error'])) {
            log_message('error', 'MikroTik API error while enabling rule: ' . print_r($response, true));
            show_error('Error enabling rule: ' . $response['!error']);
        } else {
            log_message('debug', 'Firewall rule enabled successfully: ' . print_r($response, true));
        }

        // Disconnect and redirect
        $API->disconnect();
        log_message('debug', 'Disconnected from MikroTik router.');

        redirect('controll/block');  // Redirect after enabling the rule
    } catch (Exception $e) {
        log_message('error', 'Exception occurred: ' . $e->getMessage());
        show_error('Error enabling rule: ' . $e->getMessage());
    }
}



public function disableFirewallRule($id) {
    $ip = $this->session->userdata('ip');
    $user = $this->session->userdata('user');
    $password = $this->session->userdata('password');
    $API = new Mikweb();

    try {
        // Connect to MikroTik
        if (!$API->connect($ip, $user, $password)) {
            show_error('Unable to connect to MikroTik router.');
        }

        // Check the rule exists first
        $check_rule = $API->comm("/ip/firewall/filter/print", [
            "? .id" => $id,
        ]);

        if (empty($check_rule)) {
            show_error('No rule found with ID: ' . $id);
        }

        // Disable the rule
        $response = $API->comm("/ip/firewall/filter/set", [
            ".id" => $id,
            "disabled" => "true", // Disable the rule
        ]);

        if (isset($response['!trap'])) {
            show_error('Error disabling rule: ' . $response['!trap'][0]['message']);
        }

        // Disconnect from MikroTik
        $API->disconnect();

        redirect('controll/block');
    } catch (Exception $e) {
        show_error('Error disabling rule: ' . $e->getMessage());
    }
}
public function BlockSite(){

		//Get the PiHoleAPI file 
		require_once(APPPATH . 'libraries/PiHoleAPI.php');

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve the user input
    $domain = filter_var($_POST['url'], FILTER_SANITIZE_URL);

    if (filter_var($domain, FILTER_VALIDATE_URL)) {
        // Extract the domain name from the URL
        $parsedUrl = parse_url($domain);
        $host = $parsedUrl['host'] ?? $parsedUrl['path'];

        // Instantiate the PiHoleAPI class
        $piHole = new PiHoleAPI('10.10.10.6', 'e95d070407e39d43d738badabe42893dce0726e7a2930cef760eaa36b6027a52');

        // Add the domain to the blocklist
        $result = $piHole->addToBlocklist($host);

        if ($result['success']) {
			redirect('controll/block'); 
		} else {
            echo "Failed to add the domain to the blocklist.";
	
        }
    } else {
       redirect('controll/block'); 
    }
} else {
    echo "Invalid request method.";
}

	}	

}








			