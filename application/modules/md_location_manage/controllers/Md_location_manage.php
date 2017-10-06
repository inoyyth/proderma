<?php

class Md_location_manage extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_md_location_manage' => 'm_md_location_manage', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Utility', '/dasboard');
        $this->breadcrumbs->push('Location Manage', '/location-manage');
    }

    public function index() {
        $data = [];
        if (isset($_GET['city']) && isset($_GET['province'])) {
            $this->breadcrumbs->push('District', '#');
            $data['province'] = $this->db->get_where('province', array('province_id' => $_GET['province']))->row_array();
            $data['city'] = $this->db->get_where('city', array('city_id' => $_GET['city']))->row_array();
            $data['view'] = 'md_location_manage/main_district';
        } else if (isset($_GET['province'])) {
            $this->breadcrumbs->push('City', '#');
            $data['province'] = $this->db->get_where('province', array('province_id' => $_GET['province']))->row_array();
            $data['view'] = 'md_location_manage/main_city';
        } else {
            $this->breadcrumbs->push('Province', '#');
            $data['view'] = 'md_location_manage/main_province';
        }
        $this->load->view('default', $data);
    }

    public function getListProvince() {
        $page = ($_POST['page'] == 0 ? 1 : $_POST['page']);
        $limit = $_POST['size'];

        $table = 'province';

        $field = array(
            "province.province_id as id",
            "province_name"
        );

        $offset = ($page - 1) * $limit;

        $join = array();

        $like = array(
            'province.province_name' => isset($_POST['province']) ? $_POST['province'] : ""
        );
        $where = array("province_status"=>1);
        $sort = array(
            'sort_field' => isset($_POST['sort']) ? $_POST['sort'] : "province.province_name",
            'sort_direction' => isset($_POST['sort_dir']) ? $_POST['sort_dir'] : "asc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );

        $list = $this->m_md_location_manage->getListTable($field, $table, $join, $like, $where, $sort, $limit_row);

        $total_records = $this->data_table->count_all($table, $where);
        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $this->data_table->count_all($table, $where),
            "data" => $list,
        );
        //output to json format
        echo json_encode($output);
    }

    public function getListCity($province) {
        $page = ($_POST['page'] == 0 ? 1 : $_POST['page']);
        $limit = $_POST['size'];

        $table = 'city';

        $field = array(
            "city.city_id as id",
            "city.province_id",
            "province.province_name",
            "city.city_name"
        );

        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'province', 'where' => 'province.province_id=city.province_id', 'join' => 'inner'),
        );

        $like = array(
            'city.city_name' => isset($_POST['city']) ? $_POST['city'] : ""
        );
        $where = array("city.province_id" => $province,"city.city_status"=>1);
        $sort = array(
            'sort_field' => isset($_POST['sort']) ? $_POST['sort'] : "city.city_name",
            'sort_direction' => isset($_POST['sort_dir']) ? $_POST['sort_dir'] : "asc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );

        $list = $this->m_md_location_manage->getListTable($field, $table, $join, $like, $where, $sort, $limit_row);

        $total_records = $this->data_table->count_all($table, $where);
        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $this->data_table->count_all($table, $where),
            "data" => $list,
        );
        //output to json format
        echo json_encode($output);
    }
    
    public function getListDistrict($province,$city) {
        $page = ($_POST['page'] == 0 ? 1 : $_POST['page']);
        $limit = $_POST['size'];

        $table = 'district';

        $field = array(
            "district.district_id as id",
            "district.province_id",
            "district.city_id",
            "province.province_name",
            "city.city_name",
            "district.district_name"
        );

        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'province', 'where' => 'province.province_id=district.province_id', 'join' => 'inner'),
            array('table' => 'city', 'where' => 'city.city_id=district.city_id', 'join' => 'inner'),
        );

        $like = array(
            'district.district_name' => isset($_POST['district']) ? $_POST['district'] : ""
        );
        $where = array("district.province_id" => $province,"district.city_id" => $city,"district.district_status"=>1);
        $sort = array(
            'sort_field' => isset($_POST['sort']) ? $_POST['sort'] : "district.district_name",
            'sort_direction' => isset($_POST['sort_dir']) ? $_POST['sort_dir'] : "asc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );

        $list = $this->m_md_location_manage->getListTable($field, $table, $join, $like, $where, $sort, $limit_row);

        $total_records = $this->data_table->count_all($table, $where);
        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $this->data_table->count_all($table, $where),
            "data" => $list,
        );
        //output to json format
        echo json_encode($output);
    }

    public function saveProvince() {
        $data = array('province_id' => $this->input->post('province_id'),
            'province_name' => $this->input->post('province_name')
        );
        return $this->m_md_location_manage->save('province', $data);
    }

    public function saveCity() {
        $data = array('city_id' => $this->input->post('city_id'),
            'city_name' => $this->input->post('city_name'),
            'province_id' => $this->input->post('province_id'),
        );
        return $this->m_md_location_manage->save('city', $data);
    }
    
    public function saveDistrict() {
        $data = array('district_id' => $this->input->post('district_id'),
            'district_name' => $this->input->post('district_name'),
            'province_id' => $this->input->post('province_id'),
            'city_id' => $this->input->post('city_id')
        );
        return $this->m_md_location_manage->save('district', $data);
    }

    public function deleteProvince() {
        $id = $this->input->post('id');
        if ($this->db->update('district', array('district_status'=>2), array('province_id' => $id))) {
            if ($this->db->update('city',array('city_status'=>2), array('province_id' => $id))){
                $this->db->update('province', array('province_status'=>2), array('province_id' => $id));
            }
        }
        return true;
    }
    
    public function deleteCity() {
        $id = $this->input->post('id');
        if ($this->db->update('district', array('district_status'=>2), array('city_id' => $id))) {
            $this->db->update('city',array('city_status'=>2), array('city_id' => $id));
        }
        return true;
    }
    
    public function deleteDistrict() {
        $id = $this->input->post('id');
        $this->db->update('district', array('district_status'=>2), array('district_id' => $id));
        return true;
    }

}
