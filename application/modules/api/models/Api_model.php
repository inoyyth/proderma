<?php

class Api_model extends CI_Model {

    public function getHeaderData($token) {
        $this->db->select('
                account.id,
                account.username,
                account.no_telp,
                account.email,
                account.path_foto,
                account.token
                ');
        $this->db->from('account');
        $this->db->where(array('token'=>$token));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array(); //if data is true
        } else {
            return false; //if data is wrong
        }
    }

}
