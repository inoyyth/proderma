<?php

Class M_md_location_manage extends CI_Model {

    public function getProvince() {
        $query = $this->db->select('*')
                ->from('province')
                ->order_by('province_name', 'ASC')
                ->get();
        return $query;
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
    }
    
    public function save($table,$data) {
        if($table == 'province') {
            if($data['province_id'] != null || $data['province_id'] != "") {
                $save = $this->db->update($table,$data,array('province_id'=>$data['province_id']));
                if($save) {
                    return true;
                }
            } else {
                unset($data['province_id']);
                $save = $this->db->insert($table,$data);
                if($save) {
                    return true;
                }
            }
            return false;
        }
        
        if($table == 'city') {
            if($data['city_id'] != null || $data['city_id'] != "") {
                $save = $this->db->update($table,$data,array('city_id'=>$data['city_id']));
                if($save) {
                    return true;
                }
            } else {
                unset($data['city_id']);
                $save = $this->db->insert($table,$data);
                if($save) {
                    return true;
                }
            }
            return false;
        }
        
        if($table == 'district') {
            if($data['district_id'] != null || $data['district_id'] != "") {
                $save = $this->db->update($table,$data,array('district_id'=>$data['district_id']));
                if($save) {
                    return true;
                }
            } else {
                unset($data['district_id']);
                $save = $this->db->insert($table,$data);
                if($save) {
                    return true;
                }
            }
            return false;
        }
        
    }

}
