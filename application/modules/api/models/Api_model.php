<?php

class Api_model extends CI_Model {

    public function getHeaderData($token) {
        $this->db->select('
                *
                ');
        $this->db->from('m_employee');
        $this->db->where(array('token' => $token));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array(); //if data is true
        } else {
            return false; //if data is wrong
        }
    }

    public function login($data) {
        $this->db->select("*");
        $this->db->from("m_employee");
        $this->db->where(array("employee_email" => $data['username'], "sales_password" => md5($data['password']), "id_jabatan" => 1, "employee_status" => 1));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $result = $this->__setToken($query->row_array());
            return $result;
        } else {
            return false;
        }
    }

    private function __setToken($data) {
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        $dt = array('token' => $token);
        $this->db->update('m_employee', $dt, array('id' => $data['id']));
        $this->db->select("*");
        $this->db->from("m_employee");
        $this->db->where(array("id" => $data['id']));
        $query = $this->db->get();

        return $query->row_array();
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
            'customer_internal_notes' => $data['notes'],
            'photo_path' => $data['path_image'],
            'current_lead_customer_status' => $data['current_lead_customer_status']
        );

        if ($this->db->insert('m_customer', $this->main_model->create_sys($val))) {
            return true;
        }
        return false;
    }

    public function get_province() {
        $this->db->select('province_id,province_name,province_code');
        $this->db->from('province');
        return $this->db->get()->result_array();
    }

    public function get_city($province) {
        $this->db->select('city_id,province_id,city_name,lat,lng');
        $this->db->from('city');
        $this->db->where(array('province_id' => $province));
        return $this->db->get()->result_array();
    }

    public function get_district($city) {
        $this->db->select('district_id,city_id,district_name,lat,lng');
        $this->db->from('district');
        $this->db->where(array('city_id' => $city));
        return $this->db->get()->result_array();
    }

    public function register_lead($data) {
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
            'id_source_lead_customer' => $data['source_id'],
            'id_status_lead_customer' => $data['status_id'],
            'customer_internal_notes' => $data['notes'],
            'photo_path' => $data['path_image'],
            'current_lead_customer_status' => $data['current_lead_customer_status']
        );

        if ($this->db->insert('m_customer', $this->main_model->create_sys($val))) {
            return true;
        }
        return false;
    }

    public function group_customer() {
        $this->db->select('id,group_customer_product');
        $this->db->from('group_customer_product');
        $this->db->where(array('group_customer_product_status' => 1));
        return $this->db->get()->result_array();
    }

    public function source_customer() {
        $this->db->select('id,source_lead_customer');
        $this->db->from('source_lead_customer');
        $this->db->where(array('source_lead_customer_status' => 1));
        return $this->db->get()->result_array();
    }

    public function status_customer() {
        $this->db->select('id,status_lead_customer');
        $this->db->from('status_lead_customer');
        $this->db->where(array('status_lead_customer_status' => 1));
        return $this->db->get()->result_array();
    }

    public function get_list_customer($q) {
        $this->db->select('m_customer.*,m_group_product.group_product');
        $this->db->from('m_customer');
        $this->db->join('m_group_product','m_group_product.id=m_customer.id_group_customer_product','INNER');
        $this->db->or_like(array('m_customer.customer_code'=>$q,'m_customer.customer_name'=>$q));
        $this->db->where(array('m_customer.customer_status' => 1,'m_customer.current_lead_customer_status'=>'C'));
        return $this->db->get()->result_array();
    }
    
    public function logout($token) {
        if($this->db->update('m_employee',array('token'=>NULL),array('token'=>$token))) {
            return true;
        }
        
        return false;
    }
    
    public function payment_type() {
        $this->db->select('id,payment_type,payment_type_description');
        $this->db->from('m_payment_type');
        $this->db->where(array('payment_type_status' => 1));
        return $this->db->get()->result_array();
    }
    
    public function discount_type() {
        return array(1=>'Fixed',2=>'Percent');
    }
    
    public function get_product() {
        if($_GET['group'] == 1) {
            
            $this->db->select('*');
            $this->db->from('m_product');
            $this->db->like(array('product_code'=>$_GET['product_code']));
            $this->db->where(array('id_group_product'=>$_GET['group']));
            return $this->db->get()->result_array();
            
        } else if($_GET['group'] == 2) {
            
            
        }
        
        return false;
    }

}
