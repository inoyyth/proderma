<?php

class Md_branch_target extends MX_Controller {

    var $table = "m_branch_target";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_md_branch_target' => 'm_branch_target', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Master', '/dasboard');
        $this->breadcrumbs->push('Branch Target', '/branch-target');
    }

    public function index() {
        $data['template_title'] = array('Branch Target', 'List');
        $data['view'] = 'md_branch_target/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_branch_target'; 
        
        $field = array(
            "m_branch_target.*",
            "m_branch.branch_name"
        );
        
        $offset = ($page - 1) * $limit;

        $join =  array(
                    array('table' => 'm_branch', 'where' => 'm_branch.id=m_branch_target.id_branch', 'join' => 'INNER')
        );
        
        $like = array(
            'm_branch.branch_name'=>isset($_POST['branch_name'])?$_POST['branch_name']:""
        );
        $where = array();
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_branch_target.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_branch_target->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);
        $dtx = array();
        $bln = array(1 => 'January', 2 => 'February.', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
        foreach ($list as $kList=>$vList) {
            $dtx[] = array(
                'id'=>$vList['id'],
                'id_branch'=>$vList['branch_name'],
                'month_target'=>$vList['month_target'],
                'year_target'=>$vList['year_target'],
                'value_target'=>$vList['value_target'],
                'branch_name'=>$vList['branch_name'],
                'month_name'=>$bln[$vList['month_target']]
            );
        }
        $total_records = $this->data_table->count_all($table, $where);
        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $this->data_table->count_all($table, $where),
            "data" => $dtx,
        );
        //output to json format
        echo json_encode($output);
    }

    public function add() {
        $this->breadcrumbs->push('Add', '/branch-target-add');
        $data['branch'] = $this->db->get_where('m_branch',array('branch_status'=>"1"))->result_array();
        $data['view'] = "md_branch_target/add";
        $this->load->view('default', $data);
    }

    public function edit($id) {
        $this->breadcrumbs->push('Edit', '/branch-target-edit');
        $data['branch'] = $this->db->get_where('m_branch',array('branch_status'=>"1"))->result_array();
        $data['data'] = $this->db->get_where($this->table, array('id' => $id))->row_array();
        $data['view'] = 'md_branch_target/edit';
        $this->load->view('default', $data);
    }

    function delete($id) {
        if ($this->db->delete($this->table ,array('id'=>$id))) {
            $this->session->set_flashdata('success', 'Data Berhasil Di Hapus !');
        } else {
            $this->session->set_flashdata('error', 'Data Gagal Di Hapus !');
        }
        redirect("branch-target");
    }

    function save() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_branch_target->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("branch-target");
        } else {
            show_404();
        }
    }

    public function print_pdf() {
        $data['template'] = array("template" => "Md_branch_target/" . $_GET['template'], "filename" => $_GET['name']);
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->printpdf->create_pdf($data);
    }

    public function print_excel() {
		$table = "m_branch_target";
		$field = array(
            "m_branch_target.*",
            "IF(m_branch_target.jabatan_status=1,'Active','Not Active') AS status"
        );
		$join = array();
		$like = array();
		$where = array('m_branch_target.jabatan_status !=' => '3');
		$sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_branch_target.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );
		
        $data['list'] = $this->m_branch_target->getListTable($field,$table, $join, $like, $where, $sort, 100000);
        $data['template_excel'] = "Md_branch_target/table_excel";
        $data['file_name'] = "master_jabatan";
        $this->load->view('template_excel', $data);
    }

}
