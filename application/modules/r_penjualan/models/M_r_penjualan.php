<?php

Class M_r_penjualan extends CI_Model {

    var $table = "t_sales_order";

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

    public function getYearlyReport($year, $branch) {
        $this->db->select('count(id) as total, month(so_date) as bulan');
        $this->db->from('t_sales_order');
        $this->db->where(array('so_status' => 1, 'YEAR(so_date)' => $year));
        if ($branch != "all") {
            $this->db->where('t_sales_order.id_branch',$branch);
        }
        $this->db->group_by('MONTH(so_date)');
        $this->db->order_by('MONTH(so_date)', 'ASC');
        return $this->db->get();
    }
    
    public function getDailyReport($month,$year, $branch) {
        $this->db->select('count(id) as total, day(so_date) as tgl');
        $this->db->from('t_sales_order');
        $this->db->where(array('so_status' => 1, 'YEAR(so_date)' => $year, 'MONTH(so_date)' => $month));
        if ($branch != "all") {
            $this->db->where('t_sales_order.id_branch',$branch);
        }
        $this->db->group_by('so_date');
        $this->db->order_by('so_date', 'ASC');
        return $this->db->get();
    }

}
