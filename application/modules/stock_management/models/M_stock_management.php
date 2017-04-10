<?php

Class M_stock_management extends CI_Model {

    protected $table = "product_stock";

    public function save($user_id) {
        $id = $this->input->post('id');
        $data = array(
            'product_id' => $this->input->post('product_id'),
            'jumlah' => $this->input->post('jumlah'),
            'add_or_min' => $this->input->post('add_or_min'),
            'tanggal' => $this->input->post('tanggal'),
            'description' => $this->input->post('description')
        );
        $this->db->insert($this->table, $this->main_model->create_sys($data));
        return true;
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
