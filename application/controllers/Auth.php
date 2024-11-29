<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller 
{
	public function index()
	{
    $this->load->view('auth/login');
    
    }
    public function login()
    {   
       $ip = $this->input->post('ip');
$user = $this->input->post('user');
$password = $this->input->post('password');

// Check for null values before hashing to avoid deprecation warning
$h_ip = $ip !== null ? sha1($ip) : '';
$h_user = $user !== null ? sha1($user) : '';
$h_pass = $password !== null ? sha1($password) : '';

if ($h_ip == HASHED_IPADDRESS) {
    if ($h_user != HASHED_USERNAME && $h_pass != HASHED_PASSWORD) {
        echo "<script> alert('Login Failed: User and Password were Invalid!'); </script>";
        $this->load->view('auth/login');
    } elseif ($h_user != HASHED_USERNAME) {
        echo "<script> alert('Login Failed: User was Invalid!'); </script>";
        $this->load->view('auth/login');
    } elseif ($h_pass != HASHED_PASSWORD) {
        echo "<script> alert('Login Failed: Password was Invalid!'); </script>";
        $this->load->view('auth/login');
    } else {
        $data = [
            'ip' => $ip,
            'user' => $user,
            'password' => $password
        ];
        $this->session->set_userdata($data);
        $_SESSION['logged'] = true;
        
        $this->load->view('auth/login');
        redirect('Dashboard');
    }
} else {
    echo "<script> alert('Login Failed: IP Address was Invalid!'); </script>";
    $this->load->view('auth/login');
}

    }
    public function logout() 
    {
        $this->session->unset_userdata('ip');
        $this->session->unset_userdata('user');
        $this->session->unset_userdata('password');
        unset($_SESSION['logged']);
        redirect('Auth');
    }
}
