<?php

Class M_r_customer extends CI_Model {

    var $table = "m_customer";

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

    public function getYearlyReport($year) {
        $this->db->select('count(id) as total, MONTH(sys_create_date) as bulan');
        $this->db->from('m_customer');
        $this->db->where(array('customer_status<>' => 3, 'current_lead_customer_status' => 'C', 'YEAR(sys_create_date)' => $year));
        $this->db->group_by('MONTH(sys_create_date)');
        $this->db->order_by('MONTH(sys_create_date)', 'ASC');
        return $this->db->get();
    }

    public function getDailyReport($month, $year) {
        $this->db->select('count(id) as total, day(sys_create_date) as tgl');
        $this->db->from('m_customer');
        $this->db->where(array('customer_status<>' => 3, 'current_lead_customer_status' => 'C', 'YEAR(sys_create_date)' => $year, 'MONTH(sys_create_date)' => $month));
        $this->db->group_by('sys_create_date');
        $this->db->order_by('sys_create_date', 'ASC');
        return $this->db->get();
    }

}
