<?php

class Product_category extends MX_Controller {

    var $table = "product_category";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_product_category' => 'product_category'));
        $this->load->library(array('Auth_log','Table_fitersession'));
        //set breadcrumb
        //$this->breadcrumbs->push('Master Gudang', '/product-category');
    }

    public function index() {
        $data_session = $this->table_fitersession->renders(array('page','product_category_code','product_category_name','product_category_status'));
        $config['base_url'] = base_url() . 'product-category-page';
        $config['total_rows'] = count($this->product_category->getdata($this->table, 0, 1000, $like = $data_session, $where = array('product_category_status!=' => '3','user_id'=>$this->sessionGlobal['id'])));
        $config['per_page'] = (!empty($data_session['page']) ? $data_session['page'] : 10);
        $config['uri_segment'] = 2;
        $limit = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $this->pagination->initialize($config);
        $data['paging'] = $this->pagination->create_links();
        $data['data'] = $this->product_category->getdata($this->table, $limit, $config['per_page'], $like = $data_session, $where = array('product_category_status!=' => '3','user_id'=>$this->sessionGlobal['id']));
        $data['total_rows'] = $config['total_rows'];
        $data['sr_data'] = $data_session;
        $data['params_status']=$this->main_model->getMaster('global_params',array(),array('params'=>'status','code !='=>'3'));
        $data['view'] = 'product_category/main';
        $this->load->view('default', $data);
    }

    public function add() {
        //$this->breadcrumbs->push('Add', '/product-category-tambah');
        $data['params_status']=$this->main_model->getMaster('global_params',array(),array('params'=>'status','code !='=>'3'));
        $data['code'] = $this->main_model->generate_code($this->table, 'CTY', '-',4,false,false,array('user_id'=>$this->sessionGlobal['id']),'product_category_code','id');
        $data['view'] = "product_category/add";
        $this->load->view('default', $data);
    }

    public function edit($id) {
        //$this->breadcrumbs->push('Edit', '/product-category-edit');
        $data['params_status']=$this->main_model->getMaster('global_params',array(),array('params'=>'status','code !='=>'3'));
        $data['detail'] = $this->db->get_where($this->table, array('id' => $id,'user_id'=>$this->sessionGlobal['id']))->row_array();
        $data['view'] = 'product_category/edit';
        $this->load->view('default', $data);
    }

    function delete($id) {
        $this->main_model->delete('product_category', array('id' => $id), array('product_category_status' => '3','user_id'=>$this->sessionGlobal['id']));
        redirect("product-category");
    }

    function save() {
        if ($_POST) {
            $user_id = $this->sessionGlobal['id'];
            if ($this->product_category->save($user_id)) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("product-category");
        } else {
            show_404();
        }
    }

    public function print_pdf() {
        $data['template'] = array("template" => "product_category/" . $_GET['template'], "filename" => $_GET['name']);
        $data['list'] = $this->product_category->getdata($this->table, 0, 1000, $like = array(), $where = array('product_category_status!=' => '3','user_id'=>$this->sessionGlobal['id']));
        $this->printpdf->create_pdf($data);
    }

    public function print_excel() {
        $data['template_excel'] = "product_category/" . $_GET['template'];
        $data['file_name'] = $_GET['name'];
        $data['list'] = $this->product_category->getdata($this->table, 0, 1000, $like = array(), $where = array('product_category_status!=' => '3','user_id'=>$this->sessionGlobal['id']));
        $this->load->view('template_excel', $data);
    }
}
