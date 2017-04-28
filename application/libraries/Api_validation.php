<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Codeigniter Multilevel menu Class
 * Provide easy way to render multi level menu
 * 
 */
class Api_validation {

    private $token;
    private $ci;
    
    function __construct(){
        
        $this->ci = & get_instance();
        $this->ci->load->model('Api/Api_model');
    }
    
    function validationToken(){
        $headers = apache_request_headers();
        if(isset($headers['Token'])){
            //$data = $this->ci->Api_model->getHeaderData($header['token']);
            return true;
        } else {
            echo json_encode(array('code'=>201,"message"=>'Fail Please Login First'));
            return false;
        }
    }

}
