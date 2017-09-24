<?php

Class M_md_branch extends CI_Model {

    var $table = "m_branch";

    public function save() {
        $id = $this->input->post('id');
        $data = array(
            'branch_code' => $this->input->post('branch_code'),
            'branch_name' => $this->input->post('branch_name'),
            'branch_status' => $this->input->post('branch_status'),
            'branch_address' => $this->input->post('branch_address'),
            'branch_email' => $this->input->post('branch_email'),
            'branch_telp' => $this->input->post('branch_telp')
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
    
    public function saveBank() {
        $id = $this->input->post('id');
        $data = array(
            'id_branch' => $this->input->post('id_branch'),
            'branch_bank_name' => $this->input->post('branch_bank_name'),
            'branch_bank_account_name' => $this->input->post('branch_bank_account_name'),
            'branch_bank_account_branch' => $this->input->post('branch_bank_account_branch'),
            'branch_bank_account_number' => $this->input->post('branch_bank_account_number'),
            'branch_bank_status' => $this->input->post('branch_bank_status')
        );
        if (empty($id)) {
            $this->db->insert('m_branch_bank', $this->main_model->create_sys($data));
            return true;
        } else {
            $this->db->update('m_branch_bank', $this->main_model->update_sys($data), array('id' => $id));
            return true;
        }
        return false;
    }
    
    public function getListTable($field,$table,$join,$like,$where,$sort,$limit) {
        $this->db->select($field);
        $this->db->from($table);
        if(count($join) > 0) {
           foreach($join as $kJoin=>$vJoin){
                $this->db->join($vJoin['table'],$vJoin['where'],$vJoin['join']);
            }
        }
        if(count($where) > 0) {
            $this->db->where($where);
        }
        if(count($like) > 0) {
            $this->db->like($like);
        }
        $this->db->order_by($sort['sort_field'],$sort['sort_direction']);
		if($limit) {
			$this->db->limit($limit['limit'],$limit['offset']);
		}
        return $sql = $this->db->get()->result_array();
    }

}
