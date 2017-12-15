<?php

class M_dashboard extends CI_Model {

    public function getCount($table, $where) {
        $this->db->select("count('*') as total");
        $this->db->from($table);
        $this->db->where($where);
        return $this->db->get()->row_array();
    }

    public function getSoTotal() {
        $this->db->select('count(t_sales_order.id) as total');
        $this->db->from('t_sales_order');
        $this->db->join('t_delivery_order', 't_sales_order.id = t_delivery_order.id_so', 'INNER');
        $this->db->join('t_invoice', 't_sales_order.id = t_invoice.id_so', 'INNER');
        $this->db->where(array('t_sales_order.so_status' => 1));
        return $this->db->get()->row_array();
    }
    
    public function getMappingArea(){
        $this->db->select("m_area.area_name as name, count(m_customer.id) as y");
        $this->db->from("m_area");
        $this->db->join('m_customer','m_customer.id_area=m_area.id','INNER');
        $this->db->where(array('m_area.area_status'=>1, 'm_customer.customer_status'=>1));
        $this->db->group_by('m_area.id');
        return $this->db->get()->result_array();
    }

    public function getAllBranch() {
        $this->db->select('*');
        $this->db->from('m_branch');
        $this->db->where('branch_status',"1");
        $this->db->order_by('branch_name','asc');
        return $this->db->get()->result_array();
    }

    function getAllBranchWhere($branch) {
        $this->db->select('*');
        $this->db->from('m_branch');
        $this->db->where('id',$branch);
        $this->db->where('branch_status',"1");
        $this->db->order_by('branch_name','asc');
        return $this->db->get()->row_array();
    }

    public function getYearlyReport($year, $branch) {
        $this->db->select('sum(so_grand_total) as total, month(so_date) as bulan');
        $this->db->from('t_sales_order');
        $this->db->where(array('so_status' => 1, 'YEAR(so_date)' => $year));
        if ($branch != "all") {
            $this->db->where('t_sales_order.id_branch',$branch);
        }
        $this->db->group_by('MONTH(so_date)');
        $this->db->order_by('MONTH(so_date)', 'ASC');
        return $this->db->get();
    }
    
    public function getDailyReport($month, $year, $branch) {
        $this->db->select('sum(so_grand_total) as total, day(so_date) as tgl');
        $this->db->from('t_sales_order');
        $this->db->where(array('so_status' => 1, 'YEAR(so_date)' => $year, 'MONTH(so_date)' => $month));
        if ($branch != "all") {
            $this->db->where('t_sales_order.id_branch',$branch);
        }
        $this->db->group_by('so_date');
        $this->db->order_by('so_date', 'ASC');
        return $this->db->get();
    }

    public function getAchievement($month, $year, $branch) {
        $this->db->select('sum(so_grand_total) as total');
        $this->db->from('t_sales_order');
        $this->db->where(array('so_status' => 1, 'YEAR(so_date)' => $year, 'MONTH(so_date)' => $month));
        if ($branch != "all") {
            $this->db->where('t_sales_order.id_branch',$branch);
        }
        return $this->db->get()->row_array();
    }

}
