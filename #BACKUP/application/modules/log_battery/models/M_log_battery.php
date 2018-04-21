<?php

Class M_log_battery extends CI_Model {

    var $table = "baterai_status";

    public function getData($date,$id_employee) {
        $datex = explode('/',$date);
        $this->db->select("*, DATE_FORMAT(sys_update_date,'%H:%i:%s') TIMEONLY");
        $this->db->from($this->table);
        $this->db->where(
            array(
                'date(sys_update_date)' => $datex[2]."-".$datex[0]."-".$datex[1],
                'id_sales' => $id_employee
            )
        );
        $this->db->order_by('sys_update_date','asc');
        return $this->db->get()->result_array();
    }
    
    public function deltaDelete() {
        $from_date = date("Y-m-d");
        $get_date =  date('Y-m-d', strtotime('-30 days', strtotime($from_date)));
        if ($this->db->delete('baterai_status',array('date(sys_update_date) <='=> $get_date))) {
            return true;
        }
        return false;
    }

    

}
