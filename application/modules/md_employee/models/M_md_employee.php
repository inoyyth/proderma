<?php

Class M_md_employee extends CI_Model {

    var $table = "m_employee";

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
            if($this->input->post('id_jabatan') == 1) {
                $data['sales_password'] = $this->encrypt->encode(1234);
            }
            $this->db->insert($this->table, $this->main_model->create_sys($data));
            return true;
        } else {
            if($this->input->post('id_jabatan') == 1) {
                $data['sales_password'] =  md5($this->input->post('sales_password'));
            }
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
    
    public function getPassEmployee($id) {
        $this->db->select('sales_password');
        $this->db->from('m_employee');
        $this->db->where(array('id'=>$id));
        $dt = $this->db->get();
        if($dt->num_rows() == 1){
            return $dt;
        } else {
            return false;
        }
    }

}
