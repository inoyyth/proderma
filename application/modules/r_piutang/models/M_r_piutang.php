<?php

Class M_r_piutang extends CI_Model {

    var $table = "t_invoice";

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
        $this->db->select('count(id) as total, month(create_date) as bulan');
        $this->db->from('t_pay_duedate');
        $this->db->where(array('YEAR(create_date)' => $year));
        $this->db->group_by('MONTH(create_date)');
        $this->db->order_by('MONTH(create_date)', 'ASC');
        return $this->db->get();
    }
    
    public function getDailyReport($month,$year) {
        $this->db->select('count(id) as total, day(create_date) as tgl');
        $this->db->from('t_pay_duedate');
        $this->db->where(array('YEAR(create_date)' => $year, 'MONTH(create_date)' => $month));
        $this->db->group_by('create_date');
        $this->db->order_by('create_date', 'ASC');
        return $this->db->get();
    }

}
