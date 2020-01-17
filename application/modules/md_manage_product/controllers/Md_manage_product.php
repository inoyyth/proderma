<?php

class Md_manage_product extends MX_Controller {

    var $table = "m_product";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_md_manage_product' => 'm_md_manage_product', 'Datatable_model' => 'data_table'));
        $this->load->library(array('upload', 'encryption', 'Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Utility', '/dasboard');
        $this->breadcrumbs->push('Manage Product', '/manage-product');
    }

    public function index() {
        $data['template_title'] = array('Manage Product', 'List');
        $data['view'] = 'md_manage_product/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_product'; 
        
        $field = array(
            "m_product.id",
            "m_product.product_code",
            "m_product.product_name",
            "m_product_category.product_category",
            "SUM(CASE product_stock_manage.update_status WHEN 'I' THEN qty WHEN 'O' THEN -qty ELSE 0 END) as jum",
            "CASE m_product.product_status WHEN '1' THEN 'Active' WHEN '2' THEN 'Not Active' END as status"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'product_stock_manage', 'where' => 'm_product.id=product_stock_manage.id_product', 'join' => 'left'),
            array('table' => 'm_product_category', 'where' => 'm_product.id_product_category=m_product_category.id', 'join' => 'left')
        );
        $like = array(
            'm_product.product_code'=>isset($_POST['code'])?$_POST['code']:"",
            'm_product.product_name'=>isset($_POST['name'])?$_POST['name']:"",
            'm_product_category.product_category'=>isset($_POST['category'])?$_POST['category']:""
        );
        $where = array('m_product.product_status !=' => '3');
        $where_in = array();
        if($this->sessionGlobal['super_admin'] == "1") {
            $where_in = array('field' => 'm_product.id_branch','value' => array(0,(int)$this->sessionGlobal['id_branch']));
        }
        
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_product.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );

        $group_by = array('m_product.id');
        
        $list = $this->m_md_manage_product->getListTable($field,$table, $join, $like, $where, $sort, $limit_row,$where_in,$group_by);

        $total_records = count($this->m_md_manage_product->getListTable($field,$table, $join, $like, $where, $sort, false, $where_in,$group_by));
        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $total_records,
            "data" => $list,
        );
        //output to json format
        echo json_encode($output);
    }

    public function getDetailList($id_product) {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'product_stock_manage'; 
        
        $field = array(
            "product_stock_manage.*",
            "CASE product_stock_manage.update_status WHEN 'I' THEN 'IN' WHEN 'O' THEN 'OUT' END AS status"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array();
        $like = array(
            'product_stock_manage.description'=>isset($_POST['desc'])?$_POST['desc']:"",
            'product_stock_manage.update_status'=>isset($_POST['status'])?$_POST['status']:"",
        );
        $where = array('product_stock_manage.id_product' => $id_product);
        $where_in = array();
        if($this->sessionGlobal['super_admin'] == "1") {
            $where_in = array('field' => 'm_product.id_branch','value' => array(0,(int)$this->sessionGlobal['id_branch']));
        }
        
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"product_stock_manage.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );

        $group_by = false;
        
        $list = $this->m_md_manage_product->getListTable($field,$table, $join, $like, $where, $sort, $limit_row,$where_in,$group_by);

        $total_records = count($this->m_md_manage_product->getListTable($field,$table, $join, $like, $where, $sort, false, $where_in,$group_by));
        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $total_records,
            "data" => $list,
        );
        //output to json format
        echo json_encode($output);
    }

    public function add($id_product) {
        $this->breadcrumbs->push('Add', '/manage-product-add');
        $data['data'] = $this->db->get_where($this->table,array('id'=>$id_product))->row_array();
        $data['view'] = "md_manage_product/add";
        $this->load->view('default', $data);
    }

    public function edit($id_product,$id) {
        $this->breadcrumbs->push('Edit', '/manage-product-edit');
        $data['data'] = $this->db->get_where($this->table,array('id'=>$id_product))->row_array();
        $data['detail'] = $this->db->get_where('product_stock_manage', array('id' => $id))->row_array();
        $data['view'] = 'md_manage_product/edit';
        $this->load->view('default', $data);
    }
    
    public function listDataTable($id) {
        $data['data'] = $this->m_md_manage_product->detailData($id)->row_array();
        $this->breadcrumbs->push($data['data']['product_name'], '/manage-product-list');
        $data['view'] = 'md_manage_product/detail';
        $this->load->view('default', $data);
    }

    function delete($id_product,$id) {
        if ($this->db->delete('product_stock_manage', array('id' => $id))) {
            $this->session->set_flashdata('success', 'Data Berhasil Di Hapus !');
        } else {
            $this->session->set_flashdata('error', 'Data Gagal Di Hapus !');
        }
        redirect("manage-product-list-".$id_product);
    }

    function save() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_md_manage_product->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("manage-product-list-".$this->input->post('id_product'));
        } else {
            show_404();
        }
    }

    public function print_pdf() {
        $data['template'] = array("template" => "md_manage_product/" . $_GET['template'], "filename" => $_GET['name']);
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->printpdf->create_pdf($data);
    }

    public function print_excel() {
        $table = 'm_product'; 
        
        $field = array(
            "m_product.*",
            "m_product_category.product_category",
			"m_group_product.group_product",
            "IF(m_product.product_status=1,'Active','Not Active') AS status"
        );
		$join = array(
            array('table' => 'm_product_category', 'where' => 'm_product_category.id=m_product.id_product_category', 'join' => 'left'),
			array('table' => 'm_group_product', 'where' => 'm_group_product.id=m_product.id_group_product', 'join' => 'left')
        );
		$like = array();
		$where = array('m_product.product_status !=' => '3');
		$sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_product.product_name",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"asc"
        );
		
        $data['list'] = $this->m_md_manage_product->getListTable($field,$table, $join, $like, $where, $sort, 100000);
        $data['template_excel'] = "md_manage_product/table_excel";
        $data['file_name'] = "master_product";
        $this->load->view('template_excel', $data);
    }
    
    public function load_sub_category() {
        $data = array();
        $this->load->view('md_manage_product/modal_sub_category');
    }

}
