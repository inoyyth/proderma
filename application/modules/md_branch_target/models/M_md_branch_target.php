<?php

Class M_md_branch_target extends CI_Model {

    var $table = "m_branch_target";

    public function save() {
        $id = $this->input->post('id');
        $data = array(
            'id_branch' => $this->input->post('id_branch'),
            'month_target' => $this->input->post('month_target'),
            'year_target' => $this->input->post('year_target'),
            'value_target' => filter_var($this->input->post('value_target'), FILTER_SANITIZE_NUMBER_INT)
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
