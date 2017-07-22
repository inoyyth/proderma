<?php

Class M_t_sales_visit extends CI_Model {

    var $table = "sales_visit";

    public function save() {
        $id = $this->input->post('id');
        $data = array(
            'jabatan' => $this->input->post('jabatan'),
            'jabatan_status' => $this->input->post('jabatan_status')
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
        $this->db->limit($limit['limit'],$limit['offset']);
        return $sql = $this->db->get()->result_array();
    }
    
    public function getDetail($id) {
        $table = $this->table;
        $this->db->select(
                $table.'.*,'
                . 'm_customer.customer_code,'
                . 'm_customer.customer_name,'
                . 'm_customer.customer_clinic,'
                . 'm_customer.customer_address,'
                . 'm_employee.employee_nip,'
                . 'm_employee.employee_name,'
                . 'm_employee.employee_email,'
                . 'm_employee.photo_path,'
                . 'm_employee.employee_phone,'
                . 'm_activity.activity_name'
        );
        $this->db->from($table);
        $this->db->where($table.'.id',$id);
        $this->db->join('m_customer','m_customer.id='.$table.'.id_customer','INNER');
        $this->db->join('m_employee','m_employee.id='.$table.'.id_sales','INNER');
        $this->db->join('m_activity','m_activity.id='.$table.'.activity','INNER');
        return $this->db->get();
    }
}
