<?php

Class M_t_sales_visit extends CI_Model {

    var $table = "sales_visit";

    public function save() {
        $id = $this->input->post('id');
		if ($this->sessionGlobal['super_admin'] == '1') {
            $branch = $this->sessionGlobal['id_branch'];
        } else {
            $branch = $this->input->post('id_branch');
        }
        $data = array(
            'sales_visit_date' => $this->input->post('sales_visit_date'),
            'id_customer' => $this->input->post('id_customer'),
            'assistant_name' => $this->input->post('assistant_name'),
            'sales_visit_note' => $this->input->post('sales_visit_note'),
            'id_sales' => $this->input->post('id_sales'),
            'activity' => $this->input->post('activity'),
            'end_date' => $this->input->post('end_date'),
            'longitude' => $this->input->post('longitude'),
            'latitude' => $this->input->post('latitude'),
			'id_branch' => $branch,
			'related_code' => $this->input->post('related_code'),
        );
        if (empty($id)) {
            $data['order_id'] =  $this->main_model->generate_code('sales_visit', 'PL','-' , $digit = 7, false,false, $where=array(),'id','id');
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

    public function getDetail($id) {
        $table = $this->table;
        $this->db->select(
                $table . '.*,'
                . 'm_customer.customer_code,'
                . 'm_customer.customer_name,'
                . 'm_customer.customer_clinic,'
                . 'm_customer.customer_address,'
                . 'm_employee.employee_nip,'
                . 'm_employee.employee_name,'
                . 'm_employee.employee_email,'
                . 'm_employee.photo_path,'
                . 'm_employee.employee_phone,'
				. 'm_branch.branch_name,'
                . 'm_objective.objective'
        );
        $this->db->from($table);
        $this->db->where($table . '.id', $id);
        $this->db->join('m_customer', 'm_customer.id=' . $table . '.id_customer', 'LEFT');
        $this->db->join('m_employee', 'm_employee.id=' . $table . '.id_sales', 'LEFT');
        $this->db->join('m_objective', 'm_objective.id=' . $table . '.activity', 'LEFT');
		$this->db->join('m_branch', 'm_branch.id=' . $table . '.id_branch', 'LEFT');
        return $this->db->get();
    }

    public function getCustomerList($q, $status) {
        $this->db->select('id,CONCAT(customer_code," - ",customer_name) as cus_concat');
        $this->db->from('m_customer');
        $this->db->group_start();
        $this->db->or_like(array('customer_name' => $q, 'customer_code' => $q));
        $this->db->group_end();
		if($this->sessionGlobal['super_admin'] == "1") {
            $this->db->where('id_branch',$this->sessionGlobal['id_branch']);
        }
        $this->db->where(array('current_lead_customer_status' => $status, 'customer_status' => 1));
        return $this->db->get();
    }
	
	public function getEmployee() {
		$this->db->select('*');
		$this->db->from('m_employee');
		$this->db->where(array('employee_status'=>1,'id_jabatan'=>1));
		if($this->sessionGlobal['super_admin'] == "1") {
            $this->db->where('id_branch',$this->sessionGlobal['id_branch']);
        }
		$this->db->order_by('employee_name','asc');
		return $this->db->get();
    }
    
    public function getCustomerCode($id_customer) {
        $this->db->select('customer_code, customer_name');
        $this->db->from('m_customer');
        $this->db->where('id', $id_customer);
        return $this->db->get()->row_array();
    }

}
