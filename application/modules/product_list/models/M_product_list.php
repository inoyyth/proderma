<?php

Class M_product_list extends CI_Model {

    var $table = "product_list";

    public function save($user_id) {
        $id = $this->input->post('id');
        $exp_price_range_date = explode('-', $this->input->post('reservation_date'));
        $folder = "product";
        if (!is_dir('./assets/images/' . $folder)) {
            mkdir('./assets/images/' . $folder, 0777, TRUE);
        }
        $image_config = array('upload_path' => './assets/images/' . $folder,
            'upload_url' => './assets/images/' . $folder,
            //'encrypt_name' => true,
            //'detect_mime' => true,
            'allowed_types' => 'gif|jpg|png', 'max_size' => 3000);

        if (!empty($id)) {
            $session = $this->session->userdata('logged_in_admin');
            $get_image = $this->db->get_where($this->table, array('id' => $id, 'user_id' => $session['id']))->row_array();
            $imgArray = unserialize($get_image['product_list_images']);
            if (!empty($imgArray)) {
                $img = $this->multiple_upload($folder, $image_config, $user_id);
                $images = array_merge($imgArray, $img);
            } else {
                $images = $this->multiple_upload($folder, $image_config, $user_id);
            }
        } else {
            $images = $this->multiple_upload($folder, $image_config, $user_id);
        }
        $data = array(
            'user_id' => $user_id,
            'product_category_id' => $this->input->post('product_category_id'),
            'product_brand_id' => $this->input->post('product_brand_id'),
            'product_list_sku' => $this->input->post('product_list_sku'),
            'product_list_name' => $this->input->post('product_list_name'),
            'product_list_description' => $this->input->post('product_list_description'),
            //'product_list_stock' => $this->input->post('product_list_stock'),
            'product_list_unit' => $this->input->post('product_list_unit'),
            'product_list_material' => $this->input->post('product_list_material'),
            'product_list_colour' => $this->input->post('product_list_colour'),
            'product_list_length' => $this->input->post('product_list_length'),
            'product_list_width' => $this->input->post('product_list_width'),
            'product_list_height' => $this->input->post('product_list_height'),
            'product_list_weight' => $this->input->post('product_list_weight'),
            'product_list_normal_price' => $this->input->post('product_list_normal_price'),
            'product_list_special_price' => $this->input->post('product_list_special_price'),
            'product_list_date_start' => trim(str_replace('/', '-', $exp_price_range_date[0])),
            'product_list_date_end' => trim(str_replace('/', '-', $exp_price_range_date[1])),
            'product_list_unit' => $this->input->post('product_list_unit'),
            'product_list_status' => $this->input->post('product_list_status'),
            'product_list_images' => serialize($images)
        );
        if (empty($id)) {
            $insert = $this->db->insert($this->table, $this->main_model->create_sys($data));
            if ($insert) {
                $last_insert = $this->db->insert_id();
                $dataVideo = $this->__setVideoData($last_insert);
                $data_stock = array('product_id'=>$last_insert,'jumlah'=>$this->input->post('product_list_stock'),'add_or_min'=>"1",'description'=>'Add By System');
                $insertStock = $this->db->insert('product_stock',$this->main_model->create_sys($data_stock));
            }
            return true;
        } else {
            $update = $this->db->update($this->table, $this->main_model->update_sys($data), array('id' => $id, 'user_id' => $user_id));
            if ($update) {
                $dataVideo = $this->__setVideoData($id);
            }
            return true;
        }
        return false;
    }

    public function getdata($table, $limit, $pg, $like = array(), $where = array()) {
        unset($like['page']);
        $this->db->select($table . ".id," . $table . ".user_id AS user_id_product," . $table . ".product_list_sku," . $table . ".product_list_stock," . $table . ".product_list_name," . $table . ".product_list_status,product_category.product_category_name,product_category.user_id AS user_product_category,product_brand.product_brand_name,product_brand.user_id AS user_product_brand,sum(case add_or_min when '1' then jumlah when '2' then jumlah * -1 end) as total");
        $this->db->from($table);
        $this->db->join('product_category', 'product_category.id=' . $table . '.product_category_id', 'INNER');
        $this->db->join('product_brand', 'product_brand.id=' . $table . '.product_brand_id', 'INNER');
        $this->db->join('product_stock', 'product_stock.product_id=' . $table . '.id', 'LEFT');
        $this->db->like($like);
        $this->db->where($where);
        $this->db->group_by('product_list.id');
        $this->db->limit($pg, $limit);
        return $this->db->get()->result_array();
    }

    function multiple_upload($upload_dir = 'uploads', $config = array(), $user_id) {
        $this->load->library('upload', $config);

        $images = array();

        foreach ($_FILES['userfile']['name'] as $key => $image) {
            $_FILES['userfile[]']['name'] = $_FILES['userfile']['name'][$key];
            $_FILES['userfile[]']['type'] = $_FILES['userfile']['type'][$key];
            $_FILES['userfile[]']['tmp_name'] = $_FILES['userfile']['tmp_name'][$key];
            $_FILES['userfile[]']['error'] = $_FILES['userfile']['error'][$key];
            $_FILES['userfile[]']['size'] = $_FILES['userfile']['size'][$key];

            $fileName = $user_id . "_" . strtotime(date('Y-m-d H:i:s')) . "_" . $_FILES['userfile']['name'][$key];

            $config['file_name'] = $fileName;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('userfile[]')) {
                $image = $this->upload->data();
                $image_name = 'assets/images/' . $upload_dir . "/" . $image['file_name'];
                //upload to cloudinary
                $this->main_model->upload_image_cloudinary($image_name);
                $images[] = $image['file_name'];
            } else {
                $errors = $this->upload->display_errors();
                var_dump($errors);
                die;
            }
        }

        return $images;
    }

    function __setVideoData($id) {
        if($this->db->delete('product_videos', array('product_id' => $id))){
            $titlevideo = $this->input->post('video_title');
            $urlvideo = $this->input->post('video_url');
            $widthvideo = $this->input->post('video_width');
            $heightvideo = $this->input->post('video_height');
            $showvideo = $this->input->post('video_show');
            $data = array();
            foreach ($urlvideo as $k => $v) {
                $data[] = array(
                    'product_id' => $id,
                    'video_title' => $titlevideo[$k],
                    'video_url' => $urlvideo[$k],
                    'video_width' => $widthvideo[$k],
                    'video_height' => $heightvideo[$k],
                    'video_show' => $showvideo[$k],
                    'sys_create_date' => date('Y-m-d H:i:s')
                );
            }
            $this->db->insert_batch('product_videos', $data);
            return TRUE;
        }
        return FALSE;
    }
    
    public function getstock($id) {
        $this->db->select("sum(case add_or_min when '1' then jumlah when '2' then jumlah * -1 end) as total");
        $this->db->from('product_stock');
        $this->db->join('product_list', 'product_list.id=product_stock.product_id', 'left');
        $this->db->where(array('product_stock.product_id'=>$id));
        $this->db->group_by(array('product_stock.product_id'));
        return $this->db->get()->row_array();
    }

}
