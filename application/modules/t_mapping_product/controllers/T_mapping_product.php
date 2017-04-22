<?php

class T_mapping_product extends MX_Controller {

    var $table = "mapping_product";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_t_mapping_product' => 'm_mapping_product', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Mapping Product', '/mapping-product');
    }

    public function index() {
        $data['template_title'] = array('Mapping Product', 'List');
        $data['view'] = 't_mapping_product/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'mapping_product'; 
        
        $field = array(
            "mapping_product.*",
            "m_employee.employee_name",
            "m_employee.employee_nip",
            "m_product.product_code",
            "m_product.product_name",
            "m_product_category.product_category"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'm_employee', 'where' => 'm_employee.id=mapping_product.id_sales', 'join' => 'right'),
            array('table' => 'm_product', 'where' => 'm_product.id=mapping_product.id_product', 'join' => 'left'),
            array('table' => 'm_product_category', 'where' => 'm_product_category.id=m_product.id_product_category', 'join' => 'left')
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

    public function add() {
        $this->breadcrumbs->push('Add', '/employee-level-add');
        $data['view'] = "md_level/add";
        $this->load->view('default', $data);
    }

    public function edit($id) {
        $this->breadcrumbs->push('Edit', '/employee-level-edit');
        $data['data'] = $this->db->get_where($this->table, array('id' => $id))->row_array();
        $data['view'] = 'md_level/edit';
        $this->load->view('default', $data);
    }

    function delete($id) {
        if ($this->db->update($this->table, array('jabatan_status' => 3),array('id'=>$id))) {
            $this->session->set_flashdata('success', 'Data Berhasil Di Hapus !');
        } else {
            $this->session->set_flashdata('error', 'Data Gagal Di Hapus !');
        }
        redirect("employee-level");
    }

    function save() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_mapping_product->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("employee-level");
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
