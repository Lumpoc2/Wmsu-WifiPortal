<?php

class UserModel extends CI_Model
{
    public function get_data() {
        $query = $this->db->get('student_tbl');
        return $query->result();
    }
    public function get_emails($id) {
        $query = $this->db->select('email')->where('id', $id)->get('student_tbl');
        return $query->row()->email;
    }
    public function get_student_detail($id) {
        $query = $this->db->select('*')->where('id', $id)->get('student_tbl');
        return $query->result();
    }
    public function getHistoryData() {
        $query = $this->db->select('*')->get('tbl_active_ip');
        return $query->result();
    }
    public function update_data($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('student_tbl', $data);
    }

    // Delete Operation
    public function delete_data($id) {
        $this->db->where('id', $id);
        $this->db->delete('student_tbl');
    }

    public function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    public function insert_log_data($id, $domain, $client, $mac_address, $timestamp){
        return $this->db->insert_log($id, $domain, $client, $mac_address, $timestamp);
    }

    
     // Get all data from tbl_active_ip
    public function get_active_ip_data() {
        $query = $this->db->get('tbl_active_ip');
        return $query->result();
    }

    // Get email by ID from tbl_active_ip (assuming the column is 'email')
    public function get_active_ip_email($id) {
        $query = $this->db->select('user')->where('id', $id)->get('tbl_active_ip');
        return $query->row()->email;
    }

    // Get full record details by ID from tbl_active_ip
    public function get_active_ip_detail($id) {
        $query = $this->db->select('*')->where('id', $id)->get('tbl_active_ip');
        return $query->result();
    }

    // Get history data from tbl_active_ip
    public function get_active_ip_history() {
        $query = $this->db->select('*')->get('tbl_active_ip');
        return $query->result();
    }

    // Update data in tbl_active_ip by ID
    public function update_active_ip_data($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('tbl_active_ip', $data);
    }

  

}