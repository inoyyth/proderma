<?php

Class M_product_category extends CI_Model {

    var $table = "product_category";

    public function save($user_id) {
        $id = $this->input->post('id');
        $data = array(
            'user_id'=>$user_id,
            'product_category_code' => $this->input->post('product_category_code'),
            'product_category_name' => $this->input->post('product_category_name'),
            'product_category_description' => $this->input->post('product_category_description'),
            'product_category_status' => $this->input->post('product_category_status')
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