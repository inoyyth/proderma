<?php

class Import_master_list extends MX_Controller {

    var $table = "m_customer";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_import_master_list' => 'm_master_list', 'Datatable_model' => 'data_table'));
        $this->load->helper('download');
        //set breadcrumb
        $this->breadcrumbs->push('Import Master List', '/import-master-list');
    }

    public function index() {
        $data['template_title'] = array('Import Master List', 'Form');
        $data['view'] = 'import_master_list/main';
        $this->load->view('default', $data);
    }
    
    public function template_excel() {
        force_download('assets/excelTemplate/templateMasterList.xlsx', NULL);
    }

}
