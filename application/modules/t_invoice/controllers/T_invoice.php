<?php

class T_invoice extends MX_Controller {

    var $table = "t_invoice";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_t_invoice' => 'm_invoice', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Transaction', '/dasboard');
        $this->breadcrumbs->push('Invoice', '/invoice');
    }

    public function index() {
        $data['template_title'] = array('Invoice', 'List');
        $data['view'] = 't_invoice/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 't_invoice'; 
        
        $field = array(
            "t_invoice.*",
            "t_sales_order.so_code",
            "t_delivery_order.do_code",
			"m_customer.customer_code",
			"m_customer.customer_name",
            "IF(t_invoice.invoice_status=1,'Active','Not Active') AS status"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 't_sales_order', 'where' => 't_sales_order.id=t_invoice.id_so', 'join' => 'left'),
            array('table' => 't_delivery_order', 'where' => 't_delivery_order.id=t_invoice.id_do', 'join' => 'left'),
			array('table' => 'm_customer', 'where' => 'm_customer.id=t_sales_order.id_customer', 'join' => 'left')
        );
        
        $like = array(
            't_delivery_order.do_code'=>isset($_POST['do_code'])?$_POST['do_code']:"",
            't_sales_order.so_code'=>isset($_POST['so_code'])?$_POST['so_code']:"",
            't_invoice.invoice_code'=>isset($_POST['invoice_code'])?$_POST['invoice_code']:""
        );
        $where_1 = array('t_invoice.invoice_status !=' => '3');
		$where_2 = array();
		if (isset($_POST['start']) && isset($_POST['end'])) {
			if($_POST['start'] != null && $_POST['end'] != null) {
				$where_2 = array(
					'date(t_invoice.invoice_date) >=' => $_POST['start'],
					'date(t_invoice.invoice_date) <=' => $_POST['end'],
				);
			} else if ($_POST['start'] != "") {
				$where_2 = array('date(t_invoice.invoice_date) >=' => $_POST['start']);
			} else if ($_POST['end'] != "") {
				$where_2 = array('date(t_invoice.invoice_date) <=' => $_POST['end']);
			}
		}
		$where_3 = array();
		if($this->sessionGlobal['super_admin'] == "1") {
            $where_3['t_sales_order.id_branch'] = $this->sessionGlobal['id_branch'];
        }
		$where = array_merge($where_1,$where_2,$where_3);
		
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"t_invoice.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_invoice->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

        $total_records = count($this->m_invoice->getListTable($field,$table, $join, $like, $where, $sort, false));
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
        $this->breadcrumbs->push('Add', '/invoice-add');
        $data['code'] = $this->main_model->generate_code('t_invoice', $this->config->item('invoice_code'),'/' , $digit = 5, true,false, $where=array(),'id','id');
        $data['view'] = "t_invoice/add";
        $this->load->view('default', $data);
    }

    public function detail($id) {
        $this->breadcrumbs->push('Detail', '/invoice-detail');
        $data['data'] = $this->m_invoice->get_detail($id)->row_array();
        $data['view'] = 't_invoice/detail';
        $this->load->view('default', $data);
    }

    function delete($id) {
        if ($this->db->update($this->table, array('invoice_status' => 3),array('id'=>$id))) {
            $this->session->set_flashdata('success', 'Data Berhasil Di Hapus !');
        } else {
            $this->session->set_flashdata('error', 'Data Gagal Di Hapus !');
        }
        redirect("invoice");
    }

    function save() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_invoice->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("invoice");
        } else {
            show_404();
        }
    }

    public function print_pdf() {
        $data['template'] = array("template" => "t_invoice/" . $_GET['template'], "filename" => $_GET['name']);
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->printpdf->create_pdf($data);
    }

    public function getListTableDo() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 't_delivery_order'; 
        
        $field = array(
            "t_delivery_order.*",
            "t_sales_order.so_code",
            "t_sales_order.so_date",
            "t_sales_order.so_payment_term",
            "t_sales_order.id as id_so",
            "m_customer.customer_name",
            "IF(t_delivery_order.do_status=1,'Active','Not Active') AS status"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 't_sales_order', 'where' => 't_sales_order.id=t_delivery_order.id_so', 'join' => 'left'),
            array('table' => 'm_customer', 'where' => 'm_customer.id=t_sales_order.id_customer', 'join' => 'left')
        );
        
        $like = array(
            't_delivery_order.do_code'=>isset($_POST['do_code'])?$_POST['do_code']:"",
            't_sales_order.so_code'=>isset($_POST['so_code'])?$_POST['so_code']:"",
            'm_customer.customer_name'=>isset($_POST['customer_name'])?$_POST['customer_name']:""
        );
        $where = array('t_delivery_order.do_status !=' => '3');
		if($this->sessionGlobal['super_admin'] == "1") {
            $where['t_sales_order.id_branch'] = $this->sessionGlobal['id_branch'];
        }
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"t_delivery_order.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_invoice->getListTableDo($field,$table, $join, $like, $where, $sort, $limit_row);

        $total_records = count($this->m_invoice->getListTableDo($field,$table, $join, $like, $where, $sort, false));
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
        $data['data'] = $this->m_invoice->get_detail_so($id)->row_array();
        $data['list_product'] = $this->m_invoice->get_list_product($id)->result_array();
        $data['data_product'] = $this->m_invoice->get_detail_product($id)->row_array();
        $data['due_date'] = $this->db->get_where('t_pay_duedate',array('id_invoice'=>$data['data']['id_invoice']))->row_array();
        $this->load->view('t_invoice/print',$data);
    }
	
	public function print_excel() {
		$table = 't_invoice'; 
        $field = array(
            "t_invoice.*",
            "t_sales_order.so_code",
            "t_delivery_order.do_code",
			"m_customer.customer_code",
			"m_customer.customer_name",
            "IF(t_invoice.invoice_status=1,'Active','Not Active') AS status"
        );
        $join = array(
            array('table' => 't_sales_order', 'where' => 't_sales_order.id=t_invoice.id_so', 'join' => 'left'),
            array('table' => 't_delivery_order', 'where' => 't_delivery_order.id=t_invoice.id_do', 'join' => 'left'),
			array('table' => 'm_customer', 'where' => 'm_customer.id=t_sales_order.id_customer', 'join' => 'left')
        );
        $like = array();
        $where_1 = array('t_invoice.invoice_status !=' => '3');
		$where_2 = array();
		if (isset($_GET['start']) && isset($_GET['end'])) {
			if($_GET['start'] != null && $_GET['end'] != null) {
				$where_2 = array(
					'date(t_invoice.invoice_date) >=' => $_GET['start'],
					'date(t_invoice.invoice_date) <=' => $_GET['end'],
				);
			} else if ($_GET['start'] != "") {
				$where_2 = array('date(t_invoice.invoice_date) >=' => $_GET['start']);
			} else if ($_GET['end'] != "") {
				$where_2 = array('date(t_invoice.invoice_date) <=' => $_GET['end']);
			}
		}
		$where_3 = array();
		if($this->sessionGlobal['super_admin'] == "1") {
            $where_3['t_sales_order.id_branch'] = $this->sessionGlobal['id_branch'];
        }
		$where = array_merge($where_1,$where_2,$where_3);
		
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"t_invoice.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );
        
		$data['list'] = $this->m_invoice->getListTable($field,$table, $join, $like, $where, $sort, false);
        $data['template_excel'] = "t_invoice/table_excel";
        $data['file_name'] = "invoice";
        $this->load->view('template_excel', $data);
    }
}
