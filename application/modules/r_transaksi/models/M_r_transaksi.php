<?php

Class M_r_transaksi extends CI_Model {

    var $table = "t_sales_order";

    public function save() {
        $id = $this->input->post('id');
        $image_hidden = $this->input->post('image_hidden');
        $folder = "md_employee";
        if (!is_dir('./assets/images/' . $folder)) {
            mkdir('./assets/images/' . $folder, 0777, TRUE);
        }
        $image_config = array('upload_path' => './assets/images/' . $folder,
            'upload_url' => './assets/images/' . $folder,
            'encrypt_name' => true,
            'detect_mime' => true,
            'allowed_types' => 'gif|jpg|png', 'max_size' => 30000);
        $this->upload->initialize($image_config);
        if ($this->upload->do_upload('path_foto')) {
            $image = $this->upload->data();
            $image_name = 'assets/images/' . $folder ."/". $image['file_name'];
        } else {
            if (isset($image_hidden) && !empty($image_hidden)) {
                $image_name = $image_hidden;
            } else {
                $error = array('error' => $this->upload->display_errors());
                if(strpos($error['error'],"You did not select a file to upload.")==true){
                    $image_name = 'assets/images/' . $folder . '/user_icon.png';
                }else{
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect("master-employee-tambah");
                }
             }
        }
        $data = array(
            'id_jabatan' => $this->input->post('id_jabatan'),
            'employee_nip' => $this->input->post('employee_nip'),
            'employee_name' => $this->input->post('employee_name'),
            'employee_email' => $this->input->post('employee_email'),
            'employee_phone' => $this->input->post('employee_phone'),
            'employee_gender' => $this->input->post('employee_gender'),
            'employee_status' => $this->input->post('employee_status'),
            'photo_path' => $image_name
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
    
    public function getListTable($field,$table,$join,$like,$where,$sort,$limit,$groupby=array()) {
        $this->db->select($field);
        $this->db->from($table);
        if(count($join) > 0) {
           foreach($join as $kJoin=>$vJoin){
                $this->db->join($vJoin['table'],$vJoin['where'],$vJoin['join']);
            }
        }
        if(count($where) > 0) {
            $this->db->where(array_filter($where));
        }
        if(count($like) > 0) {
            $this->db->like(array_filter($like));
        }
        if(count($groupby) > 0) {
            $this->db->group_by(array_filter($groupby));
        }
        $this->db->order_by($sort['sort_field'],$sort['sort_direction']);
        $this->db->limit($limit['limit'],$limit['offset']);
        return $sql = $this->db->get()->result_array();
        //echo json_encode($sql);
    }
    
    public function get_detail($id) {
        $table = $this->table;
        $this->db->select($table.'.*,'
                          . 'm_customer.customer_code,'
                          . 'm_customer.customer_name,'
                          . 'm_customer.customer_address,'
                          . 'm_customer.customer_phone,'
                          . 'm_area.area_name,'
                          . 'm_subarea.subarea_name,'
                          . 'm_employee.employee_nip,'
                          . 'm_employee.employee_name,'
                          . 'm_employee.photo_path,'
                          . 'm_employee.employee_email,'
                          . 'm_employee.employee_phone,'
                          . 'm_payment_type.payment_type'
                );
        $this->db->from($table);
        $this->db->join('m_customer','m_customer.id='.$table.'.id_customer','INNER');
        $this->db->join('m_employee','m_employee.id='.$table.'.id_sales','INNER');
        $this->db->join('m_payment_type','m_payment_type.id='.$table.'.so_payment_term','INNER');
        $this->db->join('m_area','m_area.id=m_customer.id_area','INNER');
        $this->db->join('m_subarea','m_subarea.id=m_customer.id_subarea','INNER');
        $this->db->where(array($table.'.id'=>$id));
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
