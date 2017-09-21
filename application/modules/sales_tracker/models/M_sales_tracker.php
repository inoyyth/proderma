<?php

Class M_sales_tracker extends CI_Model {

    public function getLog() {
        $this->db->select('log_sales.*,CONCAT(m_employee.employee_nip,", ",m_employee.employee_name) as employee');
        $this->db->from('log_sales');
        $this->db->join('m_employee','m_employee.id=log_sales.id_sales','INNER');
		if($this->sessionGlobal['super_admin'] == "1") {
            $this->db->where('m_employee.id_branch',$this->sessionGlobal['id_branch']);
        }
        return $this->db->get();
    }
}
