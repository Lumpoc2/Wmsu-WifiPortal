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
            'smtp_pass' => 'mark_123',
            'charset' => 'utf-8',
            'mailtype' => 'html',
            'newline' => "\r\n",
            // Corrected newline configuration
        );
        $this->load->library('email', $config);

        $email = $this->UserModel->get_emails($id);

        $this->email->from('falmarklumpoc2@gmail.com', 'Your Name');
        $this->email->to($email);
        $this->email->subject('Activation Email');
        $this->email->message('Dear user, Your account has been activated.');

        if ($this->email->send()) {
            echo "Email sent to {$email} successfully<br>";
        } else {
            echo "Failed to send email to {$email}<br>";
            echo $this->email->print_debugger();
        }
    }
    public function delete_student($id) {
        $this->load->model('UserModel'); // Load the model
    
        // Call the delete_data function from your model
        $this->UserModel->delete_data($id);
    
        // Redirect to a page after deletion (you can change this URL)
        redirect('students');
    }
}