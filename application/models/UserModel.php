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
    public function update_data($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('student_tbl', $data);
    }

    // Delete Operation
    public function delete_data($id) {
        $this->db->where('id', $id);
        $this->db->delete('student_tbl');
    }
  

}