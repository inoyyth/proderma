<?php

class Md_product_sub_category extends MX_Controller {

    var $table = "m_product_sub_category";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_md_product_sub_category' => 'm_md_product_sub_category', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Product Sub Category', '/master-product-sub-category');
    }

    public function index() {
        $data['template_title'] = array('Product Sub Category', 'List');
        $data['view'] = 'md_product_sub_category/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_product_sub_category'; 
        
        $field = array(
            "m_product_sub_category.*",
            "IF(m_product_sub_category.product_sub_category_status=1,'Active','Not Active') AS status",
            "m_product_category.product_category"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'm_product_category', 'where' => 'm_product_category.id=m_product_sub_category.id_product_category', 'join' => 'left')
        );
        
        $like = array(
            'm_product_sub_category.sub_category_name'=>isset($_POST['sub_category'])?$_POST['sub_category']:"",
            'm_product_category.product_category'=>isset($_POST['product_category'])?$_POST['product_category']:""
        );
        $where = array('m_product_sub_category.product_sub_category_status !=' => '3');
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_product_sub_category.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_md_product_sub_category->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

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
        $this->breadcrumbs->push('Add', '/master-product-sub-category-add');
        $data['product_category'] = $this->db->get_where('m_product_category',array('product_category_status'=>1))->result_array();
        $data['view'] = "md_product_sub_category/add";
        $this->load->view('default', $data);
    }

    public function edit($id) {
        $this->breadcrumbs->push('Edit', '/master-product-sub-category-edit');
        $data['data'] = $this->db->get_where($this->table, array('id' => $id))->row_array();
        $data['product_category'] = $this->db->get_where('m_product_category',array('product_category_status'=>1))->result_array();
        $data['view'] = 'md_product_sub_category/edit';
        $this->load->view('default', $data);
    }

    function delete($id) {
        if ($this->db->update($this->table, array('product_category_status' => 3),array('id'=>$id))) {
            $this->session->set_flashdata('success', 'Data Berhasil Di Hapus !');
        } else {
            $this->session->set_flashdata('error', 'Data Gagal Di Hapus !');
        }
        redirect("master-product-sub-category");
    }

    function save() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_md_product_sub_category->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("master-product-sub-category");
        } else {
            show_404();
        }
    }

    public function print_pdf() {
        $data['template'] = array("template" => "md_product_sub_category/" . $_GET['template'], "filename" => $_GET['name']);
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->printpdf->create_pdf($data);
    }

    public function print_excel() {
        $data['template_excel'] = "md_product_sub_category/" . $_GET['template'];
        $data['file_name'] = $_GET['name'];
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->load->view('template_excel', $data);
    }

}
