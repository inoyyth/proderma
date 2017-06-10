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
        $this->db->where(array('token' => $token));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array(); //if data is true
        } else {
            return false; //if data is wrong
        }
    }

    public function register_customer($data) {
        $val = array(
            'customer_code' => $data['customer_code'],
            'customer_name' => $data['customer_name'],
            'customer_clinic' => $data['customer_clinic'],
            'customer_province' => $data['province_id'],
            'customer_city' => $data['city_id'],
            'customer_district' => $data['district_id'],
            'customer_address' => $data['address'],
            'customer_latitude' => $data['address'],
            'customer_longitude' => $data['address'],
            'customer_phone' => $data['telephone'],
            'customer_email' => $data['email'],
            'id_group_customer_product' => $data['group_id'],
            'id_status_list_customer' => $data['status_id'],
            'customer_internal_notes' => $data['notes'],
            'photo_path' => $data['path_image']
        );

        if ($this->db->insert('m_customer',$this->main_model->create_sys($val))) {
            return true;
        }
        return false;
    }
    
    public function get_province() {
        $this->db->select('province_id,province_name,province_code');
        $this->db->from('province');
        return $this->db->get()->result_array();
    }
    
    public function get_city() {
        $this->db->select('city_id,province_id,city_name,lat,lng');
        $this->db->from('city');
        return $this->db->get()->result_array();
    }

}
