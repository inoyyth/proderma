<?php

class Md_location extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_md_location' => 'm_md_location', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('location_info', '/location');
    }

    public function index() {
        $data['template_title'] = array('Location Info', 'Info');
        $data['province'] = $this->m_md_location->getProvince()->result_array();
        $data['view'] = 'md_location/main';
        $this->load->view('default', $data);
    }
    
    public function getLocation() {
        $data = $this->db->get_where($this->input->post('table'),array($this->input->post('field')=>$this->input->post('where'),$this->input->post('table').'_status'=>1))->result_array();
        echo json_encode($data,true);
    }

}
