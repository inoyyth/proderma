<?php

class T_visit_form extends MX_Controller {

    var $table = "sales_visit_form";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_t_visit_form' => 'm_visit_form', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Activity', '/dasboard');
        $this->breadcrumbs->push('Task', '/visit-form');
    }

    public function index() {
        $data['template_title'] = array('Task List', 'List');
        $data['view'] = 't_visit_form/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'sales_visit_form'; 
        
        $field = array(
            "sales_visit_form.*",
            "m_customer.customer_name",
            "m_employee.employee_name",
            "m_activity.activity_name",
            "IF(sales_visit_form.visit_form_status=1,'Active','Not Active') AS status"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'm_customer', 'where' => 'm_customer.id=sales_visit_form.visit_form_attendence', 'join' => 'left'),
            array('table' => 'm_employee', 'where' => 'm_employee.id=sales_visit_form.visit_form_sales', 'join' => 'left'),
            array('table' => 'm_activity', 'where' => 'm_activity.id=sales_visit_form.visit_form_activity', 'join' => 'left')
        );
        
        $like = array(
            'sales_visit_form.visit_form_code'=>isset($_POST['code'])?$_POST['code']:"",
            'sales_visit_form.visit_form_subject'=>isset($_POST['subject'])?$_POST['subject']:"",
            'm_employee.employee_name'=>isset($_POST['sales'])?$_POST['sales']:"",
            'm_customer.customer_name'=>isset($_POST['attendence'])?$_POST['attendence']:""
        );
		
        $where_1 = array('sales_visit_form.visit_form_status !=' => '3');
		$where_2 = array();
		if (isset($_POST['start']) && isset($_POST['end'])) {
			if($_POST['start'] != null && $_POST['end'] != null) {
				$where_2 = array(
					'date(sales_visit_form.visit_form_start_date) >=' => $_POST['start'],
					'date(sales_visit_form.visit_form_end_date) <=' => $_POST['end'],
				);
			} else if ($_POST['start'] != "") {
				$where_2 = array('date(sales_visit_form.visit_form_start_date) >=' => $_POST['start']);
			} else if ($_POST['end'] != "") {
				$where_2 = array('date(sales_visit_form.visit_form_end_date) <=' => $_POST['end']);
			}
		}
		$where_3 = array();
		if($this->sessionGlobal['super_admin'] == "1") {
            $where_3['sales_visit_form.id_branch'] = $this->sessionGlobal['id_branch'];
        }
		$where = array_merge($where_1,$where_2,$where_3);
		
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"sales_visit_form.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_visit_form->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

        $total_records = count($this->m_visit_form->getListTable($field,$table, $join, $like, $where, $sort, false));
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
        $this->breadcrumbs->push('Add', '/visit-form-add');
        $data['employee']= $this->m_visit_form->getEmployee()->result_array();
        $data['activity']= $this->db->get_where('m_activity',array('activity_status'=>1))->result_array();
        $data['branch'] = $this->db->get_where('m_branch',array('branch_status'=>1))->result_array();
		$data['code'] = $this->main_model->generate_code('sales_visit_form', $this->config->item('ojt_code') . "-" . date('ym'),'/' , $digit = 5, false,false, $where=array(),'id','id');
        $data['view'] = "t_visit_form/add";
        $this->load->view('default', $data);
    }

    public function edit($id) {
        $this->breadcrumbs->push('Edit', '/visit-form-edit');
         $data['employee']= $this->m_visit_form->getEmployee()->result_array();
        $data['branch'] = $this->db->get_where('m_branch',array('branch_status'=>1))->result_array();
		$data['activity']= $this->db->get_where('m_activity',array('activity_status'=>1))->result_array();
        $data['data'] = $this->m_visit_form->getEditData($this->table, $id)->row_array();
        $data['view'] = 't_visit_form/edit';
        $this->load->view('default', $data);
    }

    function delete($id) {
        if ($this->db->update($this->table, array('visit_form_status' => 3),array('id'=>$id))) {
            $this->session->set_flashdata('success', 'Data Berhasil Di Hapus !');
        } else {
            $this->session->set_flashdata('error', 'Data Gagal Di Hapus !');
        }
        redirect("visit-form");
    }

    function save() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_visit_form->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("visit-form");
        } else {
            show_404();
        }
    }
    
    public function getCustomerList() {
        $query = $this->m_visit_form->getCustomerList($this->input->get('query'))->result_array();
        echo json_encode($query);
    }

    public function print_pdf() {
        $data['template'] = array("template" => "t_visit_form/" . $_GET['template'], "filename" => $_GET['name']);
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->printpdf->create_pdf($data);
    }

    public function print_excel() {
		$table = 'sales_visit_form'; 
        $field = array(
            "sales_visit_form.*",
            "m_customer.customer_name",
            "m_employee.employee_name",
            "m_activity.activity_name",
            "IF(sales_visit_form.visit_form_status=1,'Active','Not Active') AS status"
        );
        $join = array(
            array('table' => 'm_customer', 'where' => 'm_customer.id=sales_visit_form.visit_form_attendence', 'join' => 'left'),
            array('table' => 'm_employee', 'where' => 'm_employee.id=sales_visit_form.visit_form_sales', 'join' => 'left'),
            array('table' => 'm_activity', 'where' => 'm_activity.id=sales_visit_form.visit_form_activity', 'join' => 'left')
        );
		$like = array();
		if (isset($_GET['supervisor']) && $_GET['supervisor'] != "") {
			$like['m_employee.employee_name'] = $_GET['supervisor'];
		}
		$where_1 = array('sales_visit_form.visit_form_status !=' => '3');
		$where_2 = array();
		if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
			if($_GET['start_date'] != null && $_GET['end_date'] != null) {
				$where_2 = array(
					'date(sales_visit_form.visit_form_start_date) >=' => $_GET['start_date'],
					'date(sales_visit_form.visit_form_end_date) <=' => $_GET['end_date'],
				);
			} else if ($_GET['start_date'] != "") {
				$where_2 = array('date(sales_visit_form.visit_form_start_date) >=' => $_GET['start_date']);
			} else if ($_GET['end_date'] != "") {
				$where_2 = array('date(sales_visit_form.visit_form_end_date) <=' => $_GET['end_date']);
			}
		}
		$where_3 = array();
		if($this->sessionGlobal['super_admin'] == "1") {
            $where_3['sales_visit_form.id_branch'] = $this->sessionGlobal['id_branch'];
        }
		$where = array_merge($where_1,$where_2,$where_3);
		
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"sales_visit_form.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"asc"
        );
		
        $data['list'] = $this->m_visit_form->getListTable($field,$table, $join, $like, $where, $sort, false);
        $data['template_excel'] = "t_visit_form/table_excel";
        $data['file_name'] = "task_master";
        $this->load->view('template_excel', $data);
    }

}
