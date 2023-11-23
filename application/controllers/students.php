<?php
defined('BASEPATH') or exit('No direct script access allowed');

class students extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel'); // Load the model

    }
    public function index()
    {

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
    
        $this->email->from('falmarklumpoc2@gmail.com', 'Your Name');
        $this->email->to($email);
        $this->email->subject('Activation Email');
        $this->email->message('Dear user, Your account has been activated.');
    
        try {
            if ($this->email->send()) {
                echo "Email sent to {$email} successfully<br>";
    
                    $student_data = $this->UserModel->get_data($id);
        
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
                                "name" => $fixedUsername,
                                "server" => $student_data[0]->server, // Corrected server name
                                "password" => "pasdasd",
                                "profile" => $student_data[0]->userprofile,
                                "comment" => "Account created via activation email",
                            )
                        );
                        redirect('students');
                       // var_dump("Mikrotik API command sent", $response);
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
        



    public function delete_student($id)
    {
        $this->load->model('UserModel'); // Load the model

        // Call the delete_data function from your model
        $this->UserModel->delete_data($id);

        // Redirect to a page after deletion (you can change this URL)
        redirect('students');
    }
}