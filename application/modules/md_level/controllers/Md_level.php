<?php

class Md_level extends MX_Controller {

    var $table = "m_jabatan";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_md_level' => 'm_md_level', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Employee Level', '/employee-level');
    }

    public function index() {
        $data['template_title'] = array('Employee Level', 'List');
        $data['view'] = 'md_level/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_jabatan'; 
        
        $field = array(
            "m_jabatan.*",
            "IF(m_jabatan.jabatan_status=1,'Active','Not Active') AS status"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array();
        
        $like = array(
            'm_jabatan.jabatan'=>isset($_POST['jabatan'])?$_POST['jabatan']:""
        );
        $where = array('m_jabatan.jabatan_status !=' => '3');
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_jabatan.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_md_level->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

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
            if ($this->m_md_level->save()) {
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
		$table = "m_jabatan";
		$field = array(
            "m_jabatan.*",
            "IF(m_jabatan.jabatan_status=1,'Active','Not Active') AS status"
        );
		$join = array();
		$like = array();
		$where = array('m_jabatan.jabatan_status !=' => '3');
		$sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_jabatan.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );
		
        $data['list'] = $this->m_md_level->getListTable($field,$table, $join, $like, $where, $sort, 100000);
        $data['template_excel'] = "md_level/table_excel";
        $data['file_name'] = "master_jabatan";
        $this->load->view('template_excel', $data);
    }

}
