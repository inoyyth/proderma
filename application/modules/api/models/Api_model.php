<?php

class Api_model extends CI_Model {

    public function getHeaderData($token) {
        $this->db->select('
                *
                ');
        $this->db->from('m_employee');
        $this->db->where(array('token' => $token, 'employee_status'=>1));
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
        $this->db->where(array("employee_email" => $data['username'], "id_jabatan" => 1, "employee_status" => 1));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $dt = $query->row_array();
            if ($this->encrypt->decode($dt['sales_password']) == $data['password']) {
                $result = $this->__setToken($query->row_array());
                return $result;
            } else {
                return false;
            }
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

    public function __generate_code($tables, $prefix, $separator, $digit = 4, $date = true, $loop = false, $field = 'id', $field_target) {
        $tgl = date('y');
        $where = array();
        if ($loop == true) {
            $where = array('YEAR(sys_create_date)' => date('Y'), 'MONTH(sys_create_date)' => date('m'));
        }
        $this->db->select($field_target);
        $this->db->from($tables);
        $this->db->where($where);
        $this->db->order_by($field, 'DESC');
        $this->db->limit(1);
        $dt = $this->db->get()->row_array();
        $explode_target = explode($separator, $dt[$field_target]);
        $dt_target = intval(end($explode_target));
        $maxi = $dt_target;

        $hsl = str_pad(($maxi == 0 ? 1 : intval($maxi) + 1), $digit, '0', STR_PAD_LEFT);
        if ($date == true) {
            return $prefix . $separator . date('Ym') . $separator . $hsl;
        } else {
            return $prefix . $separator . $hsl;
        }
    }
    
    public function __generate_code2($tables, $prefix, $separator, $digit = 4, $date = true, $loop = false, $where=array(),$field,$order) {
        $tgl = date('y');
        $this->db->select($field);
        $this->db->where($where);
        $this->db->order_by($order,'DESC');
        if ($loop == false) {
            $maxi = $this->db->get($tables)->row($field);
        } else {
            $maxi = $this->db->get_where($tables, array('DATE(sys_create_date)' => date('Y-m-d')))->row('max_id');
        }
        $hsl = str_pad((intval(preg_replace("/[^0-9,.]/", "", $maxi)) == 0 ? 1 : intval(preg_replace("/[^0-9,.]/", "", $maxi)) + 1), $digit, '0', STR_PAD_LEFT);
        if ($date == true) {
            return $prefix . $separator . date('Ymd') . $separator . $hsl;
        } else {
            return $prefix . $separator . $hsl;
        }
    }

    public function register_customer($data) {
        $val = array(
            'customer_code' => $this->__generate_code2('m_customer', $this->config->item('customer_code').'/1','/' , $digit = 5, true,false, $where=array(),'id','id'),
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
            'id_status_list_customer' => 1,
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
            'customer_code' => $this->__generate_code2('m_customer', $this->config->item('customer_code').'/0','/' , $digit = 5, true,false, $where=array(),'id','id'),
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
        $this->db->join('m_group_product', 'm_group_product.id=m_customer.id_group_customer_product', 'INNER');
        $this->db->or_like(array('m_customer.customer_code' => $q, 'm_customer.customer_name' => $q));
        $this->db->where(array('m_customer.customer_status' => 1, 'm_customer.current_lead_customer_status' => 'C'));
        return $this->db->get()->result_array();
    }
    
    public function get_lead_customer($q) {
        $this->db->select('m_customer.*,m_group_product.group_product');
        $this->db->from('m_customer');
        $this->db->join('m_group_product', 'm_group_product.id=m_customer.id_group_customer_product', 'INNER');
        $this->db->or_like(array('m_customer.customer_code' => $q, 'm_customer.customer_name' => $q));
        $this->db->where(array('m_customer.customer_status' => 1, 'm_customer.current_lead_customer_status' => 'L'));
        return $this->db->get()->result_array();
    }

    public function logout($token) {
        if ($this->db->update('m_employee', array('token' => NULL), array('token' => $token))) {
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
        return array(1 => 'Fixed', 2 => 'Percent');
    }

    public function get_product() {
        if ($_GET['group'] == 1) {

            $this->db->select('*');
            $this->db->from('m_product');
            $this->db->like(array('product_code' => $_GET['product_code']));
            $this->db->where(array('id_group_product' => $_GET['group']));
            return $this->db->get()->result_array();
        } else if ($_GET['group'] == 2) {
            
        }

        return false;
    }

    public function sales_visitor($data) {
        $dt = array(
            'sales_visit_date' => $data['date'],
            'id_customer' => $data['id_customer'],
            'assistant_name' => $data['assistant_name'],
            'sales_visit_note' => $data['visit_note'],
            'id_sales' => $data['id_sales'],
            'order_id' => $data['order_id'],
            'activity' => $data['activity'],
            'end_date' => $data['end_date'],
            'longitude' => $data['longitude'],
            'latitude' => $data['latitude'],
            'signature_path' => $data['signature_path'],
            'sys_create_date' => date('Y-m-d H:i:s')
        );

        if ($this->db->insert('sales_visit', $dt)) {
            return true;
        }
        return false;
    }

    public function sales_order($data) {
        $dt = array(
            'so_code' => $this->__generate_code('t_sales_order', 'SO', '/', 8, true, true, 'id', 'so_code'),
            'so_date' => $data['date'],
            'id_customer' => $data['id_customer'],
            'id_sales' => $data['id_sales'],
            'so_payment_term' => $data['payment_type'],
            'so_discount_type' => $data['discount_type'],
            'so_discount_value' => $data['discount_value'],
            'so_signature' => $data['signature_path'],
            'so_status' => $data['status'],
            'so_total' => $data['total'],
            'so_tax_amount' => $data['tax_amount'],
            'so_grand_total' => $data['grand_total'],
            'sys_create_user' => $data['id_sales'],
            'sys_create_date' => date('Y-m-d H:i:s')
        );

        if ($this->db->insert('t_sales_order', $dt)) {
            $id_so = $this->db->insert_id();
            $dt_product = array();
            foreach ($data['product'] as $k => $v) {
                $dt_product[] = array(
                    'id_sales_order' => $id_so,
                    'id_product' => $v['id'],
                    'qty' => $v['qty'],
                    'description' => $v['description'],
                    'sys_create_user' => $data['id_sales'],
                    'sys_create_date' => date('Y-m-d H:i:s')
                );
            }

            if ($this->db->insert_batch('t_sales_order_product', $dt_product)) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function get_activity() {
        $this->db->select('id,activity_name,activity_status');
        $this->db->from('m_activity');
        $this->db->where(array('activity_status' => 1));
        return $this->db->get()->result_array();
    }

    public function plan($data) {
        $dt = array(
            'visit_form_code' => $this->__generate_code('sales_visit_form', $this->config->item('ojt_code') . "-" . date('ym'), '/', $digit = 5, false, false, $where = array(), 'id', 'visit_form_code'),
            'visit_form_subject' => $data['visit_form_subject'],
            'visit_form_sales' => $data['visit_form_sales'],
            'visit_form_activity' => $data['visit_form_activity'],
            'visit_form_attendence' => $data['visit_form_attendence'],
            'visit_form_start_date' => $data['visit_form_start_date'],
            'visit_form_end_date' => $data['visit_form_end_date'],
            'visit_form_location' => $data['visit_form_location'],
            'visit_form_description' => $data['visit_form_description'],
            'visit_form_objective' => $data['visit_form_objective'],
            'visit_form_status' => 1,
            'sys_create_user' => $data['visit_form_sales'],
            'sys_create_date' => date('Y-m-d H:i:s')
        );

        if ($this->db->insert('sales_visit_form', $dt)) {
            return true;
        }
        return false;
    }

    public function promo() {
        $this->db->select('*');
        $this->db->from('m_promo_product');
        $this->db->where(array('promo_status' => 1));
        return $this->db->get()->result_array();
    }

    public function log_pdf($data) {
        $dt = array(
            'id_sales' => $data['id_sales'],
            'id_promo' => $data['id_promo'],
            'promo_code' => $data['promo_code'],
            'datetime' => $data['datetime']
        );

        if ($this->db->insert('pdf_log', $dt)) {
            return true;
        }
        return false;
    }
    
    public function get_master_area() {
        $this->db->select('id,area_code,area_name,area_description');
        $this->db->from('m_area');
        $this->db->where(array('area_status' => 1));
        return $this->db->get()->result_array();
    }
    
    public function get_master_sub_area($province) {
        $this->db->select('id,id_area,subarea_name,subarea_code,subarea_description');
        $this->db->from('m_subarea');
        $this->db->where(array('id_area' => $province,'subarea_status'=>1));
        return $this->db->get()->result_array();
    }

}
