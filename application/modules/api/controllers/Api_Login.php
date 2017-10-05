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
        $this->load->library(array('encrypt', 'api_validation'));
    }

    private function __cek_empty_data($data = array(), $field = array()) {
        $dx = array();
        foreach ($field as $key => $v) {
            if (in_array($key, array_keys($data))) {
                if ($data[$key] == null || $data[$key] == "") {
                    $dx[] = array($key => $v);
                }
            }
        }

        if (count($dx) > 0) {
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
                        'username' => "Is Required",
                        'password' => 'Is Required',
                    );

                    if ($data_login = $this->Api_model->login($data)) {
                        $b64Doc = $this->__file_to_base64($data_login['photo_path'], $data_login['employee_nip'], 'jpg');
                        $this->output->set_status_header('200');
                        $dt = array(
                            'code' => 200,
                            'message' => 'Success !!!',
                            'data' => array(
                                'token' => $data_login['token'],
                                'id' => $data_login['id'],
                                'employee_nip' => $data_login['employee_nip'],
                                'employee_name' => $data_login['employee_name'],
                                'employee_email' => $data_login['employee_email'],
                                'employee_phone' => $data_login['employee_phone'],
                                'id_branch' => $data_login['id_branch'],
                                'branch_name' => $data_login['branch_name'],
                                'default_area' => $data_login['default_area'],
                                'image' => $b64Doc
                            )
                        );
                    } else {
                        $this->output->set_status_header('200');
                        $dt = array(
                            'code' => 201,
                            'message' => 'Data Not Exist!!!'
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

    private function __file_to_base64($path, $name, $format = 'pdf') {
        $new_name = $name . "." . $format;
        $dt = array(
            'file' => base64_encode(file_get_contents(base_url() . $path)),
            'name' => $new_name,
            'format' => $format
        );
        return $dt;
    }

}
