<?php

class T_pay_duedate extends MX_Controller {

    var $table = "t_pay_duedate";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_t_pay_duedate' => 'm_duedate', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Due Date', '/payment-due-date');
    }

    public function index() {
        $data['template_title'] = array('Due Date', 'List');
        $data['view'] = 't_pay_duedate/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 't_pay_duedate'; 
        
        $field = array(
            "t_pay_duedate.*",
            "t_sales_order.so_code",
            "t_delivery_order.do_code",
            "t_invoice.invoice_code",
            "t_invoice.due_date",
            "(CASE WHEN DATE(due_date) <= DATE(NOW()) AND t_pay_duedate.pay_duedate_status = 'WAIT' THEN 'red' WHEN DATE(due_date) <= DATE(NOW()) AND t_pay_duedate.pay_duedate_status = 'DONE' THEN 'green' WHEN DATE(due_date) >= DATE(NOW()) AND t_pay_duedate.pay_duedate_status = 'DONE' THEN 'green' ELSE 'yellow' END) AS color"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 't_invoice', 'where' => 't_pay_duedate.id_invoice=t_invoice.id', 'join' => 'left'),
            array('table' => 't_delivery_order', 'where' => 't_invoice.id_do=t_delivery_order.id', 'join' => 'left'),
            array('table' => 't_sales_order', 'where' => 't_invoice.id_so=t_sales_order.id', 'join' => 'left')
        );
        
        $like = array(
            't_sales_order.so_code'=>isset($_POST['so_code'])?$_POST['so_code']:"",
            't_delivery_order.do_code'=>isset($_POST['do_code'])?$_POST['do_code']:"",
            't_invoice.invoice_code'=>isset($_POST['invoice_code'])?$_POST['invoice_code']:"",
        );
        $where = array();
		if($this->sessionGlobal['super_admin'] == "1") {
            $where['t_sales_order.id_branch'] = $this->sessionGlobal['id_branch'];
        }
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"t_pay_duedate.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_duedate->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

        $total_records = count($list);
        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $total_records,
            "data" => $list,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id) {
        $this->breadcrumbs->push('Edit', '/payment-due-date-edit');
        $data['data'] = $this->m_duedate->getDetail($this->table, array($this->table.'.id' => $id))->row_array();
        $data['view'] = 't_pay_duedate/edit';
        $this->load->view('default', $data);
    }

    function save() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_duedate->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("payment-due-date");
        } else {
            show_404();
        }
    }
}
