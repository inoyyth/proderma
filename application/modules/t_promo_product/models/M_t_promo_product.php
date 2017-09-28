<?php

Class M_t_promo_product extends CI_Model {

        var $table = "m_promo_product";

    public function save() {
        $id = $this->input->post('id');
        $image_hidden = $this->input->post('file_hidden');
        $folder = "promo_product";
        if (!is_dir('./assets/images/' . $folder)) {
            mkdir('./assets/images/' . $folder, 0777, TRUE);
        }
        $image_config = array('upload_path' => './assets/images/' . $folder,
            'upload_url' => './assets/images/' . $folder,
            'encrypt_name' => true,
            'detect_mime' => true,
            'allowed_types' => 'pdf');
        $this->upload->initialize($image_config);
        if ($this->upload->do_upload('promo_file')) {
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
                    redirect("promo-product-add");
                }
             }
        }
        $data = array(
            'promo_name' => $this->input->post('promo_name'),
            'promo_description' => $this->input->post('promo_description'),
            'promo_file' => $image_name,
            'promo_start_date' => $this->input->post('promo_start_date'),
            'promo_end_date' => $this->input->post('promo_end_date'),
            'promo_status' => $this->input->post('promo_status'),
            'id_branch' => $this->input->post('branch_list'),
            'promo_type' => $this->input->post('promo_type')
        );
        if (empty($id)) {
            $data['promo_code'] = $this->__getPromoCode($this->input->post('promo_type'));
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
		if ($limit) {
			$this->db->limit($limit['limit'],$limit['offset']);
		}
        return $sql = $this->db->get()->result_array();
    }
    
    public function __getPromoCode($promoType) {
        $getMaxById = $this->__getMaxById()->row_array();
        $expldCode = explode('/',$getMaxById['promo_code']);
        $lastId = (int) end($expldCode);
        $ll = $lastId + 1;
        $fixCode = 'PRM/'. $promoType . '/' . romanic_number(date('m')) . '/' . substr(date('Y'),2,2).'/'.str_pad(($ll), 4, '0', STR_PAD_LEFT);
        return $fixCode;
    }
    
    private function __getMaxById() {
        $this->db->select('promo_code');
        $this->db->from('m_promo_product');
        $this->db->order_by('id','desc');
        $this->db->limit(0,1);
        return $this->db->get();
    }

}
