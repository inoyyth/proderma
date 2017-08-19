<?php

Class M_t_sales_delivery extends CI_Model {

    var $table = "t_delivery_order";

    public function save() {
        $id = $this->input->post('id');
        $data = array(
            'id_so' => $this->input->post('id_so'),
            'do_code' => $this->input->post('do_code'),
            'do_date' => $this->input->post('do_date')
        );
        if (empty($id)) {
            $this->db->insert($this->table, $this->main_model->create_sys($data));
            return true;
        } else {
            $this->db->update($this->table, $this->main_model->update_sys($data), array('id' => $id));
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
    
    public function getListTableSo($field,$table,$join,$like,$where,$sort,$limit) {
        $exist_do = $this->db->get_where('t_delivery_order',array('do_status'=>1))->result_array();
        $dt_exist_do = array();
        foreach($exist_do as $k=>$v){
            $dt_exist_do[] = $v['id_so'];
        }

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
        if(count($dt_exist_do) > 0) {
            $this->db->where_not_in('t_sales_order.id',$dt_exist_do);
        }
        if(count($like) > 0) {
            $this->db->like($like);
        }
        $this->db->order_by($sort['sort_field'],$sort['sort_direction']);
        $this->db->limit($limit['limit'],$limit['offset']);
        return $sql = $this->db->get()->result_array();
    }
    
    public function get_detail($id) {
        $this->db->select('t_delivery_order.*,t_sales_order.so_code');
        $this->db->from('t_delivery_order');
        $this->db->join('t_sales_order','t_delivery_order.id_so=t_sales_order.id');
        $this->db->where('t_delivery_order.id',$id);
        return $this->db->get();
    }
    
    public function get_customer($id_so) {
        $this->db->select('
                m_customer.customer_name,
                m_customer.customer_address,
                m_customer.customer_phone,
                m_area.area_name,
                m_employee.employee_name,
                m_subarea.subarea_name');
        $this->db->from('m_customer');
        $this->db->join('t_sales_order','t_sales_order.id_customer=m_customer.id');
        $this->db->join('m_area','m_area.id=m_customer.id_area');
        $this->db->join('m_subarea','m_subarea.id=m_customer.id_subarea');
        $this->db->join('m_employee','m_employee.id=t_sales_order.id_sales');
        $this->db->where('t_sales_order.id',$id_so);
        return $this->db->get();
    }

    public function get_list_product($id) {
        $this->db->select(array("t_sales_order_product.*",
            "m_product.product_code",
            "m_product.product_name",
            "m_product.product_price",
            "sum(t_sales_order_product.qty * m_product.product_price) as SubTotal"));
        $this->db->from('t_sales_order_product');
        $this->db->join('m_product','m_product.id=t_sales_order_product.id_product', 'left');
        $this->db->where(array(
            't_sales_order_product.id_sales_order' => $id,
        ));
        $this->db->group_by(array('t_sales_order_product.id'));
        return $this->db->get();
    }

}
