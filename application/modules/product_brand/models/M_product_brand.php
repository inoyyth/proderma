<?php

Class M_product_brand extends CI_Model {

    var $table = "product_brand";

    public function save($user_id) {
        $id = $this->input->post('id');
        $image_name = $this->upload_cloudinary->upload_image_cloudinary('product_brand');
        $data = array(
            'user_id'=>$user_id,
            'product_brand_code' => $this->input->post('product_brand_code'),
            'product_brand_name' => $this->input->post('product_brand_name'),
            'product_brand_description' => $this->input->post('product_brand_description'),
            'path_foto' => $image_name,
            'product_brand_status' => $this->input->post('product_brand_status')
        );
        if (empty($id)) {
            $this->db->insert($this->table, $this->main_model->create_sys($data));
            return true;
        } else {
            $this->db->update($this->table, $this->main_model->update_sys($data), array('id' => $id,'user_id'=>$user_id));
            return true;
        }
        return false;
    }

    public function getdata($table, $limit, $pg, $like = array(), $where = array()) {
        unset($like['page']);
        $this->db->select("*");
        $this->db->from($table);
        $this->db->like($like);
        $this->db->where($where);
        $this->db->limit($pg, $limit);
        return $this->db->get()->result_array();
    }

}
