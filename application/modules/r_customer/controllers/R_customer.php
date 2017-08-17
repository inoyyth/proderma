<?php

class R_customer extends MX_Controller {

    var $table = "t_sales_order";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_r_customer' => 'm_customer', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Report Customer', '/employee-level');
    }

    public function index() {
        $data['template_title'] = array('Report Customer', 'List');
        $data['view'] = 'r_customer/main';
        $this->load->view('default', $data);
    }

    public function getReport() {
        $month = $this->input->post('month');
        $year = $this->input->post('year');

        $arr_month = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
        $arr_month_long = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'Augustus', 'September', 'October', 'November', 'December');

        if ($month == NULL || $month == "") {

            $dt = $this->m_customer->getYearlyReport($year)->result_array();
            $dt_bulan = array();
            foreach ($dt as $k => $v) {
                $dt_bulan[] = $arr_month[$v['bulan']];
            }
            $dt_value = array();
            foreach ($dt as $k => $v) {
                $dt_value[] = (int) $v['total'];
            }

            $title = 'Yearly Report ' . $year;
            $subtitle = 'Customer';
            $category = $dt_bulan;
            $value = $dt_value;
        } else {
            $dt = $this->m_customer->getDailyReport($month, $year)->result_array();
            $dt_tgl = array();
            foreach ($dt as $k => $v) {
                $dt_tgl[] = $v['tgl'];
            }
            $dt_value = array();
            foreach ($dt as $k => $v) {
                $dt_value[] = (int) $v['total'];
            }

            $title = 'Monthly Report ' . $arr_month_long[$month];
            $subtitle = 'Customer';
            unset($arr_month[0]);
            $category = $dt_tgl;
            $value = $dt_value;
        }

        echo json_encode(
                array(
                    'title' => $title,
                    'subtitle' => $subtitle,
                    'category' => $category,
                    'value' => $value
                )
        );
    }

    public function getListTable() {
        $page = ($_POST['page'] == 0 ? 1 : $_POST['page']);
        $limit = $_POST['size'];

        $table = 'm_customer';

        if ($this->input->post('month') == NULL || $this->input->post('month') == '') {
            $field = array(
                "m_customer.*",
                "m_area.area_name",
                "m_subarea.subarea_name",
                "MONTHNAME(m_customer.sys_create_date) AS kelompok"
            );
        } else {
            $field = array(
                "m_customer.*",
                "m_area.area_name",
                "m_subarea.subarea_name",
                "day(m_customer.sys_create_date) AS kelompok"
            );
        }

        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'm_area', 'where' => 'm_area.id=m_customer.id_area', 'join' => 'left'),
            array('table' => 'm_subarea', 'where' => 'm_subarea.id=m_customer.id_subarea', 'join' => 'left')
        );
        $like = array();
        $where = array();
        if ($this->input->post('month') == NULL || $this->input->post('month') == '') {
            $where = array(
                'YEAR(m_customer.sys_create_date)' => $this->input->post('year'),
                'm_customer.customer_status <>' => 3,
                'm_customer.current_lead_customer_status' => 'C'
            );
            //$groupby = array('MONTH(so_date)');
        } else {
            $where = array(
                'MONTH(m_customer.sys_create_date)' => $this->input->post('month'),
                'YEAR(m_customer.sys_create_date)' => $this->input->post('year'),
                'm_customer.customer_status <>' => 3,
                'm_customer.current_lead_customer_status' => 'C'
            );
        }
        $sort = array(
            'sort_field' => isset($_POST['sort']) ? $_POST['sort'] : "m_customer.sys_create_date",
            'sort_direction' => isset($_POST['sort_dir']) ? $_POST['sort_dir'] : "asc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );

        $list = $this->m_customer->getListTable($field, $table, $join, $like, $where, $sort, $limit_row);

        $total_records = $this->data_table->count_all($table, $where);
        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $total_records,
            "data" => $list,
        );
        //output to json format
        echo json_encode($output);
    }

}
