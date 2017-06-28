<?php

Class M_t_mapping_area extends CI_Model {

    var $table = "m_employee";

    public function save() {
        $id = $this->input->post('id');
        $data = array(
            'sales_province' => $this->input->post('sales_province'),
            'sales_city' => $this->input->post('sales_city')
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

    public function getAvailableArea($field, $table, $join, $like, $where, $sort, $limit) {
        $currArea = array();
        $currAreaData = $this->__getCurrentArea($where['id_sales'])->result_array();
        foreach ($currAreaData as $k => $v) {
            $currArea[] = $v['id_sub_area'];
        }

        $this->db->select($field);
        $this->db->from('m_subarea');
        $this->db->join('m_area', 'm_area.id=m_subarea.id_area', 'left');
        if (count($currArea) > 0) {
            $this->db->where_not_in('m_subarea.id', $currArea);
        }
        $this->db->order_by($sort['sort_field'], $sort['sort_direction']);
        $this->db->limit($limit['limit'], $limit['offset']);
        return $this->db->get()->result_array();
    }

    public function __getCurrentArea($id) {
        $this->db->select('sales_mapping_area.*,m_subarea.subarea_name,m_area.area_code,area_name');
        $this->db->from('sales_mapping_area');
        $this->db->join('m_subarea', 'm_subarea.id=sales_mapping_area.id_sub_area', 'left');
        $this->db->join('m_area', 'm_area.id=m_subarea.id_area', 'left');
        $this->db->where('sales_mapping_area.id_sales', $id);
        return $this->db->get();
    }

    public function getCurrentArea($field, $table, $join, $like, $where, $sort, $limit) {
        $this->db->select($field);
        $this->db->from('sales_mapping_area');
        $this->db->join('m_subarea', 'm_subarea.id=sales_mapping_area.id_sub_area', 'left');
        $this->db->join('m_area', 'm_area.id=m_subarea.id_area', 'left');
        $this->db->where('sales_mapping_area.id_sales', $where['id_sales']);
        $this->db->order_by($sort['sort_field'], $sort['sort_direction']);
        $this->db->limit($limit['limit'], $limit['offset']);
        return $this->db->get()->result_array();
    }

    public function insertArea($id_employee, $array_area) {
        $session = $this->session->userdata('logged_in_admin');
        $data = array();
        foreach ($array_area as $k => $v) {
            $data[] = array(
                'id_sales' => $id_employee,
                'id_sub_area' => $v['id'],
                'sys_create_date' => date('Y-m-d H:i:s'),
                'sys_create_user' => $session['id']
            );
        }

        if ($this->db->insert_batch('sales_mapping_area', $data)) {
            return true;
        }
        return false;
    }
    
    public function removeArea($id_employee, $array_area) {
        $data = array();
        foreach ($array_area as $k => $v) {
            $data[] = $v['id_sub_area'];
        }
        
        $this->db->where('id_sales',$id_employee);
        $this->db->where_in('id_sub_area',$data);
        if ($this->db->delete('sales_mapping_area')) {
            return true;
        }
        return false;
    }

}
