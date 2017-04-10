<?php

class Laporan_keuangan_asset extends MX_Controller {
    /*  $autoload = array(
      'helper'    => array('url', 'form'),
      'libraries' => array('email'),
      ); */

    public function __construct() {
        parent::__construct();
        //set breadcrumb
    }

    public function index() {
        $data['title'] = "Laporan Keuangan <small>Financial Ratios</small>";
        $data['view'] = 'laporan_keuangan_asset/main';
        $this->load->view('default', $data);
    }
}
