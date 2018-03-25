<?php

Class M_md_manage_product extends CI_Model {

    var $table = "product_stock_manage";

    public function save() {
        $id = $this->input->post('id');
        
        $data = array(
            'id_product' => $this->input->post('id_product'),
            'update_status' => $this->input->post('update_status'),
            'qty' => $this->input->post('qty'),
            'description' => $this->input->post('description')
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
    
    public function getListTable($field,$table,$join,$like,$where,$sort,$limit,$where_in,$group_by) {
        $this->db->select($field);
        $this->db->from($table);
        if(count($join) > 0) {
           foreach($join as $kJoin=>$vJoin){
                $this->db->join($vJoin['table'],$vJoin['where'],$vJoin['join']);
            }
        }
        if(count($like) > 0) {
            $this->db->like($like);
        }
        if(count($where_in) > 0) {
            $this->db->where_in($where_in['field'],$where_in['value']);
        }
        if(count($where) > 0) {
            $this->db->where($where);
        }
        if($group_by && is_array($group_by)) {
            $this->db->group_by($group_by);
        }
        $this->db->order_by($sort['sort_field'],$sort['sort_direction']);
        if($limit) {
            $this->db->limit($limit['limit'],$limit['offset']);
        }
        return $sql = $this->db->get()->result_array();
        //echo json_encode($sql);
    }
    
    public function edit_data($table, $where) {
        $this->db->select($table.'.*,m_product_sub_category.sub_category_name');
        $this->db->from($table);
        $this->db->join('m_product_sub_category',$table.'.id_product_sub_category=m_product_sub_category.id', 'left');
        $this->db->where($where);
        return $this->db->get();
    }
    
    public function detailData($id) {
        $this->db->select('m_product.*');
        $this->db->from('m_product');
        $this->db->where('m_product.id',$id);
        return $this->db->get();
    }

}
