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

}
