<?php

class T_sales_order extends MX_Controller {

    var $table = "t_sales_order";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_t_sales_order' => 'm_t_sales_order', 'Datatable_model' => 'data_table'));
        $this->load->library(array('upload', 'encrypt', 'Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Sales Order', '/sales-order');
    }

    public function index() {
        $data['template_title'] = array('Sales Order', 'List');
        $data['view'] = 't_sales_order/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
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
        );
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"t_sales_order.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_t_sales_order->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

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

    public function detail($id) {
        $this->breadcrumbs->push('Detail', '/master-employee-edit');
        $data['data'] = $this->m_t_sales_order->get_detail($id)->row_array();
        $data['data_product'] = $this->m_t_sales_order->get_detail_product($id)->row_array();
        $data['view'] = 't_sales_order/detail';
        $this->load->view('default', $data);
    }
    
    public function getProductList($id) {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 't_sales_order_product'; 
        
        $field = array(
            "t_sales_order_product.*",
            "m_product.product_code",
            "m_product.product_name",
            "m_product.product_price",
            "sum(t_sales_order_product.qty * m_product.product_price) as SubTotal"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'm_product', 'where' => 'm_product.id=t_sales_order_product.id_product', 'join' => 'left')
        );
        $like = array();
        $where = array(
            't_sales_order_product.id_sales_order' => $id,
        );
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"t_sales_order_product.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        $groupby = array('t_sales_order_product.id');
        $list = $this->m_t_sales_order->getListTable($field,$table, $join, $like, $where, $sort, $limit_row,$groupby);

        $total_records = $this->data_table->count_all($table, $where,$groupby);
        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $total_records,
            "data" => $list,
        );
        //output to json format
        echo json_encode($output);
    }
    
    public function printdetail($id) {
        $data['data'] = $this->m_t_sales_order->get_detail($id)->row_array();
        $data['data_product'] = $this->m_t_sales_order->get_detail_product($id)->row_array();
        $this->load->view('t_sales_order/print',$data);
    }
}
