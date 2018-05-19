<?php

class Api_model extends CI_Model {

    public $so_code;

    public function getHeaderData($token) {
        $this->db->select('
                *
                ');
        $this->db->from('m_employee');
        $this->db->where(array('token' => $token, 'employee_status' => 1));
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
        $this->db->where_in('id_jabatan',array(1,6));
        /*$this->db->group_start();
        $this->db->or_where(array("id_jabatan" => 1, "id_jabatan" => 6));
        $this->db->group_end();*/
        $this->db->where(array("employee_nip" => $data['username'], "employee_status" => 1));
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
	
	private function __salesDetail($id_sales) {
		$this->db->select("*");
		$this->db->from("m_employee");
		$this->db->where(array("id" => $id_sales));
		return $this->db->get()->row_array();
	}

    private function __setToken($data) {
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        $dt = array('token' => $token);
        $this->db->update('m_employee', $dt, array('id' => $data['id']));
        $this->db->select("m_employee.*,m_branch.branch_name,m_branch.default_area,m_jabatan.jabatan");
        $this->db->from("m_employee");
        $this->db->join('m_branch','m_branch.id=m_employee.id_branch','INNER');
        $this->db->join('m_jabatan','m_jabatan.id=m_employee.id_jabatan','INNER');
        $this->db->where(array("m_employee.id" => $data['id']));
        $query = $this->db->get();

        return $query->row_array();
    }
    
    public function __generateCode($id_subarea) {
        $subarea =  $this->db->get_where('m_subarea',array('id'=>$id_subarea))->row_array();
        
        $getMaxById = $this->__getMaxById($id_subarea)->row_array();
        $expldCode = explode('/',$getMaxById['customer_code']);
        $lastId = (int) end($expldCode);
        $ll = $lastId + 1;
        $fixCode = 'CL/'.$subarea['subarea_code'].'/'.$subarea['subarea_nick_code'].'/'.str_pad(($ll), 3, '0', STR_PAD_LEFT);
        return $fixCode;
    }
    
    private function __getMaxById($id_subarea) {
        $this->db->select('customer_code');
        $this->db->from('m_customer');
        $this->db->where(array('id_subarea'=>$id_subarea,'current_lead_customer_status'=>'C'));
        $this->db->order_by('id','desc');
        $this->db->limit(0,1);
        return $this->db->get();
    }
    
    public function __generateCode2($id_subarea) {
        $subarea =  $this->db->get_where('m_subarea',array('id'=>$id_subarea))->row_array();
        
        $getMaxById = $this->__getMaxById2($id_subarea)->row_array();
        $expldCode = explode('/',$getMaxById['customer_code']);
        $lastId = (int) end($expldCode);
        $ll = $lastId + 1;
        $fixCode = 'ML/'.$subarea['subarea_code'].'/'.$subarea['subarea_nick_code'].'/'.str_pad(($ll), 3, '0', STR_PAD_LEFT);
        return $fixCode;
    }
    
    private function __getMaxById2($id_subarea) {
        $this->db->select('customer_code');
        $this->db->from('m_customer');
        $this->db->where(array('id_subarea'=>$id_subarea,'current_lead_customer_status'=>'L'));
        $this->db->order_by('id','desc');
        $this->db->limit(0,1);
        return $this->db->get();
    }
	
	private function __getBranch($id_employee) {
		$this->db->select('id_branch');
		$this->db->from('m_employee');
		$this->db->where('id',$id_employee);
		return $this->db->get()->row_array();
	}

    public function register_customer($data) {
        $val = array(
            'customer_code' => $this->__generateCode($data['id_subarea']),
            'customer_name' => $data['customer_name'],
            'customer_clinic' => $data['customer_clinic'],
            'customer_province' => $data['province_id'],
            'customer_city' => $data['city_id'],
            'customer_district' => $data['district_id'],
            'customer_address' => $data['address'],
            'customer_latitude' => $data['latitude'],
            'customer_longitude' => $data['longitude'],
            'customer_phone' => $data['telephone'],
            'customer_email' => $data['email'],
            'id_group_customer_product' => $data['group_id'],
            'id_status_list_customer' => 1,
            'customer_internal_notes' => $data['notes'],
            'photo_path' => $data['path_image'],
            'current_lead_customer_status' => 'C',
            'customer_status' => "1",
            'id_area' => $data['id_area'],
            'id_subarea' => $data['id_subarea'],
            'id_branch' => $data['id_branch']
        );

        if ($this->db->insert('m_customer', $this->main_model->create_sys($val))) {
            $lastID = $this->db->insert_id();
            if ($this->db->insert('sales_mapping_area',array('id_sales'=>$data['id_sales'],'id_sub_area'=>$data['id_subarea'],'id_customer'=>$lastID))) {
                return true;
            }
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
            'customer_code' => $this->__generateCode2($data['id_branch']),
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
            //'id_source_lead_customer' => $data['source_id'],
            //'id_status_lead_customer' => $data['status_id'],
            'customer_internal_notes' => $data['notes'],
            'photo_path' => $data['path_image'],
            'current_lead_customer_status' => "L",
            'customer_status' => "1",
            'id_area' => $data['id_area'],
            'id_subarea' => $data['id_subarea'],
            'id_branch' => $data['id_branch']
        );

        if ($this->db->insert('m_customer', $this->main_model->create_sys($val))) {
            $lastID = $this->db->insert_id();
            if ($this->db->insert('sales_mapping_masterlist_area',array('id_sales'=>$data['id_sales'],'id_sub_area'=>$data['id_subarea'],'id_customer'=>$lastID))) {
                return true;
            }
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

    public function get_list_customer($q, $id_sales) {
        $this->db->select('m_customer.*,m_group_product.group_product');
        $this->db->from('m_customer');
        $this->db->join('m_group_product', 'm_group_product.id=m_customer.id_group_customer_product', 'INNER');
        $this->db->join('sales_mapping_area', 'sales_mapping_area.id_customer=m_customer.id', 'INNER');
        $this->db->group_start();
        $this->db->or_like(array('m_customer.customer_code' => $q, 'm_customer.customer_name' => $q));
        $this->db->group_end();
        $this->db->where(array('sales_mapping_area.id_sales' => $id_sales, 'm_customer.customer_status' => 1, 'm_customer.current_lead_customer_status' => 'C'));
        return $this->db->get()->result_array();
    }

    public function get_lead_customer($q, $id_sales) {
        $this->db->select('m_customer.*,source_lead_customer.source_lead_customer,status_lead_customer.status_lead_customer');
        $this->db->from('m_customer');
        $this->db->join('source_lead_customer', 'source_lead_customer.id=m_customer.id_source_lead_customer', 'LEFT');
        $this->db->join('status_lead_customer', 'status_lead_customer.id=m_customer.id_status_lead_customer', 'LEFT');
        $this->db->join('m_group_product', 'm_group_product.id=m_customer.id_group_customer_product', 'LEFT');
        $this->db->join('sales_mapping_masterlist_area', 'sales_mapping_masterlist_area.id_customer=m_customer.id', 'INNER');
        $this->db->group_start();
        $this->db->or_like(array('m_customer.customer_code' => $q, 'm_customer.customer_name' => $q));
        $this->db->group_end();
        $this->db->where(array('m_customer.customer_status' => 1, 'm_customer.current_lead_customer_status' => 'L', 'sales_mapping_masterlist_area.id_sales' => $id_sales));
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

    public function get_product($customer,$product_code,$group=1) {
        $this->db->select("m_product.*,m_product_category.product_category,"
                . "m_product_sub_category.sub_category_name");
        //$this->db->from('mapping_product');
        //$this->db->join('m_product','m_product.id=mapping_product.id_product');
        $this->db->from('m_product');
        $this->db->join('m_product_category','m_product_category.id=m_product.id_product_category');
        $this->db->join('m_product_sub_category','m_product_sub_category.id=m_product.id_product_sub_category');
        $this->db->like(array('m_product.product_code' => $product_code));
        $this->db->where(array('m_product.id_group_product' => $group));
        $this->db->order_by('m_product.product_name','asc');
        return $this->db->get()->result_array();
    }

    public function sales_visitor($data) {
		$branch_sales = $this->__getBranch($data['id_sales']);
        $dt = array(
            'sales_visit_date' => $data['sales_visit_date'],
            'id_customer' => $data['id_customer'],
            'assistant_name' => $data['assistant_name'],
            'sales_visit_note' => $data['visit_note'],
            'id_sales' => $data['id_sales'],
            'order_id' => $this->main_model->generate_code('sales_visit', 'PL', '-', $digit = 7, false, false, $where = array(), 'id', 'id'),
            'activity' => $data['activity'],
            'end_date' => $data['end_date'],
            'longitude' => $data['longitude'],
            'latitude' => $data['latitude'],
            'sales_visit_customer_Type' => $data['sales_visit_customer_Type'],
            'signature_path' => $data['signature_path'],
            'sys_create_date' => date('Y-m-d H:i:s'),
			'id_branch' => $branch_sales['id_branch']
        );

        if ($this->db->insert('sales_visit', $dt)) {
            return true;
        }
        return false;
    }

    public function sales_order($data) {
        $sales = $this->__salesDetail($data['id_sales']);
        $this->so_code = $this->__generate_code($data['id_customer']);
        $dt = array(
            'so_code' => $this->so_code,
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
            'sys_create_date' => date('Y-m-d H:i:s'),
            'id_branch' => $sales['id_branch'],
            'so_bonus' => $data['so_bonus'],
            'is_special_so' => $data['is_special_so']
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
                $dt_stock[] = array(
                    'id_product' => $v['id'],
                    'update_status' => 'O',
                    'qty' => $v['qty'],
                    'description' => 'Minus stock for Sales Order with Code '.$this->so_code,
                    'sys_create_date' => date('Y-m-d H:i:s')
                );
            }

            if ($this->db->insert_batch('t_sales_order_product', $dt_product)) {
                if ($this->db->insert_batch('product_stock_manage', $dt_stock))
                return true;
            }
            return false;
        }
        return false;
    }
    
    public function __generate_code($id_customer) {
        $cust_area = $this->db->get_where('m_customer',array('id'=>$id_customer))->row_array();
        $area =  $this->db->get_where('m_area',array('id'=>$cust_area['id_area']))->row_array();
        
        $getMaxById = $this->__getMaxByIdSo($area['area_code'],$area['area_nick_code'])->row_array();
        $expldCode = explode('/',$getMaxById['so_code']);
        $lastId = (int) end($expldCode);
        $ll = $lastId + 1;
        $fixCode = 'SO/CRM/'.$area['area_nick_code'].$area['area_code'] . '/' .romanic_number(date('m')) . '/' . substr(date('Y'),2,2).'/'.str_pad(($ll), 4, '0', STR_PAD_LEFT);
        return $fixCode;
    }
    
    private function __getMaxByIdSo($id_area,$area_nick) {
        $this->db->select('so_code');
        $this->db->from('t_sales_order');
        $this->db->like(array('so_code'=>$area_nick.$id_area));
        $this->db->order_by('id','desc');
        $this->db->limit(0,1);
        return $this->db->get();
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
        $this->db->where(array('id_area' => $province, 'subarea_status' => 1));
        return $this->db->get()->result_array();
    }

    public function log_sales($data) {
        $cekExist = $this->db->select('count(*) as total')
                        ->from('log_sales')
                        ->where(array('id_sales' => $data['id_sales']))
                        ->get()->row_array();
        $dataX = array('longitude' => $data['longitude'], 'latitude' => $data['latitude'], 'datetime' => date('Y-m-d H:I:s'));
        if ($cekExist['total'] > 0) {
            $sql = $this->db->update('log_sales', $dataX, array('id_sales' => $data['id_sales']));
        } else {
            $sql = $this->db->insert('log_sales', array_merge($dataX, array('id_sales' => $data['id_sales'])));
        }
        if ($sql) {
            return true;
        }
        return false;
    }

    public function list_task($id_sales, $status) {
        $this->db->select('sales_visit_form.*,m_activity.activity_name,m_customer.customer_code,m_customer.customer_name');
        $this->db->from('sales_visit_form');
        $this->db->join('m_activity', 'm_activity.id=sales_visit_form.visit_form_activity');
        $this->db->join('m_customer', 'm_customer.id=sales_visit_form.visit_form_attendence');
        $this->db->like('sales_visit_form.visit_form_progress', $status);
        $this->db->where(array('visit_form_sales' => $id_sales, 'visit_form_status' => 1));
        return $this->db->get()->result_array();
    }

    public function update_task($data) {
        $dt = array(
            'visit_form_progress' => $data['status'],
            'visit_form_longitude' => $data['longitude'],
            'visit_form_latitude' => $data['latitude'],
            'sys_update_date' => date('Y-m-d H:I:s')
        );
        $sql = $this->db->update('sales_visit_form', $dt, array('id' => $data['id_task'], 'visit_form_sales' => $data['id_sales']));
        if ($sql) {
            return true;
        }
        return false;
    }

    public function list_plan($id_sales, $status) {
        $this->db->select('sales_visit.*,m_objective.objective,m_customer.customer_code,m_customer.customer_name');
        $this->db->from('sales_visit');
        $this->db->join('m_objective', 'm_objective.id=sales_visit.activity');
        $this->db->join('m_customer', 'm_customer.id=sales_visit.id_customer');
        $this->db->like('sales_visit.sales_visit_progress', $status);
        $this->db->where(array('sales_visit.id_sales' => $id_sales, 'sales_visit.status' => 1));
        return $this->db->get()->result_array();
    }

    public function update_plan($data) {
        $dt = array(
            'longitude' => $data['longitude'],
            'latitude' => $data['latitude'],
            'sales_visit_progress' => $data['sales_visit_progress'],
            'signature_path' => $data['signature_path'],
            'sys_update_date' => date('Y-m-d H:I:s')
        );
        $sql = $this->db->update('sales_visit', $dt, array('id' => $data['id_plan'], 'id_sales' => $data['id_sales']));
        if ($sql) {
            if ($data['sales_visit_progress'] == "COMPLETE") {
                $this->db->update('sales_visit', array('complete_date' => date('Y-m-d H:i:s')), array('id' => $data['id_plan'], 'id_sales' => $data['id_sales']));
            }
            return true;
        }
        return false;
    }

    public function get_objective($cust_type) {
        $this->db->select('id,objective');
        $this->db->from('m_objective');
        $this->db->where(array('objective_status' => 1, 'objective_customer' => $cust_type));
        return $this->db->get()->result_array();
    }

    public function log_sales_transaction($data) {
        $dt = array(
            'table' => $data['table'],
            'id_related' => $data['id_related'],
            'id_sales' => $data['id_sales'],
            'datetime' => $data['datetime'],
            'status' => $data['status']
        );
        $sql = $this->db->insert('sales_transaction_log', $data);
        if ($sql) {
            return true;
        }
        return false;
    }
    
    public function list_sales_order($id_sales) {
        $this->db->select('t_sales_order.*,m_customer.customer_name,customer_code,m_payment_type.payment_type');
        $this->db->from('t_sales_order');
        $this->db->join('m_customer','m_customer.id=t_sales_order.id_customer','INNER');
        $this->db->join('m_payment_type','m_payment_type.id=t_sales_order.so_payment_term','INNER');
        $this->db->where(array('so_status' => 1, 'id_sales' => $id_sales));
		$this->db->order_by('id','desc');
        return $this->db->get()->result_array();
    }
    
    public function list_invoice($id_sales,$status) {
        $this->db->select('t_invoice.*,t_delivery_order.do_code,t_sales_order.so_code,m_customer.customer_name,customer_code,m_payment_type.payment_type');
        $this->db->from('t_invoice');
        $this->db->join('t_delivery_order','t_delivery_order.id=t_invoice.id_do','INNER');
        $this->db->join('t_sales_order','t_sales_order.id=t_invoice.id_so','INNER');
        $this->db->join('m_customer','m_customer.id=t_sales_order.id_customer','INNER');
        $this->db->join('m_payment_type','m_payment_type.id=t_sales_order.so_payment_term','INNER');
        $this->db->like(array('invoice_sales_status' => $status));
        $this->db->where(array('invoice_status' => 1, 'id_sales' => $id_sales));
        return $this->db->get()->result_array();
    }
    
    public function list_delivery_order($id_sales) {
        $this->db->select('t_delivery_order.*,t_sales_order.so_code,m_customer.customer_name,customer_code,m_payment_type.payment_type');
        $this->db->from('t_delivery_order');
        $this->db->join('t_sales_order','t_sales_order.id=t_delivery_order.id_so','INNER');
        $this->db->join('m_customer','m_customer.id=t_sales_order.id_customer','INNER');
        $this->db->join('m_payment_type','m_payment_type.id=t_sales_order.so_payment_term','INNER');
        $this->db->like(array('t_delivery_order.do_sales_status' => $status));
        $this->db->where(array('t_delivery_order.do_status' => 1, 't_sales_order.id_sales' => $id_sales));
        return $this->db->get()->result_array();
    }
    
    public function update_baterai($data) {
        $cekExist = $this->db->get_where('baterai_status',array('id_sales'=>$data['id_sales']))->num_rows();
        $dt = array(
            'id_sales'=>$data['id_sales'],
            'longitude' => $data['longitude'],
            'latitude' => $data['latitude'],
            'baterai' => $data['baterai'],
            'sys_update_date' => date('Y-m-d H:I:s')
        );
        /*if ($cekExist > 0) {
            $sql = $this->db->update('baterai_status', $dt, array('id_sales' => $data['id_sales']));
        } else {*/
            $dt['id_sales'] = $data['id_sales'];
            $sql = $this->db->insert('baterai_status',$dt);
        /*}*/
        if ($sql) {
            return true;
        }
        return false;
    }
    
    public function get_related_code($id_sales,$type) {
        if ($type == 1) {
            $this->db->select('so_code');
            $this->db->from('t_sales_order');
            $this->db->where('id_sales',$id_sales);
            $this->db->order_by('id','desc');
            return $this->db->get()->result_array();
        }
        
        if ($type == 2) {
            $this->db->select('t_delivery_order.do_code');
            $this->db->from('t_delivery_order');
            $this->db->join('t_sales_order','t_delivery_order.id_so=t_sales_order.id');
            $this->db->where('t_sales_order.id_sales',$id_sales);
            $this->db->order_by('t_delivery_order.id','desc');
            return $this->db->get()->result_array();
        }
        
        if ($type == 3) {
            $this->db->select('t_invoice.do_code');
            $this->db->from('t_invoice');
            $this->db->join('t_sales_order','t_invoice.id_so=t_sales_order.id');
            $this->db->where('t_sales_order.id_sales',$id_sales);
            $this->db->order_by('t_invoice.id','desc');
            return $this->db->get()->result_array();
        }
    }
}
