<?php

class Dashboard extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //set breadcrumb
        $this->breadcrumbs->push('Dashboard', '/home');
        $this->load->model(array('M_dashboard' => 'm_dashboard'));
    }

    public function index() {
        $data['product'] = $this->m_dashboard->getCount('m_product', array('product_status' => 1));
        $data['customer'] = $this->m_dashboard->getCount('m_customer', array('current_lead_customer_status' => 'C', 'customer_status' => 1));
        $data['sales'] = $this->m_dashboard->getCount('m_employee', array('employee_status' => 1, 'id_jabatan' => 1));
        $data['so'] = $this->m_dashboard->getCount('t_sales_order', array('so_status' => 1));
        $data['due_date'] = $this->m_dashboard->getCount('t_pay_duedate', array('pay_duedate_status' => 'WAIT'));
        $data['so_total'] = ($this->m_dashboard->getSoTotal()['total'] / $data['so']['total']) * 100;
        $mapping_area = $this->m_dashboard->getMappingArea();
        $dt_mp_area = array();
        foreach($mapping_area as $k=>$v) {
            $dt_mp_area[] = array('name'=>$v['name'],'y'=>(int)$v['y']);
        }
        $data['mapping_area'] = json_encode($dt_mp_area,true);
        $data['title'] = "Laporan Keuangan";
        $data['view'] = 'dashboard/main';
        $this->load->view('default', $data);
    }

}
