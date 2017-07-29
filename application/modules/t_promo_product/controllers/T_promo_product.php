<?php

class T_promo_product extends MX_Controller {

    var $table = "m_promo_product";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_t_promo_product' => 'm_promo', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Master Promo Product', '/promo-product');
    }

    public function index() {
        $data['template_title'] = array('Master Promo Product', 'List');
        $data['view'] = 't_promo_product/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_promo_product'; 
        
        $field = array(
            "m_promo_product.*",
            "IF(m_promo_product.promo_status=1,'Active','Not Active') AS status"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array();
        
        $like = array(
            'm_promo_product.promo_code'=>isset($_POST['code'])?$_POST['code']:"",
            'm_promo_product.promo_name'=>isset($_POST['name'])?$_POST['name']:"",
        );
        $where = array('m_promo_product.promo_status !=' => '3');
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_promo_product.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_promo->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

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
        $this->breadcrumbs->push('Add', '/promo-product-add');
        $data['code'] = $this->main_model->generate_code('m_promo_product', $this->config->item('promo_code').'/1','/' , $digit = 5, true,false, $where=array(),'id','id');
        $data['view'] = "t_promo_product/add";
        $this->load->view('default', $data);
    }

    public function edit($id) {
        $this->breadcrumbs->push('Edit', '/promo-product-edit');
        $data['data'] = $this->db->get_where($this->table, array('id' => $id))->row_array();
        $data['view'] = 't_promo_product/edit';
        $this->load->view('default', $data);
    }

    function delete($id) {
        if ($this->db->update($this->table, array('promo_status' => 3),array('id'=>$id))) {
            $this->session->set_flashdata('success', 'Data Berhasil Di Hapus !');
        } else {
            $this->session->set_flashdata('error', 'Data Gagal Di Hapus !');
        }
        redirect("promo-product");
    }

    function save() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_promo->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("promo-product");
        } else {
            show_404();
        }
    }

    public function print_pdf() {
        $data['template'] = array("template" => "t_promo_product/" . $_GET['template'], "filename" => $_GET['name']);
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->printpdf->create_pdf($data);
    }

    public function print_excel() {
        $data['template_excel'] = "t_promo_product/" . $_GET['template'];
        $data['file_name'] = $_GET['name'];
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->load->view('template_excel', $data);
    }

}
