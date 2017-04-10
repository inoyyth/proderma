<?php

class Pertumbuhan_kredit extends MX_Controller {
    /*  $autoload = array(
      'helper'    => array('url', 'form'),
      'libraries' => array('email'),
      ); */

    public function __construct() {
        parent::__construct();
        //set breadcrumb
    }

    public function index() {
        $data['title'] = "Laporan Keuangan <small>Lap.Pertumbuhan Kredit</small>";
        $data['view'] = 'pertumbuhan_kredit/main';
        $this->load->view('default', $data);
    }
}
