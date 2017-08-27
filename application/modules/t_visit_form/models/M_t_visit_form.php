<?php

Class M_t_visit_form extends CI_Model {

    var $table = "sales_visit_form";

    public function save() {
        $id = $this->input->post('id');
        $data = array(
            'visit_form_code' => $this->input->post('visit_form_code'),
            'visit_form_subject' => $this->input->post('visit_form_subject'),
            'visit_form_sales' => $this->input->post('visit_form_sales'),
            'visit_form_activity' => $this->input->post('visit_form_activity'),
            'visit_form_attendence' => $this->input->post('visit_form_attendence'),
            'visit_form_start_date' => $this->input->post('visit_form_start_date'),
            'visit_form_end_date' => $this->input->post('visit_form_end_date'),
            'visit_form_location' => $this->input->post('visit_form_location'),
            'visit_form_description' => $this->input->post('visit_form_description'),
            'visit_form_objective' => $this->input->post('visit_form_objective'),
            'visit_form_status' => $this->input->post('visit_form_status')
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
    
    public function getCustomerList($q) {
        $this->db->select('id,CONCAT(customer_code," - ",customer_name) as cus_concat');
        $this->db->from('m_customer');
        $this->db->group_start();
        $this->db->or_like(array('customer_name'=>$q,'customer_code'=>$q));
        $this->db->group_end();
        $this->db->where(array('customer_status' => 1));
        return $this->db->get();
    }
    
    public function getEditData($table,$id) {
        $this->db->select($table.'.*,m_customer.customer_name');
        $this->db->from($table);
        $this->db->join('m_customer','m_customer.id='.$table.'.visit_form_attendence','INNER');
        $this->db->where(array($table.'.id'=>$id));
        return $this->db->get();
    }

}
