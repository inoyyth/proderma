<?php

Class M_t_pay_duedate extends CI_Model {

    var $table = "t_pay_duedate";

    public function save() {
        $id = $this->input->post('id');
        $session = $this->session->userdata('logged_in_admin');
        $data = array(
            'pay_duedate_status' => $this->input->post('pay_duedate_status'),
            'pay_duedate_description' => $this->input->post('pay_duedate_description'),
            'pay_date' => $this->input->post('pay_date'),
            'pay_duedate_update_date' => date('Y-m-d H:i:s'),
            'pay_duedate_update_user' => $session['id']
        );
        if (empty($id)) {
            //$this->db->insert($this->table, $this->main_model->create_sys($data));
            return true;
        } else {
            $this->db->update($this->table, $data, array('id' => $id));
            return true;
        }
        return false;
    }
    
    public function getListTable($field,$table,$join,$like,$where,$sort,$limit) {
        $this->db->select($field);
        $this->db->from($table);
        if(count($join) > 0) {
           foreach($join as $kJoin=>$vJoin){
                $this->db->join($vJoin['table'],$vJoin['where'],$vJoin['join']);
            }
        }
        if(count($where) > 0) {
            $this->db->where($where);
        }
        if(count($like) > 0) {
            $this->db->like($like);
        }
        $this->db->order_by($sort['sort_field'],$sort['sort_direction']);
        $this->db->limit($limit['limit'],$limit['offset']);
        return $sql = $this->db->get()->result_array();
    }
    
    public function getDetail($table,$where) {
        $this->db->select($table.'.*,t_sales_order.so_code,t_delivery_order.do_code,t_invoice.invoice_code');
        $this->db->from($table);
        $this->db->join('t_invoice','t_invoice.id='.$table.'.id_invoice');
        $this->db->join('t_delivery_order','t_delivery_order.id=t_invoice.id_do');
        $this->db->join('t_sales_order','t_sales_order.id=t_delivery_order.id_so');
        $this->db->where($where);
        return $this->db->get();
    }

}
