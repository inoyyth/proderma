<?php

Class M_md_product extends CI_Model {

    var $table = "m_product";

    public function save() {
        $id = $this->input->post('id');
        $image_hidden = $this->input->post('image_hidden');
        $folder = "md_product";
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
                    redirect("master-product-add");
                }
             }
        }
        
        if ($this->sessionGlobal['super_admin'] == '1') {
            $branch = $this->sessionGlobal['id_branch'];
        } else {
            $branch = 0;
        }
        
        $data = array(
            'id_product_category' => $this->input->post('id_product_category'),
            'product_code' => $this->input->post('product_code'),
            'product_name' => $this->input->post('product_name'),
            'product_price' => $this->input->post('product_price'),
            'product_status' => $this->input->post('product_status'),
            'id_product_sub_category' => $this->input->post('id_product_sub_category'),
            'id_group_product' => $this->input->post('id_group_product'),
            'klasifikasi' => $this->input->post('klasifikasi'),
            'komposisi' => $this->input->post('komposisi'),
            'sediaan' => $this->input->post('sediaan'),
            'photo_path' => $image_name,
            'id_branch' => $branch
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
        //echo json_encode($sql);
    }
    
    public function edit_data($table, $where) {
        $this->db->select($table.'.*,m_product_sub_category.sub_category_name');
        $this->db->from($table);
        $this->db->join('m_product_sub_category',$table.'.id_product_sub_category=m_product_sub_category.id', 'left');
        $this->db->where($where);
        return $this->db->get();
    }

}
