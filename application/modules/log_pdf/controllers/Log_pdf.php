<?php

class Log_pdf extends MX_Controller {

    var $table = "pdf_log";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_log_pdf' => 'm_log_pdf', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Log PDF', '/log-pdf');
    }

    public function index() {
        $data['template_title'] = array('Log PDF List', 'List');
        $data['view'] = 'log_pdf/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'pdf_log'; 
        
        $field = array(
            "pdf_log.*",
            "m_employee.employee_name",
            "m_employee.employee_nip"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'm_employee', 'where' => 'm_employee.id=pdf_log.id_sales', 'join' => 'left'),
        );
        
        $like = array(
            'pdf_log.promo_code'=>isset($_POST['code'])?$_POST['code']:"",
            'm_employee.employee_name'=>isset($_POST['name'])?$_POST['name']:"",
            'date(pdf_log.datetime)'=>isset($_POST['date'])?$_POST['date']:""
        );
		$where = array();
        if($this->sessionGlobal['super_admin'] == "1") {
            $where['m_employee.id_branch'] = $this->sessionGlobal['id_branch'];
        }
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"pdf_log.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_log_pdf->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

        $total_records = $this->data_table->count_all($table/*,$where*/);
        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $this->data_table->count_all($table/*$where*/),
            "data" => $list,
        );
        //output to json format,
        echo json_encode($output);
    }
}
