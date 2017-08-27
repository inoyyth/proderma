<?php

Class M_sales_tracker extends CI_Model {

    public function getLog() {
        $this->db->select('log_sales.*,CONCAT(m_employee.employee_nip,", ",m_employee.employee_name) as employee');
        $this->db->from('log_sales');
        $this->db->join('m_employee','m_employee.id=log_sales.id_sales','INNER');
        return $this->db->get();
    }
}
