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
            't_sales_order.employee_status !=' => '3',
            't_sales_order.so_payment_term'=>isset($_POST['so_payment_term'])?$_POST['so_payment_term']:"",
            't_sales_order.so_discount_type'=>isset($_POST['so_discount_type'])?$_POST['so_discount_type']:""
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

        /*foreach ($list as $result) {
            $data[] = array(
                'id' => $result['id'],
                'username' => $result['username'],
                'nama_lengkap' => $result['nama_lengkap'],
                'last_login' => $result['last_login']
            );
        }*/
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

    public function add() {
        $this->breadcrumbs->push('Add', '/master-employee-add');
        $data['jabatan'] = $this->db->get_where('m_jabatan',array('jabatan_status'=>1))->result_array();
        $data['view'] = "t_sales_order/add";
        $this->load->view('default', $data);
    }

    public function edit($id) {
        $this->breadcrumbs->push('Edit', '/master-employee-edit');
        $data['jabatan'] = $this->db->get_where('m_jabatan',array('jabatan_status'=>1))->result_array();
        $data['data'] = $this->db->get_where($this->table, array('id' => $id))->row_array();
        $data['view'] = 't_sales_order/edit';
        $this->load->view('default', $data);
    }

    function delete($id) {
        if ($this->db->update($this->table, array('employee_status' => 3),array('id'=>$id))) {
            $this->session->set_flashdata('success', 'Data Berhasil Di Hapus !');
        } else {
            $this->session->set_flashdata('error', 'Data Gagal Di Hapus !');
        }
        redirect("master-employee");
    }

    function save() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_t_sales_order->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("master-employee");
        } else {
            show_404();
        }
    }

    public function print_pdf() {
        $data['template'] = array("template" => "t_sales_order/" . $_GET['template'], "filename" => $_GET['name']);
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->printpdf->create_pdf($data);
    }

    public function print_excel() {
        $data['template_excel'] = "t_sales_order/" . $_GET['template'];
        $data['file_name'] = $_GET['name'];
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->load->view('template_excel', $data);
    }

}
