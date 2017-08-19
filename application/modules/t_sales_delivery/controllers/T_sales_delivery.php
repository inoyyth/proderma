<?php

class T_sales_delivery extends MX_Controller {

    var $table = "t_delivery_order";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_t_sales_delivery' => 'm_sales_delivery', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Sales Delivery', '/sales-delivery');
    }

    public function index() {
        $data['template_title'] = array('Sales Delivery', 'List');
        $data['view'] = 't_sales_delivery/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 't_delivery_order'; 
        
        $field = array(
            "t_delivery_order.*",
            "t_sales_order.so_code",
            "IF(t_delivery_order.do_status=1,'Active','Not Active') AS status"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 't_sales_order', 'where' => 't_sales_order.id=t_delivery_order.id_so', 'join' => 'left')
        );
        
        $like = array(
            't_delivery_order.do_code'=>isset($_POST['do_code'])?$_POST['do_code']:"",
            't_sales_order.so_code'=>isset($_POST['so_code'])?$_POST['so_code']:""
        );
        $where = array('t_delivery_order.do_status !=' => '3');
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"t_delivery_order.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_sales_delivery->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

        $total_records = $this->data_table->count_all($table, $where);
        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $this->data_table->count_all($table, $where),
            "data" => $list,
        );
        //output to json format
        echo json_encode($output);
    }
    
    public function getListTableCustomer() {
        $page = 1;
        if(isset($_POST['page'])) {
            $page = ($_POST['page']==0 ? 1 : $_POST['page']);
        }
        $limit = 10;
        if(isset($_POST['size'])) {
            $limit = $_POST['size'];
        }
        
        $table = 't_sales_order'; 
        
        $field = array(
            "t_sales_order.*",
            "m_customer.customer_code",
            "m_customer.customer_name",
            "IF(t_sales_order.so_status=1,'Active','Not Active') AS status"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'm_customer', 'where' => 'm_customer.id=t_sales_order.id_customer', 'join' => 'left')
        );
        $like = array(
            'm_customer.customer_code'=>isset($_POST['customer_code'])?$_POST['customer_code']:"",
            'm_customer.customer_name'=>isset($_POST['customer_name'])?$_POST['customer_name']:"",
            't_sales_order.so_code'=>isset($_POST['so_code'])?$_POST['so_code']:""
        );
        $where = array(
            't_sales_order.so_status !=' => '3',
            //'t_sales_order.so_payment_term'=>isset($_POST['so_payment_term'])?$_POST['so_payment_term']:"",
            //'t_sales_order.so_discount_type'=>isset($_POST['so_discount_type'])?$_POST['so_discount_type']:""
        );
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"t_sales_order.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_sales_delivery->getListTableSo($field,$table, $join, $like, $where, $sort, $limit_row);

        $total_records = $this->data_table->count_all($table, $where);
        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $total_records,
            "data" => $list,
        );
        //output to json format
        echo json_encode($output);
    }

    public function add() {
        $this->breadcrumbs->push('Add', '/sales-delivery-add');
        $data['code'] = $this->main_model->generate_code('t_delivery_order', $this->config->item('do_code'),'/' , $digit = 5, true,false, $where=array(),'id','id');
        $data['view'] = "t_sales_delivery/add";
        $this->load->view('default', $data);
    }

    public function detail($id) {
        $this->breadcrumbs->push('Detail', '/sales-delivery-detail');
        $data['data'] = $this->m_sales_delivery->get_detail($id)->row_array();
        $data['view'] = 't_sales_delivery/detail';
        $this->load->view('default', $data);
    }

    function delete($id) {
        if ($this->db->update($this->table, array('do_status' => 3),array('id'=>$id))) {
            $this->session->set_flashdata('success', 'Data Berhasil Di Hapus !');
        } else {
            $this->session->set_flashdata('error', 'Data Gagal Di Hapus !');
        }
        redirect("sales-delivery");
    }

    function save() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_sales_delivery->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("sales-delivery");
        } else {
            show_404();
        }
    }

    public function printdetail($id) {
        $data['data'] = $this->m_sales_delivery->get_detail($id)->row_array();
        $data['customer'] = $this->m_sales_delivery->get_customer($data['data']['id_so'])->row_array();
        $data['list_product'] = $this->m_sales_delivery->get_list_product($data['data']['id_so'])->result_array();
        $this->load->view('t_sales_delivery/print',$data);
    }

    public function print_pdf() {
        $data['template'] = array("template" => "t_sales_delivery/" . $_GET['template'], "filename" => $_GET['name']);
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->printpdf->create_pdf($data);
    }

    public function print_excel() {
        $data['template_excel'] = "t_sales_delivery/" . $_GET['template'];
        $data['file_name'] = $_GET['name'];
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->load->view('template_excel', $data);
    }

}
