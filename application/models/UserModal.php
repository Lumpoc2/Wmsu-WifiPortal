<?php

class UserModal extends CI_Model
{
    public function insertUser($data)
    {
       return $this->db->insert('user_tbl', $data);
    }
    public function deleteUser($id)
    {
      return $this->db->delete('user_tbl', ['id' => $id]);
    }
 }