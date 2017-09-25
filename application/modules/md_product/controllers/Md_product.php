<?php

class Md_product extends MX_Controller {

    var $table = "m_product";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_md_product' => 'm_md_product', 'Datatable_model' => 'data_table'));
        $this->load->library(array('upload', 'encrypt', 'Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Product', '/master-product');
    }

    public function index() {
        $data['template_title'] = array('Product', 'List');
        $data['view'] = 'md_product/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_product'; 
        
        $field = array(
            "m_product.*",
            "m_product_category.product_category",
			"m_group_product.group_product",
            "IF(m_product.product_status=1,'Active','Not Active') AS status"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'm_product_category', 'where' => 'm_product_category.id=m_product.id_product_category', 'join' => 'left'),
			array('table' => 'm_group_product', 'where' => 'm_group_product.id=m_product.id_group_product', 'join' => 'left')
        );
        $like = array(
            'm_product_category.product_category'=>isset($_POST['category'])?$_POST['category']:"",
            'm_product.product_code'=>isset($_POST['code'])?$_POST['code']:"",
            'm_product.product_name'=>isset($_POST['name'])?$_POST['name']:"",
            'm_product.product_price'=>isset($_POST['price'])?$_POST['price']:""
        );
        $where = array('m_product.product_status !=' => '3');
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_product.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_md_product->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

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
        $this->breadcrumbs->push('Add', '/master-product-add');
        $data['branch'] = $this->db->get_where('m_branch',array('branch_status'=>1))->result_array();
        $data['category'] = $this->db->get_where('m_product_category',array('product_category_status'=>1))->result_array();
        $data['group'] = $this->db->get_where('m_group_product',array('group_product_status'=>1))->result_array();
        $data['view'] = "md_product/add";
        $this->load->view('default', $data);
    }

    public function edit($id) {
        $this->breadcrumbs->push('Edit', '/master-product-edit');
        $data['branch'] = $this->db->get_where('m_branch',array('branch_status'=>1))->result_array();
        $data['category'] = $this->db->get_where('m_product_category',array('product_category_status'=>1))->result_array();
        $data['group'] = $this->db->get_where('m_group_product',array('group_product_status'=>1))->result_array();
        $data['data'] = $this->m_md_product->edit_data($this->table, array($this->table.'.id' => $id))->row_array();
        $data['view'] = 'md_product/edit';
        $this->load->view('default', $data);
    }

    function delete($id) {
        if ($this->db->update($this->table, array('product_status' => 3),array('id'=>$id))) {
            $this->session->set_flashdata('success', 'Data Berhasil Di Hapus !');
        } else {
            $this->session->set_flashdata('error', 'Data Gagal Di Hapus !');
        }
        redirect("master-product");
    }

    function save() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_md_product->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("master-product");
        } else {
            show_404();
        }
    }

    public function print_pdf() {
        $data['template'] = array("template" => "md_product/" . $_GET['template'], "filename" => $_GET['name']);
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
		
        $data['list'] = $this->m_md_product->getListTable($field,$table, $join, $like, $where, $sort, 100000);
        $data['template_excel'] = "md_product/table_excel";
        $data['file_name'] = "master_product";
        $this->load->view('template_excel', $data);
    }
    
    public function load_sub_category() {
        $data = array();
        $this->load->view('md_product/modal_sub_category');
    }

}
