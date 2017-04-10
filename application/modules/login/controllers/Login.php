<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends MX_Controller {
    
    function index() {
        $data['view'] = 'login';
        $this->load->view('login/index');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */