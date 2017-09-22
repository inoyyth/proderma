<?php

class Md_employee extends MX_Controller {

    var $table = "m_employee";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_md_employee' => 'm_md_employee', 'Datatable_model' => 'data_table'));
        $this->load->library(array('upload', 'encrypt', 'Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Employee', '/employee');
    }

    public function index() {
        $data['template_title'] = array('Employee', 'List');
        $data['view'] = 'md_employee/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_employee'; 
        
        $field = array(
            "m_employee.*",
            "IF(m_employee.employee_gender='F','Female','Male') AS gender",
            "m_jabatan.jabatan",
			"m_branch.branch_name",
            "IF(m_employee.employee_status=1,'Active','Not Active') AS status"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'm_jabatan', 'where' => 'm_jabatan.id=m_employee.id_jabatan', 'join' => 'left'),
			array('table' => 'm_branch', 'where' => 'm_branch.id=m_employee.id_branch', 'join' => 'left')
        );
        $like = array(
            'm_jabatan.jabatan'=>isset($_POST['jabatan'])?$_POST['jabatan']:"",
            'm_employee.employee_nip'=>isset($_POST['nip'])?$_POST['nip']:"",
            'm_employee.employee_name'=>isset($_POST['nama'])?$_POST['nama']:"",
            'm_employee.employee_email'=>isset($_POST['email'])?$_POST['email']:"",
            'm_employee.employee_phone'=>isset($_POST['phone'])?$_POST['phone']:"",
            'm_employee.employee_gender'=>isset($_POST['gender'])?$_POST['gender']:""
        );
        $where = array('m_employee.employee_status !=' => '3');
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
        
        $list = $this->m_md_employee->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

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
        $data['branch'] = $this->db->get_where('m_branch',array('branch_status'=>1))->result_array();
        $data['jabatan'] = $this->db->get_where('m_jabatan',array('jabatan_status'=>1))->result_array();
        $data['view'] = "md_employee/add";
        $this->load->view('default', $data);
    }

    public function edit($id) {
        $this->breadcrumbs->push('Edit', '/master-employee-edit');
        $data['branch'] = $this->db->get_where('m_branch',array('branch_status'=>1))->result_array();
        $data['jabatan'] = $this->db->get_where('m_jabatan',array('jabatan_status'=>1))->result_array();
        $data['data'] = $this->db->get_where($this->table, array('id' => $id))->row_array();
        $data['view'] = 'md_employee/edit';
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
            if ($this->m_md_employee->save()) {
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
        $data['template'] = array("template" => "md_employee/" . $_GET['template'], "filename" => $_GET['name']);
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->printpdf->create_pdf($data);
    }

    public function print_excel() {
        $data['template_excel'] = "md_employee/" . $_GET['template'];
        $data['file_name'] = $_GET['name'];
        $data['list'] = $this->db->get($this->table)->result_array();
        $this->load->view('template_excel', $data);
    }
    
     public function getPassEmployee() {
        $id = $this->input->post('id');
        if($data = $this->m_md_employee->getPassEmployee($id)->row_array()){
            if($data['sales_password'] != "") {
                $result['password'] = $this->encrypt->decode($data['sales_password']);
            } else {
                $result['password'] = 1234;
            }
            $dt = array('code'=>200,'data'=>$result);
            echo json_encode($dt);
        } else {
            return false;
        }
    }

}
