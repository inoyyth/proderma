<?php

Class M_import_master_list extends CI_Model {

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
    
    public function generateCode($id_subarea) {
        $subarea =  $this->db->get_where('m_subarea',array('id'=>$id_subarea))->row_array();
        
        $getMaxById = $this->__getMaxById($id_subarea)->row_array();
        $expldCode = explode('/',$getMaxById['customer_code']);
        $lastId = (int) end($expldCode);
        $ll = $lastId + 1;
        $fixCode = 'ML/'.$subarea['subarea_code'].'/'.$subarea['subarea_nick_code'].'/'.str_pad(($ll), 3, '0', STR_PAD_LEFT);
        return $fixCode;
    }
    
    private function __getMaxById($id_subarea) {
        $this->db->select('customer_code');
        $this->db->from('m_customer');
        $this->db->where(array('id_subarea'=>$id_subarea,'current_lead_customer_status'=>'L'));
        $this->db->order_by('id','desc');
        $this->db->limit(0,1);
        return $this->db->get();
    }
}
