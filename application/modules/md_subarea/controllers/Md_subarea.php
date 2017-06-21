<?php

class Md_subarea extends MX_Controller {

    var $table = "m_subarea";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_md_subarea' => 'm_md_subarea', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Master Subarea', '/master-subarea');
    }

    public function index() {
        $data['template_title'] = array('Master Subarea', 'List');
        $data['area'] = $this->db->get_where('m_area',array('area_status'=>1))->result_array();
        $data['view'] = 'md_subarea/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_subarea'; 
        
        $field = array(
            "m_subarea.*",
            "m_area.area_name",
            "IF(m_subarea.subarea_status=1,'Active','Not Active') AS status"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array(
             array('table' => 'm_area', 'where' => 'm_area.id=m_subarea.id_area', 'join' => 'left')
        );
        
        $like = array(
            'm_subarea.subarea_code'=>isset($_POST['subarea_code'])?$_POST['subarea_code']:"",
            'm_subarea.subarea_name'=>isset($_POST['subarea_name'])?$_POST['subarea_name']:"",
        );
        
        $array_id_area = array();
        $array_status = array('m_subarea.subarea_status !=' => '3');
        
        if(isset($_POST['id_area']) && $_POST['id_area'] != "") {
            $array_id_area = array('m_subarea.id_area'=>$_POST['id_area']);
        }
        
        $where = array_merge_recursive($array_id_area,$array_status);
        
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_subarea.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_md_subarea->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

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
        $this->breadcrumbs->push('Add', '/master-subarea-add');
        $data['area'] = $this->db->get_where('m_area',array('area_status'=>1))->result_array();
        $data['view'] = "md_subarea/add";
        $this->load->view('default', $data);
    }

    public function edit($id) {
        $this->breadcrumbs->push('Edit', '/master-subarea-edit');
        $data['area'] = $this->db->get_where('m_area',array('area_status'=>1))->result_array();
        $data['data'] = $this->db->get_where($this->table, array('id' => $id))->row_array();
        $data['view'] = 'md_subarea/edit';
        $this->load->view('default', $data);
    }

    function delete($id) {
        if ($this->db->update($this->table, array('subarea_status' => 3),array('id'=>$id))) {
            $this->session->set_flashdata('success', 'Data Berhasil Di Hapus !');
        } else {
            $this->session->set_flashdata('error', 'Data Gagal Di Hapus !');
        }
        redirect("master-subarea");
    }

    function save() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_md_subarea->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("master-subarea");
        } else {
            show_404();
        }
    }

    public function print_pdf() {
        $data['template'] = array("template" => "md_subarea/" . $_GET['template'], "filename" => $_GET['name']);
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->printpdf->create_pdf($data);
    }

    public function print_excel() {
        $data['template_excel'] = "md_subarea/" . $_GET['template'];
        $data['file_name'] = $_GET['name'];
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->load->view('template_excel', $data);
    }

}
