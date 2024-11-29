<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Students extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel'); // Load the model
        

    }
    public function index()
    {
        $ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');
		$API = new Mikweb();
		$API->connect($ip, $user, $password);
		$hotspotuser = $API->comm("/ip/hotspot/user/print");

		$data = [
			'hotspotuser' => $hotspotuser
		];

        $data['students'] = $this->UserModel->get_data(); // Get student data from the model
        $this->load->view('template/main', $data);
        $this->load->view('students/student_tbl', $data);
    }
    public function send_activation_emails($id)
    {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_timeout' => 30,
            'smtp_port' => 465,
            'smtp_user' => 'falmarklumpoc2@gmail.com',
            'smtp_pass' => 'lgcu gdfg lulx gqmc',
            'charset' => 'utf-8',
            'mailtype' => 'html',
            'newline' => "\r\n",
        );
        $this->load->library('email', $config);
    
        $email = $this->UserModel->get_emails($id);
        $generatedpassword = $this->UserModel->generateRandomString(7);
    
        $this->email->from('falmarklumpoc2@gmail.com', 'Your Name');
        $this->email->to($email);
        $this->email->subject('Activation Email');
        $this->email->message('Dear user, Your account has been activated. Your Username is : '.$email.' ... And your password is : '.$generatedpassword.' ... Thank you !!');
    
        try {
            if ($this->email->send()) {
                echo "Email sent to {$email} successfully<br>";

                $student_data = $this->UserModel->get_student_detail($id);
    
                $server = $student_data[0]->server;
                $userprofile = $student_data[0]->userprofile; 
    
                echo "Server: " . $server . "<br>";
                echo "User Profile: " . $userprofile . "<br>";
    
                // Mikrotik API integration
                $ip = $this->session->userdata('ip');
                $user = $this->session->userdata('user');
                $password = $this->session->userdata('password');
    
                $API = new Mikweb();
    
                // Debugging Mikrotik Connection
                try {
                    $API->connect($ip, $user, $password);
                    var_dump("Connected to Mikrotik");
                } catch (Exception $e) {
                    echo "Mikrotik API Connection Exception: " . $e->getMessage();
                    return; // Stop execution if connection fails
                }
    
                // Debugging Mikrotik API Command
                $emailAddress = $this->session->userdata('email'); // Assuming you have an email address saved in session
                echo "Server Name: " . $student_data[0]->server . "<br>";
                $fixedUsername = $email;

                try {
                    $response = $API->comm(
                        "/ip/hotspot/user/add",
                        array(
                            'name' => $fixedUsername,
                            'server' => "hotspot1", // Corrected server name
                            'password' => $generatedpassword,
                            'profile' => $student_data[0]->userprofile,
                            'comment' => "Account created via activation email",
                        )
                    );
                    redirect('students');
                    //  var_dump("Mikrotik API command sent", $response);
                } catch (Exception $e) {
                    echo "Mikrotik API Exception: " . $e->getMessage();
                }       
                
            } else {
                echo "Failed to send email to {$email}<br>";
                echo $this->email->print_debugger();
            }
        } catch (Exception $e) {
            echo "Email Exception: " . $e->getMessage();
        }
    }

    public function send_deactivation_emails($email)
    {
        $this->delUserEmail($email);
        redirect('students');
    }
    public function delete_student($id, $email)
    {
        $this->load->model('UserModel'); // Load the model

        // Call the delete_data function from your model
        $this->UserModel->delete_data($id);
        $this->delUserEmail($email);

        //echo "awawaw: ".$email;

        // Redirect to a page after deletion (you can change this URL)
        redirect('students');
    }

    public function delUserEmail($email)
	{
		$ip = $this->session->userdata('ip');
        $user = $this->session->userdata('user');
        $password = $this->session->userdata('password');
        $API = new Mikweb();
        $API->connect($ip, $user, $password);

        // Find the user's ID based on the username
        $users = $API->comm("/ip/hotspot/user/print", array("?name" => $email));
        
        if (!empty($users)) {
            $user_id = $users[0]['.id']; // Assuming the ID is stored in '.id'
            
            // Remove the user using the ID
            $API->comm("/ip/hotspot/user/remove", array(".id" => $user_id));

            // Optionally, you can delete the user from the database if needed
            // $this->load->model('UserModal');
            // $deleteResult = $this->UserModal->deleteUser($user_id);

            // Redirect to the users page
        } else {
            // Handle case where user with the specified username is not found
            echo "User with username '$email' not found.";
        }
	}
}