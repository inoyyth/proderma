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
class Api_Login extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('Api/Api_model');
        $this->load->library(array('encrypt','api_validation'));
    }
    
    private function __cek_empty_data($data=array(),$field=array()){
        $dx = array();
        foreach($field as $key=>$v) {
            if(in_array($key, array_keys($data))) {
                if($data[$key] == null || $data[$key] == ""){
                    $dx[]= array($key=>$v);
                }
            }
        }
        
        if(count($dx) > 0){
            $this->output->set_status_header('200');
            $dt = array(
                'code' => 201,
                'message' => "Failed"
            );
            echo json_encode($dt);
            exit;
        }
        return true;
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (file_get_contents('php://input')) {
                $data = json_decode(file_get_contents('php://input'), true);
                if (count($data) < 1) {
                    $this->output->set_status_header('403');
                    $dt = array(
                        'code' => 403,
                        'message' => 'Forbidden, data false'
                    );
                } else {
                    $field = array(
                        'username'=>"Is Required",
                        'password'=>'Is Required',
                    );
                    
                    if ($data_login = $this->Api_model->login($data)) {              
                        $this->output->set_status_header('200');
                        $dt=array(
                            'code'=>200,
                            'message'=>'Success !!!',
                            'data' => array('token' => $data_login['token'])
                        );
                    } else {
                        $this->output->set_status_header('200');
                        $dt=array(
                            'code'=>201,
                            'message'=>'Data Not Exist!!!'
                        );
                    }
                    
                }
                echo json_encode($dt);
            } else {
                $this->output->set_status_header('404');
                redirect('error404');
            }
        } else {
            $this->output->set_status_header('404');
            redirect('error404');
        }
    }
}