<?php

Class M_t_mapping_area extends CI_Model {

    var $table = "m_employee";

    public function save() {
        $id = $this->input->post('id');
        $data = array(
            'sales_province' => $this->input->post('sales_province'),
            'sales_city' => $this->input->post('sales_city')
        );
        if (empty($id)) {
            $this->db->insert($this->table, $this->main_model->create_sys($data));
            return true;
        } else {
            $this->db->update($this->table, $this->main_model->update_sys($data), array('id' => $id));
            return true;
        }
        return false;
    }

    public function getListTable($field, $table, $join, $like, $where, $sort, $limit) {
        $this->db->select($field);
        $this->db->from($table);
        if (count($join) > 0) {
            foreach ($join as $kJoin => $vJoin) {
                $this->db->join($vJoin['table'], $vJoin['where'], $vJoin['join']);
            }
        }
        if (count($where) > 0) {
            $this->db->where($where);
        }
        if (count($like) > 0) {
            $this->db->like($like);
        }
        $this->db->order_by($sort['sort_field'], $sort['sort_direction']);
		if ($limit) {
			$this->db->limit($limit['limit'], $limit['offset']);
		}
        return $sql = $this->db->get()->result_array();
    }
    
    public function getAvailableCustomer($field, $table, $join, $like, $where, $sort, $limit) {
        $currCustomer = array();
        $currCustomerData = $this->__getCurrentCustomer($where['id_sales'])->result_array();
        foreach ($currCustomerData as $k => $v) {
            $currCustomer[] = $v['id_customer'];
        }

        $this->db->select($field);
        $this->db->from('m_customer');
        $this->db->join('m_subarea', 'm_subarea.id=m_customer.id_subarea', 'left');
        $this->db->join('m_area', 'm_area.id=m_customer.id_area', 'left');
        $this->db->group_start();
        $this->db->or_like($like);
        $this->db->group_end();
        $this->db->where(array('current_lead_customer_status'=>'C'));
        if($this->sessionGlobal['super_admin'] == "1") {
            $this->db->where('m_customer.id_branch',$this->sessionGlobal['id_branch']);
        }
        if (count($currCustomer) > 0) {
            $this->db->where_not_in('m_customer.id', $currCustomer);
        }
        $this->db->order_by($sort['sort_field'], $sort['sort_direction']);
        $this->db->limit($limit['limit'], $limit['offset']);
        return $this->db->get()->result_array();
    }
    
    public function __getCurrentCustomer($id) {
        $this->db->select('sales_mapping_area.*,m_subarea.subarea_name,m_customer.customer_code,customer_name');
        $this->db->from('sales_mapping_area');
        $this->db->join('m_subarea', 'm_subarea.id=sales_mapping_area.id_sub_area', 'left');
        $this->db->join('m_customer', 'm_customer.id=sales_mapping_area.id_customer', 'left');
        $this->db->where('sales_mapping_area.id_sales', $id);
        return $this->db->get();
    }
    
    public function getCurrentCustomer($field, $table, $join, $like, $where, $sort, $limit) {
        $this->db->select($field);
        $this->db->from('sales_mapping_area');
        $this->db->join('m_subarea', 'm_subarea.id=sales_mapping_area.id_sub_area', 'left');
        $this->db->join('m_customer', 'm_customer.id=sales_mapping_area.id_customer', 'left');
        $this->db->join('m_area', 'm_area.id=m_subarea.id_area', 'left');
        $this->db->group_start();
        $this->db->or_like($like);
        $this->db->group_end();
        $this->db->where('sales_mapping_area.id_sales', $where['id_sales']);
        $this->db->order_by($sort['sort_field'], $sort['sort_direction']);
        $this->db->limit($limit['limit'], $limit['offset']);
        return $this->db->get()->result_array();
    }
    
    public function insertCustomer($id_employee, $array_data) {
        $session = $this->session->userdata('logged_in_admin');
        $data = array();
        foreach ($array_data as $k => $v) {
            $data[] = array(
                'id_sales' => $id_employee,
                'id_sub_area' => $v['id_subarea'],
                'id_customer' => $v['id'],
                'sys_create_date' => date('Y-m-d H:i:s'),
                'sys_create_user' => $session['id']
            );
        }

        if ($this->db->insert_batch('sales_mapping_area', $data)) {
            return true;
        }
        return false;
    }
    
    public function removeCustomer($id_employee, $array_data) {
        $data = array();
        foreach ($array_data as $k => $v) {
            $data[] = $v['id_customer'];
        }
        
        $this->db->where('id_sales',$id_employee);
        $this->db->where_in('id_customer',$data);
        if ($this->db->delete('sales_mapping_area')) {
            return true;
        }
        return false;
    }
    
    public function getAvailableCustomerList($field, $table, $join, $like, $where, $sort, $limit) {
        $currCustomer = array();
        $currCustomerData = $this->__getCurrentCustomerList($where['id_sales'])->result_array();
        foreach ($currCustomerData as $k => $v) {
            $currCustomer[] = $v['id_customer'];
        }

        $this->db->select($field);
        $this->db->from('m_customer');
        $this->db->join('m_subarea', 'm_subarea.id=m_customer.id_subarea', 'left');
        $this->db->join('m_area', 'm_area.id=m_customer.id_area', 'left');
        $this->db->group_start();
        $this->db->or_like($like);
        $this->db->group_end();
        $this->db->where(array('current_lead_customer_status'=>'L'));
        if($this->sessionGlobal['super_admin'] == "1") {
            $this->db->where('m_customer.id_branch',$this->sessionGlobal['id_branch']);
        }
        if (count($currCustomer) > 0) {
            $this->db->where_not_in('m_customer.id', $currCustomer);
        }
        $this->db->order_by($sort['sort_field'], $sort['sort_direction']);
        $this->db->limit($limit['limit'], $limit['offset']);
        return $this->db->get()->result_array();
    }
    
    public function __getCurrentCustomerList($id) {
        $this->db->select('sales_mapping_masterlist_area.*,m_subarea.subarea_name,m_customer.customer_code,customer_name');
        $this->db->from('sales_mapping_masterlist_area');
        $this->db->join('m_subarea', 'm_subarea.id=sales_mapping_masterlist_area.id_sub_area', 'left');
        $this->db->join('m_customer', 'm_customer.id=sales_mapping_masterlist_area.id_customer', 'left');
        $this->db->where('sales_mapping_masterlist_area.id_sales', $id);
        return $this->db->get();
    }
    
    public function getCurrentCustomerList($field, $table, $join, $like, $where, $sort, $limit) {
        $this->db->select($field);
        $this->db->from('sales_mapping_masterlist_area');
        $this->db->join('m_subarea', 'm_subarea.id=sales_mapping_masterlist_area.id_sub_area', 'left');
        $this->db->join('m_customer', 'm_customer.id=sales_mapping_masterlist_area.id_customer', 'left');
        $this->db->join('m_area', 'm_area.id=m_subarea.id_area', 'left');
        $this->db->group_start();
        $this->db->or_like($like);
        $this->db->group_end();
        $this->db->where('sales_mapping_masterlist_area.id_sales', $where['id_sales']);
        $this->db->order_by($sort['sort_field'], $sort['sort_direction']);
        $this->db->limit($limit['limit'], $limit['offset']);
        return $this->db->get()->result_array();
    }
    
    public function insertCustomerList($id_employee, $array_data) {
        $session = $this->session->userdata('logged_in_admin');
        $data = array();
        foreach ($array_data as $k => $v) {
            $data[] = array(
                'id_sales' => $id_employee,
                'id_sub_area' => $v['id_subarea'],
                'id_customer' => $v['id'],
                'sys_create_date' => date('Y-m-d H:i:s'),
                'sys_create_user' => $session['id']
            );
        }

        if ($this->db->insert_batch('sales_mapping_masterlist_area', $data)) {
            return true;
        }
        return false;
    }
    
    public function removeCustomerList($id_employee, $array_data) {
        $data = array();
        foreach ($array_data as $k => $v) {
            $data[] = $v['id_customer'];
        }
        
        $this->db->where('id_sales',$id_employee);
        $this->db->where_in('id_customer',$data);
        if ($this->db->delete('sales_mapping_masterlist_area')) {
            return true;
        }
        return false;
    }

}
