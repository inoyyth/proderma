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
        $this->load->model('Api/Api_model');
        $this->load->library('api_validation');
        $this->api_validation->validationToken();
        $this->token = $this->api_validation->getToken();
    }
    
    private function __fetchImage($data,$folder) {
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $data = base64_decode($data);
        $image_name =  strtotime(date('Y-m-d H:i:s')) . '.png';
        $file = './assets/' . $folder . '/' . $image_name;
        $success = file_put_contents($file, $data);
        return '/assets/' . $folder . '/' . $image_name;

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
                'message' => "Failed",
                'data' => $dx
            );
            echo json_encode($dt);
            exit;
        }
        return true;
    }

    function register_customer() {
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
                        'customer_code'=>"Is Required",
                        'customer_name'=>'Is Required',
                        'customer_clinic'=>'Is Required'
                    );
                    $this->__cek_empty_data($data,$field);
                    if(!empty($data['images'])){
                        $fetch_image = $this->__fetchImage($data['images'],'images/md_customer');
                        $data['path_image'] = $fetch_image;
                    }
                    if ($this->Api_model->register_customer($data)) {              
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
    
    function get_province() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($data = $this->Api_model->get_province()) {              
                $this->output->set_status_header('200');
                $dt=array(
                    'code'=>200,
                    'message'=>'Success !!!',
                    'data' => $data
                );
            } else {
                $this->output->set_status_header('500');
                $dt=array(
                    'code'=>500,
                    'message'=>'Query Error!!!'
                );
            }
            echo json_encode($dt);
        } else {
            $this->output->set_status_header('404');
            redirect('error404');
        }
    }
    
    function get_city() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($data = $this->Api_model->get_city($_GET['province'])) {              
                $this->output->set_status_header('200');
                $dt=array(
                    'code'=>200,
                    'message'=>'Success !!!',
                    'data' => $data
                );
            } else {
                $this->output->set_status_header('500');
                $dt=array(
                    'code'=>500,
                    'message'=>'Query Error!!!'
                );
            }
            echo json_encode($dt);
        } else {
            $this->output->set_status_header('404');
            redirect('error404');
        }
    }

}
