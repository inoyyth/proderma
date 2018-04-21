<?php

class T_sales_visit extends MX_Controller {

    var $table = "sales_visit";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_t_sales_visit' => 'm_t_sales_visit', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Activity', '/dasboard');
        $this->breadcrumbs->push('Plan', '/ojt');
    }

    public function index() {
        $data['template_title'] = array('Plan List', 'List');
        $data['view'] = 't_sales_visit/main';
        $this->load->view('default', $data);
    }
    
    public function add() {
        $data['sales'] = $this->m_t_sales_visit->getEmployee()->result_array();
        $data['branch'] = $this->db->get_where('m_branch',array('branch_status'=>1))->result_array();
		$data['view'] = 't_sales_visit/add';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'sales_visit'; 
        
        $field = array(
            "sales_visit.*",
            "IF(sales_visit.status=1,'Active','Not Active') AS status",
            "m_employee.employee_name",
            "m_customer.customer_name",
            "m_objective.objective"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'm_employee', 'where' => 'm_employee.id=sales_visit.id_sales', 'join' => 'left'),
            array('table' => 'm_customer', 'where' => 'm_customer.id=sales_visit.id_customer', 'join' => 'left'),
            array('table' => 'm_objective', 'where' => 'm_objective.id=sales_visit.activity', 'join' => 'left')
        );
        
        $like = array(
            'm_customer.customer_name'=>isset($_POST['customer_name'])?$_POST['customer_name']:"",
            'm_employee.employee_name'=>isset($_POST['sales_name'])?$_POST['sales_name']:""
        );
		
        $where_1 = array('sales_visit.status !=' => '3');
		$where_2 = array();
		if (isset($_POST['start']) && isset($_POST['end'])) {
			if($_POST['start'] != null && $_POST['end'] != null) {
				$where_2 = array(
					'date(sales_visit.sales_visit_date) >=' => $_POST['start'],
					'date(sales_visit.end_date) <=' => $_POST['end'],
				);
			} else if ($_POST['start'] != "") {
				$where_2 = array('date(sales_visit.sales_visit_date) =' => $_POST['start']);
			} else if ($_POST['end'] != "") {
				$where_2 = array('date(sales_visit.end_date) =' => $_POST['end']);
			}
		}
		$where_3 = array();
		if($this->sessionGlobal['super_admin'] == "1") {
            $where_3['sales_visit.id_branch'] = $this->sessionGlobal['id_branch'];
        }
		$where = array_merge($where_1,$where_2,$where_3);
		
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"sales_visit.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_t_sales_visit->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

        $total_records = count($this->m_t_sales_visit->getListTable($field,$table, $join, $like, $where, $sort, false));
        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $total_records,
            "data" => $list,
        );
        //output to json format
        echo json_encode($output);
    }
    
    public function getCustomerList() {
        $query = $this->m_t_sales_visit->getCustomerList($this->input->get('query'),$this->input->get('cust_type'))->result_array();
        echo json_encode($query);
    }

    public function detail($id) {
        $this->breadcrumbs->push('Plan Detail', '/ojt-detail');
        $data['data'] = $this->m_t_sales_visit->getDetail($id)->row_array();
        $data['view'] = 't_sales_visit/detail';
        $this->load->view('default', $data);
    }
    
    public function getActivity() {
        $dt = $this->db->get_where('m_objective',array('objective_customer'=>$this->input->post('consumer_type')))->result_array();
        echo json_encode($dt,true);
    }
    
    function save() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_t_sales_visit->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("ojt");
        } else {
            show_404();
        }
    }
	
	 public function print_excel() {
		 $table = 'sales_visit'; 
        
        $field = array(
            "sales_visit.*",
            "IF(sales_visit.status=1,'Active','Not Active') AS status",
            "m_employee.employee_name",
            "m_customer.customer_name",
			"m_customer.customer_code",
			"m_customer.current_lead_customer_status",
            "m_objective.objective",
			"m_branch.branch_name"
        );

        $join = array(
            array('table' => 'm_employee', 'where' => 'm_employee.id=sales_visit.id_sales', 'join' => 'left'),
            array('table' => 'm_customer', 'where' => 'm_customer.id=sales_visit.id_customer', 'join' => 'left'),
            array('table' => 'm_objective', 'where' => 'm_objective.id=sales_visit.activity', 'join' => 'left'),
			array('table' => 'm_branch', 'where' => 'm_branch.id=sales_visit.id_branch', 'join' => 'left')
        );
        
        $like = array();
		if (isset($_GET['sales']) && $_GET['sales'] != "") {
			$like['m_employee.employee_name'] = $_GET['sales'];
		}
		
        $where_1 = array('sales_visit.status !=' => '3');
		$where_2 = array();
		if (isset($_POST['start']) && isset($_POST['end'])) {
			if($_POST['start'] != null && $_POST['end'] != null) {
				$where_2 = array(
					'date(sales_visit.sales_visit_date) >=' => $_POST['start'],
					'date(sales_visit.end_date) <=' => $_POST['end'],
				);
			} else if ($_POST['start'] != "") {
				$where_2 = array('date(sales_visit.sales_visit_date) =' => $_POST['start']);
			} else if ($_POST['end'] != "") {
				$where_2 = array('date(sales_visit.end_date) =' => $_POST['end']);
			}
		}
		$where_3 = array();
		if($this->sessionGlobal['super_admin'] == "1") {
            $where_3['sales_visit.id_branch'] = $this->sessionGlobal['id_branch'];
        }
		$where = array_merge($where_1,$where_2,$where_3);
		
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"sales_visit.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"asc"
        );
		 
		$data['list'] = $this->m_t_sales_visit->getListTable($field,$table, $join, $like, $where, $sort, false);
        $data['template_excel'] = "t_sales_visit/table_excel";
        $data['file_name'] = "plan_master";
        $this->load->view('template_excel', $data);
    }
}
