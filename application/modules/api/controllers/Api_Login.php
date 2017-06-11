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
        $this->load->library('api_validation');
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
                    $data['path_image']="";
                    $field = array(
                        'username'=>"Is Required",
                        'password'=>'Is Required',
                        'customer_clinic'=>'Is Required'
                    );
                    $data['current_lead_customer_status'] = "C";
                    $this->__cek_empty_data($data,$field);
                    if(!empty($data['images'])){
                        $fetch_image = $this->__fetchImage($data['images'],'images/md_customer');
                        $data['path_image'] = $fetch_image;
                    }
                    if ($this->Api_model->register_lead($data)) {              
                        $this->output->set_status_header('200');
                        $dt=array(
                            'code'=>200,
                            'message'=>'Success !!!'
                        );
                    } else {
                        $this->output->set_status_header('500');
                        $dt=array(
                            'code'=>500,
                            'message'=>'Query Error!!!'
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