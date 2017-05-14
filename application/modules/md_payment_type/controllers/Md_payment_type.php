<?php

class Md_payment_type extends MX_Controller {

    var $table = "m_payment_type";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_md_payment_type' => 'm_md_payment_type', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Payment Type', '/master-payment-type');
    }

    public function index() {
        $data['template_title'] = array('Payment Type', 'List');
        $data['view'] = 'md_payment_type/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_payment_type'; 
        
        $field = array(
            "m_payment_type.*",
            "IF(m_payment_type.payment_type_status=1,'Active','Not Active') AS status"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array();
        
        $like = array(
            'm_payment_type.payment_type'=>isset($_POST['type'])?$_POST['type']:"",
            'm_payment_type.payment_type_description'=>isset($_POST['description'])?$_POST['description']:""
        );
        $where = array('m_payment_type.payment_type_status !=' => '3');
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_payment_type.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_md_payment_type->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

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
        $this->breadcrumbs->push('Add', '/master-payment-type-add');
        $data['view'] = "md_payment_type/add";
        $this->load->view('default', $data);
    }

    public function edit($id) {
        $this->breadcrumbs->push('Edit', '/master-payment-type-edit');
        $data['data'] = $this->db->get_where($this->table, array('id' => $id))->row_array();
        $data['view'] = 'md_payment_type/edit';
        $this->load->view('default', $data);
    }

    function delete($id) {
        if ($this->db->update($this->table, array('payment_type_status' => 3),array('id'=>$id))) {
            $this->session->set_flashdata('success', 'Data Berhasil Di Hapus !');
        } else {
            $this->session->set_flashdata('error', 'Data Gagal Di Hapus !');
        }
        redirect("master-payment-type");
    }

    function save() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_md_payment_type->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("master-payment-type");
        } else {
            show_404();
        }
    }

    public function print_pdf() {
        $data['template'] = array("template" => "md_payment_type/" . $_GET['template'], "filename" => $_GET['name']);
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->printpdf->create_pdf($data);
    }

    public function print_excel() {
        $data['template_excel'] = "md_payment_type/" . $_GET['template'];
        $data['file_name'] = $_GET['name'];
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->load->view('template_excel', $data);
    }

}
