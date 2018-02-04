<?php

Class M_md_payment_type extends CI_Model {

    var $table = "m_payment_type";

    public function save() {
        $id = $this->input->post('id');
        $data = array(
            'payment_type' => $this->input->post('payment_type'),
            'payment_type_description' => $this->input->post('payment_type_description'),
            'payment_type_status' => $this->input->post('payment_type_status'),
            'termin_status' => ($this->input->post('termin_status') != NULL ? $this->input->post('termin_status') : '1'),
            'termin_range' => $this->input->post('termin_range')
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

}
