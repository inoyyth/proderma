<?php

class T_mapping_area extends MX_Controller {

    var $table = "m_employee";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_t_mapping_area' => 'm_mapping_area', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Mapping Area', '/mapping-area');
    }

    public function index() {
        $data['template_title'] = array('Mapping Area', 'List');
        $data['view'] = 't_mapping_area/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_employee'; 
        
        $field = array(
            "m_employee.*",
            "m_jabatan.jabatan",
            "province.province_name",
            "city.city_name"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'm_jabatan', 'where' => 'm_employee.id_jabatan=m_jabatan.id', 'join' => 'left'),
            array('table' => 'province', 'where' => 'm_employee.sales_province=province.province_id', 'join' => 'left'),
            array('table' => 'city', 'where' => 'm_employee.sales_city=city.city_id', 'join' => 'left')
        );
        
        $like = array(
            'm_employee.employee_name'=>isset($_POST['employee_name'])?$_POST['employee_name']:""
        );
        $where = array('m_employee.id_jabatan'=>1);
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_employee.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_mapping_area->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);
        
        //log_message('debug',print_r($dtx,TRUE));
        
        $total_records = $this->data_table->count_all($table, $where);
        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => ($total_pages==0?1:$total_pages),
            "recordsTotal" => $this->data_table->count_all($table, $where),
            "data" => $list,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id) {
        $this->breadcrumbs->push('Edit', '/mapping-area-edit');
        $data['data_sales'] = $this->db->get_where($this->table, array('id' => $id))->row_array();
        $data['province'] = $this->db->get('province')->result_array();
        $data['view'] = 't_mapping_area/edit';
        $this->load->view('default', $data);
    }

    public function view($id) {
        $this->breadcrumbs->push('Edit', '/mapping-area-view');
        $data['data_sales'] = $this->db->get_where($this->table, array('id' => $id))->row_array();
        $data['view'] = 't_mapping_area/edit';
        $this->load->view('default', $data);
    }

    function save() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_mapping_area->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("mapping-area");
        } else {
            show_404();
        }
    }
    
    public function getClinicList() {
        $city = $this->input->get('id');
        $list = $this->db->get_where('m_customer',array('customer_city'=>$city,'customer_status'=>1,))->result_array();
        $dt = array();
        foreach ($list as $k=>$v) {
            $dt[] = array($v['customer_clinic'],$v['customer_latitude'],$v['customer_longitude']);
        }
        echo json_encode($dt);
    }

    public function print_pdf() {
        $data['template'] = array("template" => "md_level/" . $_GET['template'], "filename" => $_GET['name']);
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->printpdf->create_pdf($data);
    }

    public function print_excel() {
        $data['template_excel'] = "md_level/" . $_GET['template'];
        $data['file_name'] = $_GET['name'];
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->load->view('template_excel', $data);
    }

}
