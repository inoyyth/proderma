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
        $this->load->library(array('encrypt'));
        $this->load->library('api_validation');
        $this->api_validation->validationToken();
        $this->token = $this->api_validation->getToken();
    }

    private function __fetchImage($data, $folder) {
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $data = base64_decode($data);
        $image_name = strtotime(date('Y-m-d H:i:s')) . '.png';
        $file = './assets/' . $folder . '/' . $image_name;
        $success = file_put_contents($file, $data);
        return '/assets/' . $folder . '/' . $image_name;
    }
    
    private function __file_to_base64($path,$name) {
        $new_name = $name.".pdf";
        $dt = array(
           'file' => base64_encode(file_get_contents(base_url().$path)),
            'name' => $new_name,
            'format' => 'pdf'
        );
       return $dt;
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
                    $data['path_image'] = "";
                    $field = array(
                        'customer_code' => "Is Required",
                        'customer_name' => 'Is Required',
                        'customer_clinic' => 'Is Required'
                    );
                    $data['current_lead_customer_status'] = "C";
                    $this->__cek_empty_data($data, $field);
                    if (!empty($data['images'])) {
                        $fetch_image = $this->__fetchImage($data['images'], 'images/md_customer');
                        $data['path_image'] = $fetch_image;
                    }
                    if ($this->Api_model->register_lead($data)) {
                        $this->output->set_status_header('200');
                        $dt = array(
                            'code' => 200,
                            'message' => 'Success !!!'
                        );
                    } else {
                        $this->output->set_status_header('500');
                        $dt = array(
                            'code' => 500,
                            'message' => 'Query Error!!!'
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
                $dt = array(
                    'code' => 200,
                    'message' => 'Success !!!',
                    'data' => $data
                );
            } else {
                $this->output->set_status_header('500');
                $dt = array(
                    'code' => 500,
                    'message' => 'Query Error!!!'
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
                $dt = array(
                    'code' => 200,
                    'message' => 'Success !!!',
                    'data' => $data
                );
            } else {
                $this->output->set_status_header('500');
                $dt = array(
                    'code' => 500,
                    'message' => 'Query Error!!!'
                );
            }
            echo json_encode($dt);
        } else {
            $this->output->set_status_header('404');
            redirect('error404');
        }
    }

    function get_district() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($data = $this->Api_model->get_district($_GET['city'])) {
                $this->output->set_status_header('200');
                $dt = array(
                    'code' => 200,
                    'message' => 'Success !!!',
                    'data' => $data
                );
            } else {
                $this->output->set_status_header('500');
                $dt = array(
                    'code' => 500,
                    'message' => 'Query Error!!!'
                );
            }
            echo json_encode($dt);
        } else {
            $this->output->set_status_header('404');
            redirect('error404');
        }
    }

    function register_lead() {
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
                    $data['path_image'] = "";
                    $field = array(
                        'customer_code' => "Is Required",
                        'customer_name' => 'Is Required',
                        'customer_clinic' => 'Is Required'
                    );
                    $data['current_lead_customer_status'] = "L";
                    $this->__cek_empty_data($data, $field);
                    if (!empty($data['images'])) {
                        $fetch_image = $this->__fetchImage($data['images'], 'images/md_customer');
                        $data['path_image'] = $fetch_image;
                    }
                    if ($this->Api_model->register_lead($data)) {
                        $this->output->set_status_header('200');
                        $dt = array(
                            'code' => 200,
                            'message' => 'Success !!!'
                        );
                    } else {
                        $this->output->set_status_header('500');
                        $dt = array(
                            'code' => 500,
                            'message' => 'Query Error!!!'
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

    function group_customer() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($data = $this->Api_model->group_customer()) {
                $this->output->set_status_header('200');
                $dt = array(
                    'code' => 200,
                    'message' => 'Success !!!',
                    'data' => $data
                );
            } else {
                $this->output->set_status_header('500');
                $dt = array(
                    'code' => 500,
                    'message' => 'Query Error!!!'
                );
            }
            echo json_encode($dt);
        } else {
            $this->output->set_status_header('404');
            redirect('error404');
        }
    }

    function source_customer() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($data = $this->Api_model->source_customer()) {
                $this->output->set_status_header('200');
                $dt = array(
                    'code' => 200,
                    'message' => 'Success !!!',
                    'data' => $data
                );
            } else {
                $this->output->set_status_header('500');
                $dt = array(
                    'code' => 500,
                    'message' => 'Query Error!!!'
                );
            }
            echo json_encode($dt);
        } else {
            $this->output->set_status_header('404');
            redirect('error404');
        }
    }

    function status_customer() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($data = $this->Api_model->status_customer()) {
                $this->output->set_status_header('200');
                $dt = array(
                    'code' => 200,
                    'message' => 'Success !!!',
                    'data' => $data
                );
            } else {
                $this->output->set_status_header('500');
                $dt = array(
                    'code' => 500,
                    'message' => 'Query Error!!!'
                );
            }
            echo json_encode($dt);
        } else {
            $this->output->set_status_header('404');
            redirect('error404');
        }
    }

    function get_list_customer() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($data = $this->Api_model->get_list_customer($_GET['q'])) {
                $this->output->set_status_header('200');
                $dt = array(
                    'code' => 200,
                    'message' => 'Success !!!',
                    'data' => $data
                );
            } else {
                $this->output->set_status_header('500');
                $dt = array(
                    'code' => 500,
                    'message' => 'Query Error!!!'
                );
            }
            echo json_encode($dt);
        } else {
            $this->output->set_status_header('404');
            redirect('error404');
        }
    }

    function logout() {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            if ($data = $this->Api_model->logout($this->token)) {
                $this->output->set_status_header('200');
                $dt = array(
                    'code' => 200,
                    'message' => 'Success !!!',
                );
            } else {
                $this->output->set_status_header('500');
                $dt = array(
                    'code' => 500,
                    'message' => 'Query Error!!!'
                );
            }
            echo json_encode($dt);
        } else {
            $this->output->set_status_header('404');
            redirect('error404');
        }
    }

    function payment_type() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($data = $this->Api_model->payment_type()) {
                $this->output->set_status_header('200');
                $dt = array(
                    'code' => 200,
                    'message' => 'Success !!!',
                    'data' => $data
                );
            } else {
                $this->output->set_status_header('500');
                $dt = array(
                    'code' => 500,
                    'message' => 'Query Error!!!'
                );
            }
            echo json_encode($dt);
        } else {
            $this->output->set_status_header('404');
            redirect('error404');
        }
    }

    function discount_type() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($data = $this->Api_model->discount_type()) {
                $this->output->set_status_header('200');
                $dt = array(
                    'code' => 200,
                    'message' => 'Success !!!',
                    'data' => $data
                );
            } else {
                $this->output->set_status_header('500');
                $dt = array(
                    'code' => 500,
                    'message' => 'Query Error!!!'
                );
            }
            echo json_encode($dt);
        } else {
            $this->output->set_status_header('404');
            redirect('error404');
        }
    }

    public function get_product() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($data = $this->Api_model->get_product()) {
                $this->output->set_status_header('200');
                $dt = array(
                    'code' => 200,
                    'message' => 'Success !!!',
                    'data' => $data
                );
            } else {
                $this->output->set_status_header('500');
                $dt = array(
                    'code' => 500,
                    'message' => 'Query Error!!!'
                );
            }
            echo json_encode($dt);
        } else {
            $this->output->set_status_header('404');
            redirect('error404');
        }
    }

    public function form_kunjungan() {
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
                    $data['signature_path'] = "";
                    $field = array(
                        'date' => "Date Is Required",
                        'id_customer' => 'ID customer Is Required',
                        'id_sales' => 'ID sales Is Required',
                        'activity' => 'Activity is required',
                        'longitude'=> 'Longitude is required',
                        'latitude' => 'Latitude is required',
                        'signature' => 'Signature is required'
                    );
                    
                    $this->__cek_empty_data($data, $field);
                    if (!empty($data['signature'])) {
                        $fetch_image = $this->__fetchImage($data['signature'], 'images/sales_visitor');
                        $data['signature_path'] = $fetch_image;
                    }
                    if ($this->Api_model->sales_visitor($data)) {
                        $this->output->set_status_header('200');
                        $dt = array(
                            'code' => 200,
                            'message' => 'Success !!!'
                        );
                    } else {
                        $this->output->set_status_header('500');
                        $dt = array(
                            'code' => 500,
                            'message' => 'Query Error!!!'
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
    
    public function sales_order() {
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
                    $data['signature_path'] = "";
                    $field = array(
                        'date' => "Date Is Required",
                        'id_customer' => 'ID customer Is Required',
                        'id_sales' => 'ID sales Is Required',
                        'payment_type' => 'Activity is required',
                        'status'=> 'Status is required',
                        'total' => 'Total is required',
                        'discount_type' => 'Discount type is required',
                        'discount_value' => 'Discount value is required',
                        'tax_amount' => 'Tax amount is required',
                        'grand_total' => 'Grand total is required',
                        'signature' => 'Signature is required'
                    );
                    
                    $this->__cek_empty_data($data, $field);
                    
                    if (count($data['product']) < 1) {
                        $this->output->set_status_header('200');
                        $dt = array(
                            'code' => 201,
                            'message' => "Failed",
                            'data' => $dx
                        );
                        echo json_encode($dt);
                        exit;
                    }
                    
                    if (!empty($data['signature'])) {
                        $fetch_image = $this->__fetchImage($data['signature'], 'images/sales_order');
                        $data['signature_path'] = $fetch_image;
                    }
                    
                    if ($this->Api_model->sales_order($data)) {
                        $this->output->set_status_header('200');
                        $dt = array(
                            'code' => 200,
                            'message' => 'Success !!!'
                        );
                    } else {
                        $this->output->set_status_header('500');
                        $dt = array(
                            'code' => 500,
                            'message' => 'Query Error!!!'
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
    
    function get_activity() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($data = $this->Api_model->get_activity()) {
                $this->output->set_status_header('200');
                $dt = array(
                    'code' => 200,
                    'message' => 'Success !!!',
                    'data' => $data
                );
            } else {
                $this->output->set_status_header('500');
                $dt = array(
                    'code' => 500,
                    'message' => 'Query Error!!!'
                );
            }
            echo json_encode($dt);
        } else {
            $this->output->set_status_header('404');
            redirect('error404');
        }
    }
    
    public function plan() {
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
                        'visit_form_subject' => "Subject Is Required",
                        'visit_form_sales' => 'Sales Is Required',
                        'visit_form_activity' => 'Activity Is Required',
                        'visit_form_attendence' => 'Attendence is required',
                        'visit_form_start_date'=> 'Start date is required',
                        'visit_form_end_date' => 'End date is required',
                        'visit_form_location' => 'Location is required',
                        'visit_form_description' => 'Description is required',
                        'visit_form_objective' => 'Objective is required'
                    );
                    
                    $this->__cek_empty_data($data, $field);
                    
                    if ($this->Api_model->plan($data)) {
                        $this->output->set_status_header('200');
                        $dt = array(
                            'code' => 200,
                            'message' => 'Success !!!'
                        );
                    } else {
                        $this->output->set_status_header('500');
                        $dt = array(
                            'code' => 500,
                            'message' => 'Query Error!!!'
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
    
    public function promo() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($data = $this->Api_model->promo()) {
                
                $dtx = array();
                foreach ($data as $k=>$v) {
                    $b64Doc = $this->__file_to_base64($v['promo_file'],$v['promo_name']);
                    $dtx[] = array(
                        'promo_code'=>$v['promo_code'],
                        'promo_name' => $v['promo_name'],
                        'promo_description' => $v['promo_description'],
                        'promo_start_date' => $v['promo_start_date'],
                        'promo_end_date' => $v['promo_end_date'],
                        'promo_file' => $b64Doc
                    );
                }
                $this->output->set_status_header('200');
                $dt = array(
                    'code' => 200,
                    'message' => 'Success !!!',
                    'data' => $dtx
                );
            } else {
                $this->output->set_status_header('500');
                $dt = array(
                    'code' => 500,
                    'message' => 'Query Error!!!'
                );
            }
            echo json_encode($dt);
        } else {
            $this->output->set_status_header('404');
            redirect('error404');
        }
    }
    
    public function log_pdf() {
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
                        'id_promo' => "Promo ID Is Required",
                        'id_sales' => 'Sales ID Is Required',
                        'promo_code' => 'Promo Code Is Required',
                        'datetime' => 'Datetime is required'
                    );
                    
                    $this->__cek_empty_data($data, $field);
                    
                    if ($this->Api_model->log_pdf($data)) {
                        $this->output->set_status_header('200');
                        $dt = array(
                            'code' => 200,
                            'message' => 'Success !!!'
                        );
                    } else {
                        $this->output->set_status_header('500');
                        $dt = array(
                            'code' => 500,
                            'message' => 'Query Error!!!'
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
