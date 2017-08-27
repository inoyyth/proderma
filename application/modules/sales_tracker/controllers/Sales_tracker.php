<?php

class Sales_tracker extends MX_Controller {

    var $table = "log_sales";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_sales_tracker' => 'm_tracker', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Sales Tracker', '/sales-tracker');
    }

    public function index() {
        $data['template_title'] = array('Employee Level', 'List');
        $data['view'] = 'sales_tracker/main';
        $this->load->view('default', $data);
    }
    
    public function getLog() {
        $log = $this->m_tracker->getLog()->result_array();
        $dt = array();
        foreach($log as $kLog=>$vLog) {
            $dt[] = array($vLog['employee'],(float)$vLog['longitude'],(float)$vLog['latitude'],$kLog+1);
        }
        echo json_encode($dt);
    }
}
