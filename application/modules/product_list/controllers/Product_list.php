<?php

class Product_list extends MX_Controller {

    var $table = "product_list";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_product_list' => 'product_list'));
        $this->load->library(array('Auth_log', 'Upload_cloudinary','Table_fitersession'));
        //set breadcrumb
        //$this->breadcrumbs->push('Master Gudang', '/product-list');
    }

    public function index() { 
        $data_session = $this->table_fitersession->renders(array('page','product_list_sku','product_category_name','product_brand_name','product_list_name','product_list_status'));
        $config['base_url'] = base_url() . 'product-list-page';
        $config['per_page'] = (!empty($data_session['page']) ? $data_session['page'] : 10);
        $config['total_rows'] = count($this->product_list->getdata($this->table, 0, 1000, $like = $data_session, $where = array('product_list_status!=' => '3', 'product_list`.`user_id' => $this->sessionGlobal['id'])));
        $config['uri_segment'] = 2;
        $limit = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $this->pagination->initialize($config);
        $data['paging'] = $this->pagination->create_links();
        $data['data'] = $this->product_list->getdata($this->table, $limit, $config['per_page'], $like = $data_session, $where = array('product_list_status!=' => '3', 'product_list`.`user_id' => $this->sessionGlobal['id']));
        $data['total_rows'] = $config['total_rows'];
        $data['sr_data'] = $data_session;
        $data['params_status'] = $this->main_model->getMaster('global_params', array(), array('params' => 'status', 'code !=' => '3'));
        $data['view'] = 'product_list/main';
        $this->load->view('default', $data);
    }

    public function add() {
        //$this->breadcrumbs->push('Add', '/product-list-tambah');
        $data['params_status'] = $this->main_model->getMaster('global_params', array(), array('params' => 'status', 'code !=' => '3'));
        $data['params_unit'] = $this->main_model->getMaster('global_params', array(), array('params' => 'unit'));
        $data['params_colour'] = $this->main_model->getMaster('global_params', array(), array('params' => 'colour'));
        $data['product_category'] = $this->main_model->getMaster('product_category', array(), array('user_id' => $this->sessionGlobal['id'], 'product_category_status !=' => '3'));
        $data['product_brand'] = $this->main_model->getMaster('product_brand', array(), array('user_id' => $this->sessionGlobal['id'], 'product_brand_status !=' => '3'));
        $data['code'] = $this->main_model->generate_code($this->table, 'SKU', '-', 5, false, false, array('user_id' => $this->sessionGlobal['id']), 'product_list_sku', 'id');
        $data['view'] = "product_list/add";
        $this->load->view('default', $data);
    }

    public function edit($id) {
        $data['params_status'] = $this->main_model->getMaster('global_params', array(), array('params' => 'status', 'code !=' => '3'));
        $data['params_unit'] = $this->main_model->getMaster('global_params', array(), array('params' => 'unit'));
        $data['params_colour'] = $this->main_model->getMaster('global_params', array(), array('params' => 'colour'));
        $data['product_category'] = $this->main_model->getMaster('product_category', array(), array('user_id' => $this->sessionGlobal['id'], 'product_category_status !=' => '3'));
        $data['product_brand'] = $this->main_model->getMaster('product_brand', array(), array('user_id' => $this->sessionGlobal['id'], 'product_brand_status !=' => '3'));
        $data['product_videos'] = $this->main_model->getMaster('product_videos', array(), array('product_id' => $id));
        $data['stock'] = $this->product_list->getstock($id);
        $data['detail'] = $this->db->get_where($this->table, array('id' => $id, 'user_id' => $this->sessionGlobal['id']))->row_array();
        $data['view'] = 'product_list/edit';
        $this->load->view('default', $data);
    }

    function delete($id) {
        $this->main_model->delete('product_list', array('id' => $id), array('product_list_status' => '3', 'user_id' => $this->sessionGlobal['id']));
        redirect("product-list");
    }

    function save() {
        if ($_POST) {
            $user_id = $this->sessionGlobal['id'];
            if ($this->product_list->save($user_id)) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("product-list");
        } else {
            show_404();
        }
    }
    
    public function print_pdf() {
        $data['template'] = array("template" => "product_list/" . $_GET['template'], "filename" => $_GET['name']);
        $data['list'] = $this->product_list->getdata($this->table, 0, 1000, $like = array(), $where = array('product_list_status!=' => '3'));
        $this->printpdf->create_pdf($data);
    }

    public function print_excel() {
        $data['template_excel'] = "product_list/" . $_GET['template'];
        $data['file_name'] = $_GET['name'];
        $data['list'] = $this->product_list->getdata($this->table, 0, 1000, $like = array(), $where = array('product_list_status!=' => '3'));
        $this->load->view('template_excel', $data);
    }
    
    public function delete_image() {
        $id = $this->input->post('id');
        $key = $this->input->post('key');
        $get_image = $this->db->get_where($this->table,array('id'=>$id, 'user_id' => $this->sessionGlobal['id']))->row_array();
        $imgArray = unserialize($get_image['product_list_images']);
        \Cloudinary\Uploader::destroy('assets/images/product/'.$imgArray[$key]);
        unset($imgArray[$key]);
        $serialize = serialize($imgArray);
        $dt = array('product_list_images'=>$serialize);
        $query = $this->db->update($this->table,$dt,array('id'=>$id, 'user_id' => $this->sessionGlobal['id']));
        if($query){
            $response = array('code'=>200,'message'=>'success');
        }else{
            $response = array('code'=>500,'message'=>'failed');
        }
        echo json_encode($response);
    }

}
