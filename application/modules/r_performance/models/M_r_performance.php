<?php

Class M_r_performance extends CI_Model {

    var $table = "t_sales_order";

    public function getListTable($field, $table, $join, $like, $where, $sort, $limit,$where_in) {
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
        $this->db->where_in('m_employee.employee_nip',$where_in);
        if (count($like) > 0) {
            $this->db->like($like);
        }
        $this->db->order_by($sort['sort_field'], $sort['sort_direction']);
        $this->db->limit($limit['limit'], $limit['offset']);
        return $sql = $this->db->get()->result_array();
    }

    public function getYearlyReport($year,$employee) {
        $dt = array();
        for ($i=1;$i<=12;$i++) {
            $query = $this->__getDateYearly($i,$year,$employee);
            $dt[] = (int) $query['total'];
        }
        return $dt;
    }
    
    public function getDailyReport($month,$year,$employee) {
        $dt = array();
        if ($month < 10) {
            $month = '0'.$month;
        }
        for ($i=1;$i<=31;$i++) {
            if($i < 10) {
                $i = '0'.$i;
            }
            $query = $this->__getDateMonthly($i,$month,$year,$employee);
            $dt[] = (int) $query['total'];
        }
        return $dt;
    }
    
    public function __getDateYearly($i,$year,$employee) {
        $this->db->select('count(so_code) as total');
        $this->db->from('t_sales_order');
        $this->db->join('m_employee','m_employee.id=t_sales_order.id_sales','INNER');
        $this->db->where(array('so_status' => 1, 'YEAR(so_date)' => $year, 'MONTH(so_date)' => $i,'m_employee.employee_nip'=>$employee));
        return $this->db->get()->row_array();
    }
    
    public function __getDateMonthly($i,$month,$year,$employee) {
        $this->db->select('count(so_code) as total');
        $this->db->from('t_sales_order');
        $this->db->join('m_employee','m_employee.id=t_sales_order.id_sales','INNER');
        $this->db->where(array('so_status' => 1, 'so_date' => $year.'-'.$month.'-'.$i , 'm_employee.employee_nip'=>$employee));
        return $this->db->get()->row_array();
    }
    
    public function getProductByCode($employee) {
        $this->db->select('id');
        $this->db->from('m_product');
        $this->db->where_in('product_code',$employee);
        return $this->db->get_where();
    }
    
    public function countProduct($data) {
        $this->db->select('SUM(qty) as total');
        $this->db->from('t_sales_order_product');
        $this->db->where(array('id_sales_order'=>$data['so_id'], 'id_product'=>$data['product_id']));
        return $this->db->get();
    }

}