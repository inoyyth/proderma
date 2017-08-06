<?php

Class M_t_invoice extends CI_Model {

    var $table = "t_invoice";

    public function save() {
        $id = $this->input->post('id');
        $data = array(
            'invoice_code' => $this->input->post('invoice_code'),
            'id_so' => $this->input->post('id_so'),
            'id_do' => $this->input->post('id_do'),
            'invoice_date' => $this->input->post('invoice_date'),
            'due_date' => ($this->input->post('due_date') !== NULL ? $this->input->post('due_date') : NULL)
        );
        if (empty($id)) {
            if($this->db->insert($this->table, $this->main_model->create_sys($data))) {
                if ($this->input->post('date_status') == "1") {
                    $dt_duedate = array('id_invoice'=>$this->db->insert_id());
                    $this->db->insert('t_pay_duedate',$dt_duedate);
                }
            }
            return true;
        } else {
            $this->db->update($this->table, $this->main_model->update_sys($data), array('id' => $id));
            return true;
        }
        return false;
    }

    public function getListTable($field, $table, $join, $like, $where, $sort, $limit) {
        $this->db->select($field);
        $this->db->from($table);
        if (count($join) > 0) {
            foreach ($join as $kJoin => $vJoin) {
                $this->db->join($vJoin['table'], $vJoin['where'], $vJoin['join']);
            }
        }
        if (count($where) > 0) {
            $this->db->where($where);
        }
        if (count($like) > 0) {
            $this->db->like($like);
        }
        $this->db->order_by($sort['sort_field'], $sort['sort_direction']);
        $this->db->limit($limit['limit'], $limit['offset']);
        return $sql = $this->db->get()->result_array();
    }

    public function getListTableDo($field, $table, $join, $like, $where, $sort, $limit) {
        $exist_do = $this->db->get_where('t_invoice', array('invoice_status' => 1))->result_array();
        $dt_exist_do = array();
        foreach ($exist_do as $k => $v) {
            $dt_exist_do[] = $v['id_do'];
        }

        $this->db->select($field);
        $this->db->from($table);
        if (count($join) > 0) {
            foreach ($join as $kJoin => $vJoin) {
                $this->db->join($vJoin['table'], $vJoin['where'], $vJoin['join']);
            }
        }
        if (count($where) > 0) {
            $this->db->where($where);
        }
        if (count($dt_exist_do) > 0) {
            $this->db->where_not_in('t_delivery_order.id', $dt_exist_do);
        }
        if (count($like) > 0) {
            $this->db->like($like);
        }
        $this->db->order_by($sort['sort_field'], $sort['sort_direction']);
        $this->db->limit($limit['limit'], $limit['offset']);
        return $sql = $this->db->get()->result_array();
    }

    public function get_detail($id) {
        $this->db->select('t_invoice.*,t_delivery_order.do_code');
        $this->db->from('t_invoice');
        $this->db->join('t_delivery_order', 't_invoice.id_do=t_delivery_order.id');
        $this->db->where('t_invoice.id', $id);
        return $this->db->get();
    }

}
