<?php

class DomainModel extends CI_Model {


    public function insert_domain($data) {
       $result = $this->db->insert_batch('domains', $data);
       return $result;
    }

    public function getuserData() {
        $query = $this->db->get('domains');
        return $query->result();
    }

    
}