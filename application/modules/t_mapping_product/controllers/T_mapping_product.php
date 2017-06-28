<?php

class T_mapping_product extends MX_Controller {

    var $table = "m_customer";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_t_mapping_product' => 'm_mapping_product', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Mapping Product', '/mapping-product');
    }

    public function index() {
        $data['template_title'] = array('Mapping Product', 'List');
        $data['group_customer_product'] = $this->db->get_where('group_customer_product',array('group_customer_product_status'=>'1'))->result_array();
        $data['status_list_customer'] = $this->db->get_where('status_list_customer',array('status_list_customer_status'=>'1'))->result_array();
        $data['view'] = 't_mapping_product/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_customer'; 
        
        $field = array(
            "m_customer.*",
            "group_customer_product.group_customer_product",
            "status_list_customer.status_list_customer",
            "province.province_name",
            "city.city_name",
            "district.district_name",
            "IF(m_customer.customer_status=1,'Active','Not Active') AS status"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'group_customer_product', 'where' => 'group_customer_product.id=m_customer.id_group_customer_product', 'join' => 'left'),
            array('table' => 'status_list_customer', 'where' => 'status_list_customer.id=m_customer.id_status_list_customer', 'join' => 'left'),
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
        $array_status = array('m_customer.customer_status !=' => '3','m_customer.current_lead_customer_status'=>'C');
        $array_province = array();
        $array_city = array();
        $array_district = array();
        $array_group_customer = array();
        $array_status_list_customer = array();
        
        if(isset($_POST['province']) && $_POST['province'] != "") {
            $array_province = array('m_customer.customer_province'=>$_POST['province']);
        }
        if(isset($_POST['city']) && $_POST['city'] != "") {
            $array_city = array('m_customer.customer_city'=>$_POST['city']);
        }
        if(isset($_POST['district']) && $_POST['district'] != "") {
            $array_district = array('m_customer.customer_district'=>$_POST['district']);
        }
        if(isset($_POST['group_customer']) && $_POST['group_customer'] != "") {
            $array_group_customer = array('m_customer.id_group_customer_product'=>$_POST['group_customer']);
        }
        if(isset($_POST['status_list']) && $_POST['status_list'] != "") {
            $array_status_list_customer = array('m_customer.id_status_list_customer'=>$_POST['status_list']);
        }
        
        $where = array_merge_recursive($array_status,$array_province,$array_city,$array_district,$array_group_customer,$array_status_list_customer);
        
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_customer.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_mapping_product->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

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
        $this->breadcrumbs->push('Edit', '/mapping-product-edit');
        $data['customer'] = $this->m_mapping_product->getDetail($this->table, array($this->table.'.id' => $id))->row_array();
        $data['group'] = $this->db->get_where('group_customer_product',array('group_customer_product_status'=>1))->result_array();
        $data['view'] = 't_mapping_product/edit';
        $this->load->view('default', $data);
    }

    public function view($id) {
        $this->breadcrumbs->push('Edit', '/mapping-product-view');
        $data['data'] = $this->db->get_where($this->table, array('id' => $id))->row_array();
        $data['view'] = 't_mapping_product/edit';
        $this->load->view('default', $data);
    }

    function save() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_mapping_product->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("mapping-product");
        } else {
            show_404();
        }
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
