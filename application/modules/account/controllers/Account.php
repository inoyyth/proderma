<?php

class Account extends MX_Controller {

    var $table = "account";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_account' => 'm_account', 'Datatable_model' => 'data_table'));
        $this->load->library(array('upload', 'encrypt', 'Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('User Management', '/user-management');
    }

    public function index() {
        $data['template_title'] = array('User Management', 'List');
        $data['view'] = 'account/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $table = 'account';
        $page = $_POST['page'];
        $limit = $_POST['size'];

        $offset = ($page - 1) * $limit;

        $join = array();
        $like = array(
            'username'=>isset($_POST['username'])?$_POST['username']:"",
            'nama_lengkap'=>isset($_POST['nama_lengkap'])?$_POST['nama_lengkap']:"",
            'last_login'=>isset($_POST['last_login'])?$_POST['last_login']:""
        );
        $where = array('status' => '1');
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );

        $list = $this->m_account->getListTable($table, $join, $like, $where, $sort, $limit_row);

        foreach ($list as $result) {
            $data[] = array(
                'id' => $result['id'],
                'username' => $result['username'],
                'nama_lengkap' => $result['nama_lengkap'],
                'last_login' => $result['last_login']
            );
        }
        $total_records = $this->data_table->count_all($table, $where);
        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $this->data_table->count_all($table, $where),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function add() {
        $this->breadcrumbs->push('Add', '/user-management-add');
        $data['list_menu'] = $this->m_account->get_active_menu();
        $data['view'] = "account/add";
        $this->load->view('default', $data);
    }

    public function edit($id) {
        $this->breadcrumbs->push('Edit', '/user-management-edit');
        $data['detail'] = $this->db->get_where($this->table, array('id' => $id))->row_array();
        $data['list_menu'] = $this->m_account->get_active_menu();
        $data['view'] = 'account/edit';
        $this->load->view('default', $data);
    }

    function delete($id) {
        if ($this->db->delete($this->table, array('id' => $id))) {
            $this->session->set_flashdata('success', 'Data Berhasil Di Hapus !');
        } else {
            $this->session->set_flashdata('error', 'Data Gagal Di Hapus !');
        }
        redirect("user-management");
    }

    function save() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_account->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("user-management");
        } else {
            show_404();
        }
    }

    public function print_pdf() {
        $data['template'] = array("template" => "account/" . $_GET['template'], "filename" => $_GET['name']);
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->printpdf->create_pdf($data);
    }

    public function print_excel() {
        $data['template_excel'] = "account/" . $_GET['template'];
        $data['file_name'] = $_GET['name'];
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->load->view('template_excel', $data);
    }

}
