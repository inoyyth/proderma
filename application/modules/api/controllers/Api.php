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

    function __construct() {
        parent::__construct();
        $this->load->model('main_model');
    }

    public function reload_token_login() {
        if (file_get_contents('php://input')) {
            $data = json_decode(file_get_contents('php://input'), true);
            if (count($data) < 1) {
                $this->output->set_status_header('403');
                $dt = array(
                    'code' => 403,
                    'message' => 'Forbidden, data false'
                );
            } else {
                if ($data['nToken'] == "") {
                    $this->output->set_status_header('200');
                    $dt = array(
                        'code' => 401,
                        'message' => "Unauthorized, No nToken Found");
                } elseif ($data['oToken'] == "") {
                    $this->output->set_status_header('200');
                    $dt = array(
                        'code' => 401,
                        'message' => "Unauthorized, No oToken Found");
                } else {
                    $where = array('token'=>$data['oToken']);
                    $this->db->select('*');
                    $this->db->from('account');
                    $this->db->where($where);
                    $query = $this->db->get();
                    if($query->num_rows() == 1){
                        $updateToken = $this->db->update('account',array('token'=>$data['nToken'],'token_old'=>$data['oToken']),array('token'=>$data['oToken']));
                        if($updateToken){
                            $this->output->set_status_header('200');
                            $dt=array(
                            'code'=>200,
                            'message'=>'Success !!!');
                        }else{
                            $this->output->set_status_header('200');
                            $dt=array(
                            'code'=>500,
                            'message'=>'Query FAILED !!!');
                        }
                    }else{
                        $this->output->set_status_header('200');
                        $dt=array(
                        'code'=>401,
                        'message'=>'Unauthorized, Not Data Found !!!');
                    }
                }
            }
            echo json_encode($dt);
        }else{
            $this->output->set_status_header('401');
            redirect('error404');
        }
    }

}
