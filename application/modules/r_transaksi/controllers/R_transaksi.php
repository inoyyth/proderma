<?php

class R_transaksi extends MX_Controller {

    var $table = "t_sales_order";

    public function __construct() {
        parent::__construct();
            $this->load->model(array('M_r_transaksi' => 'm_transaksi', 'Datatable_model' => 'data_table'));
        $this->load->library(array('upload', 'encryption', 'Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Status Transaksi', '/sales-order');
    }

    public function index() {
        $data['template_title'] = array('Status Transaksi', 'List');
        $data['view'] = 'r_transaksi/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 't_sales_order'; 
        
        $field = array(
            "t_sales_order.*",
            "IF(t_sales_order.so_status=1,'Active','Not Active') AS status"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array();
        $like = array(
            't_sales_order.so_code'=>isset($_POST['so_code'])?$_POST['so_code']:""
        );
        $where_1 = array(
            't_sales_order.so_status !=' => '3',
        );
		$where_2 = array();
		if (isset($_POST['start']) && isset($_POST['end'])) {
			if($_POST['start'] != null && $_POST['end'] != null) {
				$where_2 = array(
					'date(t_sales_order.so_date) >=' => $_POST['start'],
					'date(t_sales_order.so_date) <=' => $_POST['end'],
				);
			} else if ($_POST['start'] != "") {
				$where_2 = array('date(t_sales_order.so_date) >=' => $_POST['start']);
			} else if ($_POST['end'] != "") {
				$where_2 = array('date(t_sales_order.so_date) <=' => $_POST['end']);
			}
		}
		$where_3 = array();
		if($this->sessionGlobal['super_admin'] == "1") {
            $where_3['t_sales_order.id_branch'] = $this->sessionGlobal['id_branch'];
        }
		$where = array_merge($where_1,$where_2,$where_3);

		
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"t_sales_order.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_transaksi->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);
        $fetch = array();
        foreach($list as $k=>$v) {
            $do = $this->db->get_where('t_delivery_order',array('id_so'=>$v['id']))->row_array();
            $invoice = $this->db->get_where('t_invoice',array('id_so'=>$v['id']))->row_array();
            
            $duedate_status = '-';
            if(isset($invoice['id'])) {
                $duedate = $this->db->get_where('t_pay_duedate',array('id_invoice'=>$invoice['id']))->row_array();
                if(isset($duedate)) {
                    $duedate_status = $duedate['pay_duedate_status'];
                }
            }
            $fetch[] = array(
                'id_so' => $v['id'],
                'so_code' => $v['so_code'],
				'so_date' => $v['so_date'],
                'do_status' => $do['do_sales_status']/*(isset($do['id']) ? 'Done' : 'Not Yet')*/,
                'invoice_status' => $invoice['invoice_sales_status']/*(isset($invoice['id']) ? 'Done' : 'Not Yet')*/,
                'due_date' => $duedate_status
            );
        }
        $total_records = count($this->m_transaksi->getListTable($field,$table, $join, $like, $where, $sort, false));
        $total_pages = ceil(count($list) / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $total_records,
            "data" => $fetch,
        );
        //output to json format
        echo json_encode($output);
    }
	
	public function print_excel() {
		$table = 't_sales_order'; 
        $field = array(
            "t_sales_order.*",
            "IF(t_sales_order.so_status=1,'Active','Not Active') AS status"
        );
        $join = array();
        $like = array(
            't_sales_order.so_code'=>isset($_POST['so_code'])?$_POST['so_code']:""
        );
        $where_1 = array(
            't_sales_order.so_status !=' => '3',
        );
		$where_2 = array();
		if (isset($_GET['start']) && isset($_GET['end'])) {
			if($_GET['start'] != null && $_GET['end'] != null) {
				$where_2 = array(
					'date(t_sales_order.so_date) >=' => $_GET['start'],
					'date(t_sales_order.so_date) <=' => $_GET['end'],
				);
			} else if ($_GET['start'] != "") {
				$where_2 = array('date(t_sales_order.so_date) >=' => $_GET['start']);
			} else if ($_GET['end'] != "") {
				$where_2 = array('date(t_sales_order.so_date) <=' => $_GET['end']);
			}
		}
		$where_3 = array();
		if($this->sessionGlobal['super_admin'] == "1") {
            $where_3['t_sales_order.id_branch'] = $this->sessionGlobal['id_branch'];
        }
		$where = array_merge($where_1,$where_2,$where_3);
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"t_sales_order.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );
        
		$list = $this->m_transaksi->getListTable($field,$table, $join, $like, $where, $sort, false);
		$fetch = array();
        foreach($list as $k=>$v) {
            $do = $this->db->get_where('t_delivery_order',array('id_so'=>$v['id']))->row_array();
            $invoice = $this->db->get_where('t_invoice',array('id_so'=>$v['id']))->row_array();
            
            $duedate_status = '-';
            if(isset($invoice['id'])) {
                $duedate = $this->db->get_where('t_pay_duedate',array('id_invoice'=>$invoice['id']))->row_array();
                if(isset($duedate)) {
                    $duedate_status = $duedate['pay_duedate_status'];
                }
            }
            $fetch[] = array(
                'so_code' => $v['so_code'],
				'so_date' => $v['so_date'],
                'do_status' => $do['do_sales_status']/*(isset($do['id']) ? 'Done' : 'Not Yet')*/,
                'invoice_status' => $invoice['invoice_sales_status']/*(isset($invoice['id']) ? 'Done' : 'Not Yet')*/,
                'due_date' => $duedate_status
            );
        }
		$data['list'] = $fetch;
        $data['template_excel'] = "r_transaksi/table_excel";
        $data['file_name'] = "status_transaksi";
        $this->load->view('template_excel', $data);
    }
}
