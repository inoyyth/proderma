<?php

Class M_r_call extends CI_Model {

    var $table = "sales_visit";

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

    public function getYearlyReport($year,$employee) {
        $pending = array();
        $process = array();
        $complete = array();
        for ($i=1;$i<=12;$i++) {
            $query = $this->__getDateYearly($i,$year,$employee);
            $pending[] = array((int) $query['waiting']);
            $process[] = array((int) $query['process']);
            $complete[] = array((int) $query['complete']);
        }
        $dtx = array('pending'=>$pending,'process'=>$process,'complete'=>$complete);
        $dt = array();
        foreach($dtx as $k=>$v) {
            $dt[] = array('name'=>$k,'data'=>$v);
        }
        return $dt;
    }
    
    public function getDailyReport($month,$year,$employee) {
        $pending = array();
        $process = array();
        $complete = array();
        if ($month < 10) {
            $month = '0'.$month;
        }
        for ($i=1;$i<=31;$i++) {
            if($i < 10) {
                $i = '0'.$i;
            }
            $query = $this->__getDateMonthly($i,$month,$year,$employee);
            $pending[] = array((int) $query['waiting']);
            $process[] = array((int) $query['process']);
            $complete[] = array((int) $query['complete']);
        }
        $dtx = array('pending'=>$pending,'process'=>$process,'complete'=>$complete);
        $dt = array();
        foreach($dtx as $k=>$v) {
            $dt[] = array('name'=>$k,'data'=>$v);
        }
        return $dt;
    }
    
    public function __getDateYearly($i,$year,$employee) {
        //$idEmployee = $this->db->select('id')->from('m_employee')->where(array('employee_nip'=>$employee))->get()->row_array();
        $subQuery = '(select count(*) from sales_visit where sales_visit_progress="WAITING" and id_sales="'.$employee.'") as waiting,';
        $subQuery .= '(select count(*) from sales_visit where sales_visit_progress="PROCESS" and id_sales="'.$employee.'") as process,';
        $subQuery .= '(select count(*) from sales_visit where sales_visit_progress="COMPLETE" and id_sales="'.$employee.'") as complete';
        $this->db->select($subQuery);
        $this->db->from('sales_visit');
        $this->db->join('m_employee','m_employee.id=sales_visit.id_sales','INNER');
        $this->db->where(array('status' => 1, 'YEAR(sales_visit_date)' => $year, 'MONTH(sales_visit_date)' => $i,'sales_visit.id_sales'=>$employee));
        return $this->db->get()->row_array();
    }
    
    public function __getDateMonthly($i,$month,$year,$employee) {
        //$idEmployee = $this->db->select('id')->from('m_employee')->where(array('employee_nip'=>$employee))->get()->row_array();
        $subQuery = '(select count(*) from sales_visit where sales_visit_progress="WAITING" and id_sales="'.$employee.'") as waiting,';
        $subQuery .= '(select count(*) from sales_visit where sales_visit_progress="PROCESS" and id_sales="'.$employee.'") as process,';
        $subQuery .= '(select count(*) from sales_visit where sales_visit_progress="COMPLETE" and id_sales="'.$employee.'") as complete';
        $this->db->select($subQuery);
        $this->db->from('sales_visit');
        $this->db->join('m_employee','m_employee.id=sales_visit.id_sales','INNER');
        $this->db->where(array('status' => 1, 'sales_visit_date' => $year.'-'.$month.'-'.$i , 'sales_visit.id_sales'=>$employee));
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
