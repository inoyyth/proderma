<?php

class Dashboard extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //set breadcrumb
        $this->breadcrumbs->push('User Management', '/user-management');
    }

    public function index() {
        $data['title'] = "Laporan Keuangan";
        $data['view'] = 'dashboard/main';
        $this->load->view('default', $data);
    }
}
