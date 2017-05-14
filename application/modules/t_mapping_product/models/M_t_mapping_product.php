<?php

Class M_t_mapping_product extends CI_Model {

    var $table = "mapping_product";

    public function save() {
        $id_sales = $this->input->post('id_sales');
        $product = $this->input->post('product');
        $session = $this->session->userdata('logged_in_admin');
        $dt = array();
        foreach ($product as $k => $v) {
            $dt[] = array(
                'id_sales' => $id_sales,
                'id_product' => $v,
                'sys_create_user' => $session['id'],
                'sys_create_date' => date('Y-m-d H:i:s')
            );
        }
        $this->db->delete('mapping_product',array('id_sales'=>$id_sales));
        if ($this->db->insert_batch('mapping_product', $dt)) {
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
        $this->db->limit($limit['limit'], $limit['offset']);
        return $sql = $this->db->get()->result_array();
    }

    public function getOwnProduct($id) {
        $this->db->select('id_product');
        $this->db->from('mapping_product');
        $this->db->where('id_sales', $id);
        $sql = $this->db->get()->result_array();

        $dt = array();
        foreach($sql as $k=>$v) {
            $dt[] = $v['id_product'];
        }
        
        return $dt;
    }

}
