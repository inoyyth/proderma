<?php

class Pertumbuhan_dpk extends MX_Controller {
    /*  $autoload = array(
      'helper'    => array('url', 'form'),
      'libraries' => array('email'),
      ); */

    public function __construct() {
        parent::__construct();
        //set breadcrumb
    }

    public function index() {
        $data['title'] = "Laporan Keuangan <small>Applicable Interest Rates</small>";
        $data['view'] = 'pertumbuhan_dpk/main';
        $this->load->view('default', $data);
    }
}
