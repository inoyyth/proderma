<?php

class Laporan_keuangan_perperiode extends MX_Controller {
    /*  $autoload = array(
      'helper'    => array('url', 'form'),
      'libraries' => array('email'),
      ); */

    public function __construct() {
        parent::__construct();
        //set breadcrumb
    }

    public function index() {
        $data['title'] = "Laporan Keuangan <small>Profit Loss Statement</small>";
        $data['view'] = 'laporan_keuangan_perperiode/main';
        $this->load->view('default', $data);
    }
}
