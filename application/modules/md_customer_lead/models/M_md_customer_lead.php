<?php

Class M_md_customer_lead extends CI_Model {

    var $table = "m_customer";

    public function save() {
        $id = $this->input->post('id');
        $image_hidden = $this->input->post('image_hidden');
        $folder = "md_customer";
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
        
        if ($this->sessionGlobal['super_admin'] == '1') {
            $branch = $this->sessionGlobal['id_branch'];
        } else {
            $branch = $this->input->post('id_branch');
        }
        
        $data = array(
            'customer_code' => $this->input->post('customer_code'),
            'customer_name' => $this->input->post('customer_name'),
            'customer_clinic' => $this->input->post('customer_clinic'),
            'customer_address' => $this->input->post('customer_address'),
            'customer_province' => $this->input->post('customer_province'),
            'customer_city' => $this->input->post('customer_city'),
            'customer_district' => $this->input->post('customer_district'),
            'customer_phone' => $this->input->post('customer_phone'),
            'customer_email' => $this->input->post('customer_email'),
            'customer_latitude' => $this->input->post('customer_latitude'),
            'customer_longitude' => $this->input->post('customer_longitude'),
            //'id_source_lead_customer' => $this->input->post('id_source_lead_customer'),
            //'id_status_lead_customer' => $this->input->post('id_status_lead_customer'),
            'customer_internal_notes' => $this->input->post('customer_internal_notes'),
            'customer_status' => $this->input->post('customer_status'),
            'id_branch' => $branch,
            'current_lead_customer_status' => "L",
            'customer_status' => "1",
            'photo_path' => $image_name,
			'id_area' => $this->input->post('id_area'),
            'id_subarea' => $this->input->post('id_subarea')
        );
        if (empty($id)) {
            $data['customer_code'] = $this->__generateCode($this->input->post('id_subarea'));
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
		if(isset($limit)) {
			$this->db->limit($limit['limit'],$limit['offset']);
		}
        return $sql = $this->db->get()->result_array();
        //echo json_encode($sql);
    }
	
	private function __generateCode($id_subarea) {
        $subarea =  $this->db->get_where('m_subarea',array('id'=>$id_subarea))->row_array();
        
        $getMaxById = $this->__getMaxById($id_subarea)->row_array();
        $expldCode = explode('/',$getMaxById['customer_code']);
        $lastId = (int) end($expldCode);
        $ll = $lastId + 1;
        $fixCode = 'ML/'.$subarea['subarea_code'].'/'.$subarea['subarea_nick_code'].'/'.str_pad(($ll), 3, '0', STR_PAD_LEFT);
        return $fixCode;
    }
    
    private function __getMaxById($id_subarea) {
        $this->db->select('customer_code');
        $this->db->from('m_customer');
        $this->db->where(array('id_subarea'=>$id_subarea,'current_lead_customer_status'=>'L'));
        $this->db->order_by('id','desc');
        $this->db->limit(0,1);
        return $this->db->get();
    }

}
