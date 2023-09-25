<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class students extends CI_Controller
{
    public function index(){
        $this->load->view('template/main');
		$this->load->view('students/student_tbl');
    }    
}