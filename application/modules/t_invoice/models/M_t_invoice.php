<?php

Class M_t_invoice extends CI_Model {

    var $table = "t_invoice";

    public function save() {
        $id = $this->input->post('id');
        $data = array(
            'id_so' => $this->input->post('id_so'),
            'id_do' => $this->input->post('id_do'),
            'invoice_date' => $this->input->post('invoice_date'),
			'no_faktur' => $this->input->post('no_faktur'),
            'due_date' => ($this->input->post('due_date') !== NULL ? $this->input->post('due_date') : NULL)
        );
        if (empty($id)) {
            $data['invoice_code'] = $this->__generate_code($this->input->post('id_so'));
            if($this->db->insert($this->table, $this->main_model->create_sys($data))) {
                if ($this->input->post('date_status') == "1") {
                    $dt_duedate = array('id_invoice'=>$this->db->insert_id(),'create_date'=>date('Y-m-d'));
                    $this->db->insert('t_pay_duedate',$dt_duedate);
                }
            }
            return true;
        } else {
            $this->db->update($this->table, $this->main_model->update_sys($data), array('id' => $id));
            return true;
        }
        return false;
    }

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
        if ($limit) {
			$this->db->limit($limit['limit'],$limit['offset']);
		}
        return $sql = $this->db->get()->result_array();
    }

    public function getListTableDo($field, $table, $join, $like, $where, $sort, $limit) {
        $exist_do = $this->db->get_where('t_invoice', array('invoice_status' => 1))->result_array();
        $dt_exist_do = array();
        foreach ($exist_do as $k => $v) {
            $dt_exist_do[] = $v['id_do'];
        }

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
        if (count($dt_exist_do) > 0) {
            $this->db->where_not_in('t_delivery_order.id', $dt_exist_do);
        }
        if (count($like) > 0) {
            $this->db->like($like);
        }
        $this->db->order_by($sort['sort_field'], $sort['sort_direction']);
        if ($limit) {
			$this->db->limit($limit['limit'],$limit['offset']);
		}
        return $sql = $this->db->get()->result_array();
    }

    public function get_detail($id) {
        $this->db->select('t_invoice.*,t_delivery_order.do_code,t_sales_order.id,t_sales_order.so_payment_term');
        $this->db->from('t_invoice');
        $this->db->join('t_delivery_order', 't_invoice.id_do=t_delivery_order.id');
        $this->db->join('t_sales_order', 't_invoice.id_so=t_sales_order.id');
        $this->db->where('t_invoice.id', $id);
        return $this->db->get();
    }
    
    public function get_detail_product($id) {
        $table = 't_sales_order_product';
        $this->db->select('count(t_sales_order_product.id) AS total_type, sum(t_sales_order_product.qty) AS total_item, sum(t_sales_order_product.qty * m_product.product_price) AS grand_total');
        $this->db->from($table);
        $this->db->join('m_product','m_product.id='.$table.'.id_product','INNER');
        $this->db->where(array($table.'.id_sales_order'=>$id));
        return $this->db->get();
    }
    
    public function get_detail_so($id) {
        $table = 't_sales_order';
        $this->db->select($table.'.*,'
                          . 'm_customer.customer_code,'
                          . 'm_customer.customer_name,'
                          . 'm_customer.customer_address,'
                          . 'm_customer.customer_phone,'
                          . 'm_employee.employee_nip,'
                          . 'm_employee.employee_name,'
                          . 'm_employee.photo_path,'
                          . 'm_employee.employee_email,'
                          . 'm_employee.employee_phone,'
                          . 'm_payment_type.payment_type,'
                          . 't_invoice.id as id_invoice,'
                          . 't_invoice.invoice_code,'
						  . 't_invoice.no_faktur,'
                          . 't_invoice.invoice_date,'
                          . 't_delivery_order.do_code,'
                          . 't_delivery_order.do_date'
                );
        $this->db->from($table);
        $this->db->join('m_customer','m_customer.id='.$table.'.id_customer','INNER');
        $this->db->join('m_employee','m_employee.id='.$table.'.id_sales','INNER');
        $this->db->join('m_payment_type','m_payment_type.id='.$table.'.so_payment_term','INNER');
        $this->db->join('t_delivery_order','t_delivery_order.id_so='.$table.'.id','INNER');
        $this->db->join('t_invoice','t_invoice.id_so='.$table.'.id','INNER');
        $this->db->where(array($table.'.id'=>$id));
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
    
    public function __generate_code($id_so) {
        $customer = $this->db->get_where('t_sales_order',array('id'=>$id_so))->row_array();
        $cust_area = $this->db->get_where('m_customer',array('id'=>$customer['id_customer']))->row_array();
        $area =  $this->db->get_where('m_area',array('id'=>$cust_area['id_area']))->row_array();
        
        $getMaxById = $this->__getMaxById($area['area_code'],$area['area_nick_code'])->row_array();
        $expldCode = explode('/',$getMaxById['so_code']);
        $lastId = (int) end($expldCode);
        $ll = $lastId + 1;
        $fixCode = 'INV/CRM/'.$area['area_nick_code'].$area['area_code'] . '/' .romanic_number(date('m')) . '/' . substr(date('Y'),2,2).'/'.str_pad(($ll), 4, '0', STR_PAD_LEFT);
        return $fixCode;
    }
    
    private function __getMaxById($id_area,$area_nick) {
        $this->db->select('invoice_code');
        $this->db->from('t_invoice');
        $this->db->like(array('invoice_code'=>$area_nick.$id_area));
        $this->db->order_by('id','desc');
        $this->db->limit(0,1);
        return $this->db->get();
    }

}
