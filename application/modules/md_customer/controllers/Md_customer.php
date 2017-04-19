<?php

class Md_customer extends MX_Controller {

    var $table = "m_customer";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_md_customer' => 'm_md_customer', 'Datatable_model' => 'data_table', 'Main_model'=>'main_model'));
        $this->load->library(array('upload', 'encrypt', 'Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Customer', '/customer');
    }

    public function index() {
        $data['template_title'] = array('Customer', 'List');
        $data['source_lead'] = $this->db->get_where('source_lead_customer',array('source_lead_customer_status'=>'1'))->result_array();
        $data['status_lead'] = $this->db->get_where('status_lead_customer',array('status_lead_customer_status'=>'1'))->result_array();
        $data['view'] = 'md_customer/main';
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
            "IF(m_customer.customer_status=1,'Active','Not Active') AS status"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'source_lead_customer', 'where' => 'source_lead_customer.id=m_customer.id_source_lead_customer', 'join' => 'left'),
            array('table' => 'status_lead_customer', 'where' => 'status_lead_customer.id=m_customer.id_status_lead_customer', 'join' => 'left')
        );
        
        $like = array(
            'source_lead_customer.source_lead_customer'=>isset($_POST['source_lead'])?$_POST['source_lead']:"",
            'status_lead_customer.status_lead_customer'=>isset($_POST['status_lead'])?$_POST['status_lead']:"",
            'm_customer.customer_code'=>isset($_POST['code'])?$_POST['code']:"",
            'm_customer.customer_name'=>isset($_POST['name'])?$_POST['name']:"",
            'm_customer.customer_clinic'=>isset($_POST['clinic'])?$_POST['clinic']:"",
            'm_customer.customer_address'=>isset($_POST['address'])?$_POST['address']:"",
            'm_customer.customer_city'=>isset($_POST['city'])?$_POST['city']:"",
            'm_customer.customer_district'=>isset($_POST['district'])?$_POST['district']:""
        );
        $array_status = array('m_customer.customer_status !=' => '3');
        $array_province = array();
        $array_city = array();
        $array_district = array();
        
        if(isset($_POST['province'])) {
            $array_province = array('m_customer.customer_province'=>$_POST['province']);
        }
        if(isset($_POST['city'])) {
            $array_city = array('m_customer.customer_city'=>$_POST['city']);
        }
        if(isset($_POST['district'])) {
            $array_district = array('m_customer.customer_district'=>$_POST['district']);
        }
        
        $where = array_merge_recursive($array_status,$array_province,$array_city,$array_district);
        
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_customer.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_md_customer->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

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

    public function add() {
        $this->breadcrumbs->push('Add', '/customer-add');
        $data['group'] = $this->db->get_where('group_customer_product',array('group_customer_product_status'=>1))->result_array();
        $data['view'] = "md_customer/add";
        $this->load->view('default', $data);
    }

    public function edit($id) {
        $this->breadcrumbs->push('Edit', '/customer-edit');
        $data['jabatan'] = $this->db->get_where('m_jabatan',array('jabatan_status'=>1))->result_array();
        $data['data'] = $this->db->get_where($this->table, array('id' => $id))->row_array();
        $data['view'] = 'md_customer/edit';
        $this->load->view('default', $data);
    }

    function delete($id) {
        if ($this->db->update($this->table, array('customer_status' => 3),array('id'=>$id))) {
            $this->session->set_flashdata('success', 'Data Berhasil Di Hapus !');
        } else {
            $this->session->set_flashdata('error', 'Data Gagal Di Hapus !');
        }
        redirect("customer");
    }

    function save() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_md_customer->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("customer");
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
        $q = $this->input->get('query');
        $where = array();
        if($this->input->get('province') != null){
            $where = array('province_id'=>$this->input->get('province'));
        }
        $like = array('city_name'=>$q);
        $result = $this->main_model->getTypeaheadList('city',$like,$where);
        echo json_encode($result);
    }
    
    public function getDistrictList() {
        $q = $this->input->get('query');
        $where = array();
        if($this->input->get('city') != null){
            $where = array('city_id'=>$this->input->get('city'));
        }
        $like = array('district_name'=>$q);
        $result = $this->main_model->getTypeaheadList('district',$like,$where);
        echo json_encode($result);
    }

    public function print_pdf() {
        $data['template'] = array("template" => "md_customer/" . $_GET['template'], "filename" => $_GET['name']);
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->printpdf->create_pdf($data);
    }

    public function print_excel() {
        $data['template_excel'] = "md_customer/" . $_GET['template'];
        $data['file_name'] = $_GET['name'];
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->load->view('template_excel', $data);
    }

}
