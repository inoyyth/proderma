<?php

class Md_customer_lead_priority extends MX_Controller {

    var $table = "m_customer";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_md_customer_lead_priority' => 'm_md_customer_priority', 'Datatable_model' => 'data_table', 'Main_model'=>'main_model'));
        $this->load->library(array('upload', 'encrypt', 'Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Activity', '/dasboard');
        $this->breadcrumbs->push('Lead Customer Priority', '/lead-customer-priority');
    }

    public function index() {
        $data['template_title'] = array('Lead Customer Priority', 'List');
        $data['source_lead_customer'] = $this->db->get_where('source_lead_customer',array('source_lead_customer_status'=>'1'))->result_array();
        $data['status_lead_customer'] = $this->db->get_where('status_lead_customer',array('status_lead_customer_status'=>'1'))->result_array();
        $data['view'] = 'md_customer_lead_priority/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_customer'; 
        
        $field = array(
            "m_customer.*",
            "source_lead_customer.source_lead_customer",
            "status_lead_customer.status_lead_customer",
            "province.province_name",
            "city.city_name",
            "district.district_name",
            "IF(m_customer.customer_status=1,'Active','Not Active') AS status"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'source_lead_customer', 'where' => 'source_lead_customer.id=m_customer.id_source_lead_customer', 'join' => 'left'),
            array('table' => 'status_lead_customer', 'where' => 'status_lead_customer.id=m_customer.id_status_lead_customer', 'join' => 'left'),
            array('table' => 'province', 'where' => 'province.province_id=m_customer.customer_province', 'join' => 'left'),
            array('table' => 'city', 'where' => 'city.city_id=m_customer.customer_city', 'join' => 'left'),
            array('table' => 'district', 'where' => 'district.district_id=m_customer.customer_district', 'join' => 'left')
        );
        
        $like = array(
            'm_customer.customer_code'=>isset($_POST['code'])?$_POST['code']:"",
            'm_customer.customer_name'=>isset($_POST['name'])?$_POST['name']:"",
            'm_customer.customer_clinic'=>isset($_POST['clinic'])?$_POST['clinic']:"",
            'm_customer.customer_address'=>isset($_POST['address'])?$_POST['address']:"",
            'm_customer.customer_district'=>isset($_POST['district'])?$_POST['district']:""
        );
        $array_status = array('m_customer.customer_as_priority'=>"true",'m_customer.customer_status !=' => '3','m_customer.current_lead_customer_status'=>'L');
        $array_province = array();
        $array_city = array();
        $array_district = array();
        $array_source_lead = array();
        $array_status_lead = array();
        
        if(isset($_POST['province']) && $_POST['province'] != "") {
            $array_province = array('m_customer.customer_province'=>$_POST['province']);
        }
        if(isset($_POST['city']) && $_POST['city'] != "") {
            $array_city = array('m_customer.customer_city'=>$_POST['city']);
        }
        if(isset($_POST['district']) && $_POST['district'] != "") {
            $array_district = array('m_customer.customer_district'=>$_POST['district']);
        }
        if(isset($_POST['source_lead']) && $_POST['source_lead'] != "") {
            $array_source_lead = array('m_customer.id_source_lead_customer'=>$_POST['source_lead']);
        }
        if(isset($_POST['status_lead']) && $_POST['status_lead'] != "") {
            $array_status_lead = array('m_customer.id_status_lead_customer'=>$_POST['status_lead']);
        }
        
        $where = array_merge_recursive($array_status,$array_province,$array_city,$array_district,$array_source_lead,$array_status_lead);
        if($this->sessionGlobal['super_admin'] == "1") {
            $where['m_customer.id_branch'] = $this->sessionGlobal['id_branch'];
        }
        
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_customer.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_md_customer_priority->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

        $total_records = count($this->m_md_customer_priority->getListTable($field,$table, $join, $like, $where, $sort, false));
        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => ($total_pages==0?1:$total_pages),
            "recordsTotal" => $total_records,
            "data" => $list,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id) {
        $this->breadcrumbs->push('Edit', '/lead-customer-edit');
        $data['province'] = $this->db->get('province')->result_array();
        $data['source_lead_customer'] = $this->db->get_where('source_lead_customer',array('source_lead_customer_status'=>1))->result_array();
        $data['status_lead_customer'] = $this->db->get_where('status_lead_customer',array('status_lead_customer_status'=>1))->result_array();
        $data['data'] = $this->db->get_where($this->table, array('id' => $id))->row_array();
        $data['view'] = 'md_customer_lead_priority/edit';
        $this->load->view('default', $data);
    }

    function save() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_md_customer_priority->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("lead-customer");
        } else {
            show_404();
        }
    }
    
    public function getProvinceList() {
        $q = $this->input->get('query');
        $where = array();
        $like = array('province_name'=>$q);
        $result = $this->main_model->getTypeaheadList('province',$like,$where);
        echo json_encode($result);
    }
    
    public function getCityList() {
        $where = array();
        if($this->input->get('id') != null){
            $where = array('province_id'=>$this->input->get('id'));
        }
        $like = array();
        if($this->input->get('query') != null){
            $like = array('city_name'=>$this->input->get('query'));
        }
        $result = $this->main_model->getTypeaheadList('city',$like,$where);
        echo json_encode($result);
    }
    
    public function getDistrictList() {
        $where = array();
        if($this->input->get('id') != null){
            $where = array('city_id'=>$this->input->get('id'));
        }
        $like = array();
        if($this->input->get('query') != null){
            $like = array('district_name'=>$this->input->get('query'));
        }
        $result = $this->main_model->getTypeaheadList('district',$like,$where);
        echo json_encode($result);
    }

    public function print_pdf() {
        $data['template'] = array("template" => "md_customer/" . $_GET['template'], "filename" => $_GET['name']);
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->printpdf->create_pdf($data);
    }

    public function print_excel() {
		$table = 'm_customer'; 
        $field = array(
            "m_customer.*",
            "source_lead_customer.source_lead_customer",
            "status_lead_customer.status_lead_customer",
            "province.province_name",
            "city.city_name",
            "district.district_name",
            "IF(m_customer.customer_status=1,'Active','Not Active') AS status"
        );
        $join = array(
            array('table' => 'source_lead_customer', 'where' => 'source_lead_customer.id=m_customer.id_source_lead_customer', 'join' => 'left'),
            array('table' => 'status_lead_customer', 'where' => 'status_lead_customer.id=m_customer.id_status_lead_customer', 'join' => 'left'),
            array('table' => 'province', 'where' => 'province.province_id=m_customer.customer_province', 'join' => 'left'),
            array('table' => 'city', 'where' => 'city.city_id=m_customer.customer_city', 'join' => 'left'),
            array('table' => 'district', 'where' => 'district.district_id=m_customer.customer_district', 'join' => 'left')
        );
		$like = array();
		$where = array('m_customer.customer_as_priority'=>"true",'m_customer.customer_status !=' => '3','m_customer.current_lead_customer_status'=>'L');
		if($this->sessionGlobal['super_admin'] == "1") {
            $where['m_customer.id_branch'] = $this->sessionGlobal['id_branch'];
        }
        
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_customer.customer_name",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"asc"
        );
		
        $data['list'] = $this->m_md_customer_priority->getListTable($field,$table, $join, $like, $where, $sort, false);
        $data['template_excel'] = "md_customer_lead_priority/table_excel";
        $data['file_name'] = "master_lead_priority";
        $this->load->view('template_excel', $data);
    }

}
