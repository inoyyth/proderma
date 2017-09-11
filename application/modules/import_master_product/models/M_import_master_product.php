<?php

Class M_import_master_product extends CI_Model {

    var $table = "m_customer";
    
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
    
    public function getSubAndCategory($where) {
        $this->db->select("CONCAT(m_product_category.id,'-',m_product_sub_category.id) as Kode, CONCAT(m_product_category.product_category,' | ',m_product_sub_category.sub_category_name) as Name");
        $this->db->from('m_product_sub_category');
        $this->db->join('m_product_category','m_product_category.id=m_product_sub_category.id_product_category','INNER');
        $this->db->where($where);
        $this->db->order_by('m_product_category.product_category','ASC');
        return $this->db->get();
    }
}
