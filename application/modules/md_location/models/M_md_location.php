<?php

Class M_md_location extends CI_Model {

    public function getProvince() {
        $query = $this->db->select('*')
                ->from('province')
                ->order_by('province_name','ASC')
                ->get();
        return $query;
        }

}
