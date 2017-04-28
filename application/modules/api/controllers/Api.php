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

class Api extends MX_Controller{
    function __construct(){
        parent::__construct();
        $this->load->library('api_validation');
        $this->api_validation->validationToken(); 
    }
    
    function daily_visiting() {
         if(file_get_contents('php://input')){
            $data = json_decode(file_get_contents('php://input'),true);
            
         }else{
            $this->output->set_status_header('404');
            redirect('error404');
        }
    }
}
