<?php

class Log_battery extends MX_Controller {

    var $table = "baterai_status";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_log_battery' => 'm_battery', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Report', '/dasboard');
        $this->breadcrumbs->push('Log Battery ME', '/log_battery');
    }

    public function index() {
        $this->m_battery->deltaDelete();
        $data['branch'] = $this->db->get_where('m_branch', array('branch_status' => 1))->result_array();
        $data['template_title'] = array('Log Battery ME', 'List');
        $data['view'] = 'log_battery/main';
        $this->load->view('default', $data);
    }

    public function getReport() {
        $datelog = $this->input->post('date');
        $employee = $this->input->post('employee');
        $nm_employee = $this->db->get_where('m_employee',array('employee_nip'=>$employee,'employee_status'=>1))->row_array();
        $dt = $this->m_battery->getData($datelog,$nm_employee['id']);
        
        $category = array();
        $value = array();
        foreach ($dt as $kTgl=>$vTgl) {
            $category[] = $vTgl['TIMEONLY'];
            $value[] = (int)$vTgl['baterai'];
        }
        $fixValue = array(
            'name' => $nm_employee['employee_name'],
            'data' => $value
        );
        $title = 'ME Battery Status';
        $subtitle = $nm_employee['employee_nip'] . " - " . $nm_employee['employee_name'];

        echo json_encode(
                array(
                    'title' => $title,
                    'subtitle' => $subtitle,
                    'category' => $category,
                    'value' => $fixValue
                )
        );
    }

}
