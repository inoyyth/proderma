<?php

class Balance_sheet extends MX_Controller {
    /*  $autoload = array(
      'helper'    => array('url', 'form'),
      'libraries' => array('email'),
      ); */

    public function __construct() {
        parent::__construct();
        //set breadcrumb
    }

    public function index() {
        $data['title'] = "Laporan Keuangan <small>Lap.Pertumbuhan Balance Off Sheet</small>";
        $data['view'] = 'balance_sheet/main';
        $this->load->view('default', $data);
    }
}
