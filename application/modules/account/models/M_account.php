<?php

Class M_account extends CI_Model {

    var $table = "account";

    public function save() {
        //var_dump($this->input->post('menu'));die;
        $menu = array();
        foreach($this->input->post('menu') as $k=>$v){
            $explodeMenu = explode("|", $v);
            $menu[] = array(
                        'menu'=>$explodeMenu[0],
                        'slug'=>$explodeMenu[1],
                        'child'=>array(
                            'add'=>($this->input->post('sub_add'.$explodeMenu[0])==""?0:1),
                            'upd'=>($this->input->post('sub_upd'.$explodeMenu[0])==""?0:1),
                            'del'=>($this->input->post('sub_del'.$explodeMenu[0])==""?0:1),
                            'prt'=>($this->input->post('sub_prt'.$explodeMenu[0])==""?0:1)
                        )
                ); 
        }

        $id = $this->input->post('id');
        $image_hidden = $this->input->post('image_hidden');
        $folder = "account";
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
                    redirect("user-management-tambah");
                }
            }
        }
        $data = array('username' => $this->input->post('username'),
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'password' => $this->encrypt->encode($this->input->post('password')),
            'no_telp' => $this->input->post('no_telp'),
            'email' => $this->input->post('email'),
            'path_foto' => $image_name,
            'status' => $this->input->post('status'),
            'access_menu' => serialize($menu),
            'token' => bin2hex(openssl_random_pseudo_bytes(16)),
            'super_admin'=> ($this->input->post('super_admin') != null ? $this->input->post('super_admin') : '1')
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
    
    public function save_profile() {
        $id = $this->input->post('id');
        $image_hidden = $this->input->post('image_hidden');
        $folder = "account";
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
                    redirect("user-management-tambah");
                }
            }
        }
        $data = array(
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'password' => $this->encrypt->encode($this->input->post('password')),
            'no_telp' => $this->input->post('no_telp'),
            'email' => $this->input->post('email'),
            'path_foto' => $image_name,
            'token' => bin2hex(openssl_random_pseudo_bytes(16))
        );
        
        $this->db->update($this->table, $this->main_model->update_sys($data), array('id' => $id));
        return true;
    }

    public function getdata($table, $limit, $pg, $like = array()) {
        unset($like['page']);
        $this->db->select("*");
        $this->db->from($table);
        $this->db->like($like);
        $this->db->limit($pg, $limit);
        return $this->db->get()->result_array();
    }

    public function get_active_menu() {
        $this->db->select('*');
        $this->db->from('menus');
        $this->db->where(array('status =' => 1, 'parent !=' => null));
        $this->db->order_by('parent', 'ASC');
        $this->db->order_by('number', 'ASC');
        return $this->db->get()->result_array();
    }
    
    public function getListTable($table,$join,$like,$where,$sort,$limit) {
        $this->db->select("*,IF(status=1,'Active','Not Active') AS status_account");
        $this->db->from($table);
        if(count($join) > 0) {
            $this->db->join($join);
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

}
