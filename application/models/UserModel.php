<?php

class UserModel extends CI_Model
{
   public function insertUser($data)
   {
      return $this->db->insert('user_tbl', $data);
   }
   public function deleteUser($id) {
      $this->db->where('id', $id);
      $success = $this->db->delete('user_tbl');
        
      if ($success) {
          return "User deleted successfully";
          
      } else {
          return "Error deleting user: " . $this->db->error();
      }
  }
  
  public function getUserById($id) {
      return $this->db->get_where('user_tbl', ['id' => $id])->row_array();
  }

  public function updateUser($id, $data) {
      $this->db->where('id', $id);
      $this->db->update('user_tbl', $data);
  }

}