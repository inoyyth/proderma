<?php

class T_mapping_area extends MX_Controller {

    var $table = "m_employee";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_t_mapping_area' => 'm_mapping_area', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Activity', '/dasboard');
        $this->breadcrumbs->push('Mapping Area', '/mapping-area');
    }

    public function index() {
        $data['template_title'] = array('Mapping Area', 'List');
        $data['view'] = 't_mapping_area/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_employee'; 
        
        $field = array(
            "m_employee.*",
            "m_jabatan.jabatan",
			"m_branch.branch_name"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'm_jabatan', 'where' => 'm_employee.id_jabatan=m_jabatan.id', 'join' => 'left'),
			array('table' => 'm_branch', 'where' => 'm_employee.id_branch=m_branch.id', 'join' => 'left')
         );
        
        $like = array(
            'm_employee.employee_name'=>isset($_POST['employee_name'])?$_POST['employee_name']:""
        );
        $where = array('m_employee.id_jabatan'=>1,'m_employee.employee_status'=>1);
        if($this->sessionGlobal['super_admin'] == "1") {
            $where['m_employee.id_branch'] = $this->sessionGlobal['id_branch'];
        }
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_employee.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_mapping_area->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);
        
        //log_message('debug',print_r($dtx,TRUE));
        
        $total_records = count($this->m_mapping_area->getListTable($field,$table, $join, $like, $where, $sort, false));
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
        $this->breadcrumbs->push('Edit', '/mapping-area-edit');
        $data['data_sales'] = $this->db->get_where($this->table, array('id' => $id))->row_array();
        $data['province'] = $this->db->get('province')->result_array();
        $data['view'] = 't_mapping_area/edit';
        $this->load->view('default', $data);
    }

    public function view($id) {
        $this->breadcrumbs->push('Edit', '/mapping-area-view');
        $data['data_sales'] = $this->db->get_where($this->table, array('id' => $id))->row_array();
        $data['view'] = 't_mapping_area/edit';
        $this->load->view('default', $data);
    }

    function save() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_mapping_area->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("mapping-area");
        } else {
            show_404();
        }
    }
    
    public function getClinicList() {
        $city = $this->input->get('id');
        $list = $this->db->get_where('m_customer',array('customer_city'=>$city,'customer_status'=>1,))->result_array();
        $dt = array();
        foreach ($list as $k=>$v) {
            $dt[] = array($v['customer_clinic'],$v['customer_latitude'],$v['customer_longitude']);
        }
        echo json_encode($dt);
    }
    
    public function getAvailableCustomer($id) {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_customer'; 
        
        $field = array(
            "m_customer.*","m_subarea.subarea_code","m_subarea.subarea_name","m_area.area_name"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array();
        
        $like = array(
            'm_customer.customer_name'=>isset($_POST['query'])?$_POST['query']:"",
            'm_customer.customer_code'=>isset($_POST['query'])?$_POST['query']:""
        );
        $where = array();
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_area.area_name",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"asc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_mapping_area->getAvailableCustomer($field,$table, $join, $like, array('id_sales'=>$id), $sort, $limit_row);
        $total_records = count($this->m_mapping_area->getAvailableCustomer($field,$table, $join, $like, array('id_sales'=>$id), $sort, false));
        $listx = array();
        foreach($list as $k=>$v) {
            $listx[] = array(
                'id' =>$v['id'],
                'customer_name' =>$v['customer_name'],
                'customer_code' =>$v['customer_code'],
                'id_subarea' =>$v['id_subarea'],
                'subarea_code' =>$v['subarea_code'],
                'subarea_name' =>$v['subarea_name']." | ".$v['area_name'],
            );
        }
        log_message('debug',print_r($list,TRUE));

        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $total_records,
            "data" => $listx,
        );
        //output to json format
        echo json_encode($output);
    }
    
    public function getCurrentCustomer($id) {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_customer'; 
        
        $field = array(
            "sales_mapping_area.*","m_subarea.subarea_name","m_subarea.subarea_code","m_customer.customer_code","m_customer.customer_name","m_area.area_name","m_area.id"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array();
        
        $like = array(
            'm_customer.customer_name'=>isset($_POST['query'])?$_POST['query']:"",
            'm_customer.customer_code'=>isset($_POST['query'])?$_POST['query']:""
        );
        $where = array();
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_area.area_name",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"asc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_mapping_area->getCurrentCustomer($field,$table, $join, $like, array('id_sales'=>$id), $sort, $limit_row);
        $total_records = count($this->m_mapping_area->getCurrentCustomer($field,$table, $join, $like, array('id_sales'=>$id), $sort, false));
        $listx = array();
        foreach($list as $k=>$v) {
            $listx[] = array(
                'id' =>$v['id'],
                'id_customer' =>$v['id_customer'],
                'customer_code' =>$v['customer_code'],
                'customer_name' =>$v['customer_name'],
                'id_sub_area' =>$v['id_sub_area'],
                'subarea_code' =>$v['subarea_code'],
                'subarea_name' =>$v['subarea_name']." | ".$v['area_name'],
            );
        }
        log_message('debug',print_r($list,TRUE));
        
        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $total_records,
            "data" => $listx,
        );
        //output to json format
        echo json_encode($output);
    }
    
    public function insertCustomer() {
        $id_employee = $this->input->post('id_employee');
        $array_data = $this->input->post('arrayData');
        $query = $this->m_mapping_area->insertCustomer($id_employee,$array_data);
        if($query) {
            echo json_encode(array('code'=>200));
        } else {
            echo json_encode(array('code'=>204));
        }
    }
    
    public function removeCustomer() {
        $id_employee = $this->input->post('id_employee');
        $array_data = $this->input->post('arrayData');
        $query = $this->m_mapping_area->removeCustomer($id_employee,$array_data);
        if($query) {
            echo json_encode(array('code'=>200));
        } else {
            echo json_encode(array('code'=>204));
        }
    }
	
    public function print_excel() {
		$table = 'm_employee'; 
        $field = array(
            "m_employee.*",
            "m_jabatan.jabatan",
			"m_branch.branch_name"
        );
        $join = array(
            array('table' => 'm_jabatan', 'where' => 'm_employee.id_jabatan=m_jabatan.id', 'join' => 'left'),
			array('table' => 'm_branch', 'where' => 'm_employee.id_branch=m_branch.id', 'join' => 'left')
		);
        $like = array();
        $where = array('m_employee.id_jabatan'=>1);
        if($this->sessionGlobal['super_admin'] == "1") {
            $where['m_employee.id_branch'] = $this->sessionGlobal['id_branch'];
        }
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_employee.employee_name",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"asc"
        );
		
        $data['list'] = $this->m_mapping_area->getListTable($field,$table, $join, $like, $where, $sort, 100000);
        $data['template_excel'] = "t_mapping_area/table_excel";
        $data['file_name'] = "mapping_area";
        $this->load->view('template_excel', $data);
    }
    
    public function getAvailableCustomerList($id) {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_customer'; 
        
        $field = array(
            "m_customer.*","m_subarea.subarea_code","m_subarea.subarea_name","m_area.area_name"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array();
        
        $like = array(
            'm_customer.customer_name'=>isset($_POST['query'])?$_POST['query']:"",
            'm_customer.customer_code'=>isset($_POST['query'])?$_POST['query']:""
        );
        $where = array();
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_area.area_name",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"asc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_mapping_area->getAvailableCustomerList($field,$table, $join, $like, array('id_sales'=>$id), $sort, $limit_row);
        $total_records = count($this->m_mapping_area->getAvailableCustomerList($field,$table, $join, $like, array('id_sales'=>$id), $sort, false));
        $listx = array();
        foreach($list as $k=>$v) {
            $listx[] = array(
                'id' =>$v['id'],
                'customer_name' =>$v['customer_name'],
                'customer_code' =>$v['customer_code'],
                'id_subarea' =>$v['id_subarea'],
                'subarea_code' =>$v['subarea_code'],
                'subarea_name' =>$v['subarea_name']." | ".$v['area_name'],
            );
        }
        log_message('debug',print_r($list,TRUE));
        
        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $total_records,
            "data" => $listx,
        );
        //output to json format
        echo json_encode($output);
    }
    
    public function getCurrentCustomerList($id) {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_customer'; 
        
        $field = array(
            "sales_mapping_masterlist_area.*","m_subarea.subarea_name","m_subarea.subarea_code","m_customer.customer_code","m_customer.customer_name","m_area.area_name","m_area.id"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array();
        
        $like = array(
            'm_customer.customer_name'=>isset($_POST['query'])?$_POST['query']:"",
            'm_customer.customer_code'=>isset($_POST['query'])?$_POST['query']:""
        );
        $where = array();
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_area.area_name",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"asc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_mapping_area->getCurrentCustomerList($field,$table, $join, $like, array('id_sales'=>$id), $sort, $limit_row);
        $total_records = count($this->m_mapping_area->getCurrentCustomerList($field,$table, $join, $like, array('id_sales'=>$id), $sort, false));
        $listx = array();
        foreach($list as $k=>$v) {
            $listx[] = array(
                'id' =>$v['id'],
                'id_customer' =>$v['id_customer'],
                'customer_code' =>$v['customer_code'],
                'customer_name' =>$v['customer_name'],
                'id_sub_area' =>$v['id_sub_area'],
                'subarea_code' =>$v['subarea_code'],
                'subarea_name' =>$v['subarea_name']." | ".$v['area_name'],
            );
        }
        log_message('debug',print_r($list,TRUE));

        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $total_records,
            "data" => $listx,
        );
        //output to json format
        echo json_encode($output);
    }
    
    public function insertCustomerList() {
        $id_employee = $this->input->post('id_employee');
        $array_data = $this->input->post('arrayData');
        $query = $this->m_mapping_area->insertCustomerList($id_employee,$array_data);
        if($query) {
            echo json_encode(array('code'=>200));
        } else {
            echo json_encode(array('code'=>204));
        }
    }
    
    public function removeCustomerList() {
        $id_employee = $this->input->post('id_employee');
        $array_data = $this->input->post('arrayData');
        $query = $this->m_mapping_area->removeCustomerList($id_employee,$array_data);
        if($query) {
            echo json_encode(array('code'=>200));
        } else {
            echo json_encode(array('code'=>204));
        }
    }
}