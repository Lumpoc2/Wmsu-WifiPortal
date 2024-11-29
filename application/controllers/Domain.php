<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Domain extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('DomainModel'); // Load the model
    }

    public function index() {
        $data['domain'] = $this->DomainModel->getuserData(); // Get student data from the model
        $this->load->view('template/main', $data);
        $this->load->view('hotspot/userlog', $data);

    }
    
    public function post() {
        $_POST = json_decode($this->input->raw_input_stream, true);
        $data = $this->input->post('domains', true);
        $result = $this->DomainModel->insert_domain($data);
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
}
