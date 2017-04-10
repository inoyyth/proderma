<?php

class Commerce_field extends MX_Controller {

    var $table = "commerce_field";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_commerce_field' => 'commerce_field'));
        $this->load->library(array('Auth_log', 'Table_fitersession'));
        //set breadcrumb
        //$this->breadcrumbs->push('Master Gudang', '/commerce-field-setting');
    }

    public function index() {
        $data_session = $this->table_fitersession->renders(array('page','commerce_field_name','commerce_field_description','commerce_field_status'));
        $config['base_url'] = base_url() . 'commerce-field-setting-page';
        $config['per_page'] = (!empty($data_session['page']) ? $data_session['page'] : 10);
        $config['total_rows'] = count($this->commerce_field->getdata($this->table, 0, 1000, $like = $data_session, $where = array('commerce_field_status!=' => '3', 'user_id' => $this->sessionGlobal['id'])));
        $config['uri_segment'] = 2;
        $limit = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $this->pagination->initialize($config);
        $data['paging'] = $this->pagination->create_links();
        $data['data'] = $this->commerce_field->getdata($this->table, $limit, $config['per_page'], $like = $data_session, $where = array('commerce_field_status!=' => '3', 'user_id' => $this->sessionGlobal['id']));
        $data['total_rows'] = $config['total_rows'];
        $data['sr_data'] = $data_session;
        $data['params_status'] = $this->main_model->getMaster('global_params', array(), array('params' => 'status', 'code !=' => '3'));
        $data['view'] = 'commerce_field/main';
        $this->load->view('default', $data);
    }

    public function add() {
        //$this->breadcrumbs->push('Add', '/commerce-field-setting-tambah');
        $data['params_status'] = $this->main_model->getMaster('global_params', array(), array('params' => 'status', 'code !=' => '3'));
        $data['view'] = "commerce_field/add";
        $this->load->view('default', $data);
    }

    public function edit($id) {
        //$this->breadcrumbs->push('Edit', '/commerce-field-setting-edit');
        $data['params_status'] = $this->main_model->getMaster('global_params', array(), array('params' => 'status', 'code !=' => '3'));
        $data['detail'] = $this->db->get_where($this->table, array('id' => $id, 'user_id' => $this->sessionGlobal['id']))->row_array();
        $data['view'] = 'commerce_field/edit';
        $this->load->view('default', $data);
    }

    function delete($id) {
        $this->main_model->delete('commerce_field', array('id' => $id), array('commerce_field_status' => '3', 'user_id' => $this->sessionGlobal['id']));
        redirect("commerce-field-setting");
    }

    function save() {
        if ($_POST) {
            $user_id = $this->sessionGlobal['id'];
            if ($this->commerce_field->save($user_id)) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("commerce-field-setting");
        } else {
            show_404();
        }
    }
    
    public function print_pdf() {
        $data['template'] = array("template" => "commerce_field/" . $_GET['template'], "filename" => $_GET['name']);
        $data['list'] = $this->commerce_field->getdata($this->table, 0, 1000, $like = array(), $where = array('commerce_field_status!=' => '3'));
        $this->printpdf->create_pdf($data);
    }

    public function print_excel() {
        $data['template_excel'] = "commerce_field/" . $_GET['template'];
        $data['file_name'] = $_GET['name'];
        $data['list'] = $this->commerce_field->getdata($this->table, 0, 1000, $like = array(), $where = array('commerce_field_status!=' => '3'));
        $this->load->view('template_excel', $data);
    }

}
