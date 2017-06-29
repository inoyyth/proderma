<?php

Class M_t_mapping_product extends CI_Model {

    var $table = "m_customer";

    public function save() {
        $id = $this->input->post('id');
        $data = array(
            'id_group_customer_product' => $this->input->post('id_group_customer_product')
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
    
    public function getDetail($table,$where) {
        $this->db->select($table.'.*,m_area.area_code,m_area.area_name,m_subarea.subarea_code,m_subarea.subarea_name');
        $this->db->from($table);
        $this->db->join('m_area','m_area.id='.$table.'.id_area','left');
        $this->db->join('m_subarea','m_subarea.id='.$table.'.id_subarea','left');
        $this->db->where($where);
        return $this->db->get();
    }
    
    public function getAvailableProduct($field, $table, $join, $like, $where, $sort, $limit) {
        $currProduct = array();
        $currProductData = $this->__getCurrentProduct($where['id_customer'])->result_array();
        foreach ($currProductData as $k => $v) {
            $currProduct[] = $v['id_product'];
        }

        $this->db->select($field);
        $this->db->from('m_product');
        if (count($join) > 0) {
            foreach ($join as $kJoin => $vJoin) {
                $this->db->join($vJoin['table'], $vJoin['where'], $vJoin['join']);
            }
        }
        $this->db->where('m_product.id_group_product',$where['id_group_product']);
        if (count($currProduct) > 0) {
            $this->db->where_not_in('m_product.id', $currProduct);
        }
        $this->db->order_by($sort['sort_field'], $sort['sort_direction']);
        $this->db->limit($limit['limit'], $limit['offset']);
        return $this->db->get()->result_array();
    }

    public function __getCurrentProduct($id) {
        $this->db->select('*');
        $this->db->from('mapping_product');
        $this->db->where('id_customer', $id);
        return $this->db->get();
    }

    public function getCurrentProduct($field, $table, $join, $like, $where, $sort, $limit) {
        $this->db->select($field);
        $this->db->from('mapping_product');
        if (count($join) > 0) {
            foreach ($join as $kJoin => $vJoin) {
                $this->db->join($vJoin['table'], $vJoin['where'], $vJoin['join']);
            }
        }
        $this->db->where('mapping_product.id_customer', $where['id_customer']);
        $this->db->order_by($sort['sort_field'], $sort['sort_direction']);
        $this->db->limit($limit['limit'], $limit['offset']);
        return $this->db->get()->result_array();
    }
    
    public function insertProduct($id_customer, $array_product) {
        $session = $this->session->userdata('logged_in_admin');
        $data = array();
        foreach ($array_product as $k => $v) {
            $data[] = array(
                'id_customer' => $id_customer,
                'id_product' => $v['id'],
                'sys_create_date' => date('Y-m-d H:i:s'),
                'sys_create_user' => $session['id']
            );
        }

        if ($this->db->insert_batch('mapping_product', $data)) {
            return true;
        }
        return false;
    }
    
    public function removeProduct($id_customer, $array_product) {
        $data = array();
        foreach ($array_product as $k => $v) {
            $data[] = $v['id'];
        }
        
        $this->db->where('id_customer',$id_customer);
        $this->db->where_in('id_product',$data);
        if ($this->db->delete('mapping_product')) {
            return true;
        }
        return false;
    }

}
