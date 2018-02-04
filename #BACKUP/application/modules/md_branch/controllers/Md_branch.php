<?php

class Md_branch extends MX_Controller {

    var $table = "m_branch";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_md_branch' => 'm_md_branch', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Master', '/dasboard');
        $this->breadcrumbs->push('Branch Office', '/branch');
    }

    public function index() {
        $data['template_title'] = array('Branch Office', 'List');
        $data['view'] = 'md_branch/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_branch'; 
        
        $field = array(
            "m_branch.*",
            "IF(m_branch.branch_status=1,'Active','Not Active') AS status"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array();
        
        $like = array(
            'm_branch.branch_code'=>isset($_POST['code'])?$_POST['code']:"",
            'm_branch.branch_name'=>isset($_POST['name'])?$_POST['name']:""
        );
        $where = array('m_branch.branch_status !=' => '3');
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_branch.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_md_branch->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

        $total_records = count($this->m_md_branch->getListTable($field,$table, $join, $like, $where, $sort, false));
        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $total_records,
            "data" => $list,
        );
        //output to json format
        echo json_encode($output);
    }
    
    public function getListBank() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_branch_bank'; 
        
        $field = array(
            "m_branch_bank.*",
            "IF(m_branch_bank.branch_bank_status=1,'Active','Not Active') AS status"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array();
        
        $like = array();
        $where = array('m_branch_bank.branch_bank_status !=' => '3','id_branch'=>$this->input->post('id_branch'));
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_md_branch->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

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
        $this->breadcrumbs->push('Add', '/branch-add');
        $data['view'] = "md_branch/add";
        $this->load->view('default', $data);
    }

    public function edit($id) {
        $this->breadcrumbs->push('Edit', '/branch-edit');
        $data['data'] = $this->db->get_where($this->table, array('id' => $id))->row_array();
        $data['view'] = 'md_branch/edit';
        $this->load->view('default', $data);
    }

    function delete($id) {
        if ($this->db->update($this->table, array('branch_status' => 3),array('id'=>$id))) {
            $this->session->set_flashdata('success', 'Data Berhasil Di Hapus !');
        } else {
            $this->session->set_flashdata('error', 'Data Gagal Di Hapus !');
        }
        redirect("branch");
    }

    function save() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_md_branch->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("branch");
        } else {
            show_404();
        }
    }
    
    function saveBank() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_md_branch->saveBank()) {
                $result = array('code'=>200,'message'=>'success');
            } else {
                $result = array('code'=>500,'message'=>'internal error');
            }
            echo json_encode($result);
        } else {
            show_404();
        }
    }
    
    function deleteBank() {
        $id = $this->input->post('id');
        if ($this->db->update('m_branch_bank', array('branch_bank_status' => 3),array('id'=>$id))) {
            return true;
        } else {
            return false;
        }
    }

    public function print_pdf() {
        $data['template'] = array("template" => "md_branch/" . $_GET['template'], "filename" => $_GET['name']);
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->printpdf->create_pdf($data);
    }

    public function print_excel() {
		$table = 'm_branch'; 
        
        $field = array(
            "m_branch.*",
            "IF(m_branch.branch_status=1,'Active','Not Active') AS status"
        );
        $join = array();
		$like = array();
        $where = array('m_branch.branch_status !=' => '3');
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_branch.branch_name",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"asc"
        );
        $data['list'] = $this->m_md_branch->getListTable($field,$table, $join, $like, $where, $sort, 100000);
        $data['template_excel'] = "md_branch/table_excel";
        $data['file_name'] = "master_branch";
        $this->load->view('template_excel', $data);
    }

}
