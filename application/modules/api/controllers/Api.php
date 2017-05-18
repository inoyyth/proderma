<?php

header('Content-type: application/json');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of api
 *
 * @author INOY
 */
class Api extends MX_Controller {

    var $token;

    function __construct() {
        parent::__construct();
        $this->load->library('api_validation');
        $this->api_validation->validationToken();
        $this->token = $this->api_validation->getToken();
    }

    function register_customer() {
        if (file_get_contents('php://input')) {
            $data = json_decode(file_get_contents('php://input'), true);
            $this->fetchImage($data['images']);
            exit;
        } else {
            $this->output->set_status_header('404');
            redirect('error404');
        }
    }

    public function fetchImage($data) {
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $data = base64_decode($data);
        $file = './assets/images/'. uniqid() . '.png';
        $success = file_put_contents($file, $data);

    }

}
