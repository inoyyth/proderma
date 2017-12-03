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
        if ($data['so']['total'] > 0) {
            $data['so_total'] = ($this->m_dashboard->getSoTotal()['total'] / $data['so']['total']) * 100;
        } else {
            $data['so_total'] = 0;
        }
        $mapping_area = $this->m_dashboard->getMappingArea();
        $dt_mp_area = array();
        foreach ($mapping_area as $k => $v) {
            $dt_mp_area[] = array('name' => $v['name'], 'y' => (int) $v['y']);
        }
        $data['mapping_area'] = json_encode($dt_mp_area, true);
        $data['title'] = "Laporan Keuangan";
        $data['view'] = 'dashboard/main';
        $this->load->view('default', $data);
    }

    public function getAllBranch() {
        $sql = $this->m_dashboard->getAllBranch();
        echo json_encode($sql);
    }

    public function getReport() {
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $branch = $this->input->post('branch');
        

        $arr_month = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
        $arr_month_long = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'Augustus', 'September', 'October', 'November', 'December');

        if ($month == NULL || $month == "") {

            $dt = $this->m_dashboard->getYearlyReport($year, $branch)->result_array();
            $dt_bulan = array();
            foreach ($dt as $k => $v) {
                $dt_bulan[] = $arr_month[$v['bulan']];
            }
            $dt_value = array();
            foreach ($dt as $k => $v) {
                $dt_value[] = (int) $v['total'];
            }

            $title = 'Income Report ' . $year;
            $subtitle = 'Sales Order';
            $category = $dt_bulan;
            $value = $dt_value;
        } else {
            $dt = $this->m_dashboard->getDailyReport($month, $year, $branch)->result_array();
            $dt_tgl = array();
            foreach ($dt as $k => $v) {
                $dt_tgl[] = $v['tgl'];
            }
            $dt_value = array();
            foreach ($dt as $k => $v) {
                $dt_value[] = (int) $v['total'];
            }

            $title = 'Income Report ' . $arr_month_long[$month];
            $subtitle = 'Sales Order';
            unset($arr_month[0]);
            $category = $dt_tgl;
            $value = $dt_value;
            $target = $this->getTarget($month, $year, $branch);
        }

        echo json_encode(
                array(
                    'title' => $title,
                    'subtitle' => $subtitle,
                    'category' => $category,
                    'value' => $value,
                    'target' => $target
                )
        );
    }

    public function getTarget($month, $year, $branch) {
        $target_branch = $this->db->get_where('m_branch_target',array('id_branch'=>$branch))->row_array();
        $total_achievement = $this->m_dashboard->getAchievement($month, $year, $branch);
        $percentage = 0;
        if ($target_branch['value_target'] > 0 && $total_achievement['total'] > 0) {
            $percentage = 100 - ((($target_branch['value_target'] - $total_achievement['total']) / $target_branch['value_target']) * 100);
        }
        $data = array(
            'target_branch' => formatrp($target_branch['value_target']),
            'achievement' => formatrp($total_achievement['total']),
            'percentage' => round($percentage, 1)
        );
        return $data;
    }

}
