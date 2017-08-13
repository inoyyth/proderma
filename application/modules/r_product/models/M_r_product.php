<?php

Class M_r_product extends CI_Model {

    var $table = "t_sales_order";

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
        $this->db->select('sum(so_grand_total) as total, month(so_date) as bulan');
        $this->db->from('t_sales_order');
        $this->db->where(array('so_status' => 1, 'YEAR(so_date)' => $year));
        $this->db->group_by('MONTH(so_date)');
        $this->db->order_by('MONTH(so_date)', 'ASC');
        return $this->db->get();
    }
    
    public function getDailyReport($month,$year) {
        $this->db->select('sum(so_grand_total) as total, day(so_date) as tgl');
        $this->db->from('t_sales_order');
        $this->db->where(array('so_status' => 1, 'YEAR(so_date)' => $year, 'MONTH(so_date)' => $month));
        $this->db->group_by('so_date');
        $this->db->order_by('so_date', 'ASC');
        return $this->db->get();
    }

}
