<?php

class R_penjualan extends MX_Controller {

    var $table = "t_sales_order";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_r_penjualan' => 'm_penjualan', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Report Penjualan', '/employee-level');
    }

    public function index() {
        $data['branch'] = $this->db->get_where('m_branch',array('branch_status' => 1))->result_array();
        $data['template_title'] = array('Report Penjualan', 'List');
        $data['view'] = 'r_penjualan/main';
        $this->load->view('default', $data);
    }

    public function getReport() {
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $branch = $this->input->post('branch');

        $arr_month = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
        $arr_month_long = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'Augustus', 'September', 'October', 'November', 'December');

        if ($month == NULL || $month == "") {

            $dt = $this->m_penjualan->getYearlyReport($year,$branch)->result_array();
            $dt_bulan = array();
            foreach ($dt as $k => $v) {
                $dt_bulan[] = $arr_month[$v['bulan']];
            }
            $dt_value = array();
            foreach ($dt as $k => $v) {
                $dt_value[] = (int) $v['total'];
            }

            $title = 'Yearly Report ' . $year;
            $subtitle = 'Sales Order';
            $category = $dt_bulan;
            $value = $dt_value;
        } else {
            $dt = $this->m_penjualan->getDailyReport($month, $year, $branch)->result_array();
            $dt_tgl = array();
            foreach ($dt as $k => $v) {
                $dt_tgl[] = $v['tgl'];
            }
            $dt_value = array();
            foreach ($dt as $k => $v) {
                $dt_value[] = (int) $v['total'];
            }

            $title = 'Monthly Report ' . $arr_month_long[$month];
            $subtitle = 'Sales Order';
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

        $table = 't_sales_order';

        if ($this->input->post('month') == NULL || $this->input->post('month') == '') {
            $field = array(
                "t_sales_order.*",
                "m_customer.customer_code",
                "m_customer.customer_name",
                "MONTHNAME(t_sales_order.so_date) AS kelompok"
            );
        } else {
            $field = array(
                "t_sales_order.*",
                "m_customer.customer_code",
                "m_customer.customer_name",
                "day(t_sales_order.so_date) AS kelompok"
            );
        }

        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'm_customer', 'where' => 'm_customer.id=t_sales_order.id_customer', 'join' => 'left')
        );
        $like = array();
        $where = array();
        if ($this->input->post('month') == NULL || $this->input->post('month') == '') {
            $where = array(
                'YEAR(t_sales_order.so_date)' => $this->input->post('year'),
            );
            //$groupby = array('MONTH(so_date)');
        } else {
            $where = array(
                'MONTH(t_sales_order.so_date)' => $this->input->post('month'),
                'YEAR(t_sales_order.so_date)' => $this->input->post('year'),
            );
        }
        if ($this->input->post('branch') != "all") {
            $where['t_sales_order.id_branch'] = $this->input->post('branch');
        }
        $sort = array(
            'sort_field' => isset($_POST['sort']) ? $_POST['sort'] : "t_sales_order.so_date",
            'sort_direction' => isset($_POST['sort_dir']) ? $_POST['sort_dir'] : "asc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );

        $list = $this->m_penjualan->getListTable($field, $table, $join, $like, $where, $sort, $limit_row);

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
    
    public function print_excel() {
        $table = 't_sales_order';

        if ($this->input->get('type') == 'monthly') {
            $field = array(
                "t_sales_order.*",
                "m_customer.customer_code",
                "m_customer.customer_name",
                "m_employee.employee_nip",
                "m_employee.employee_name",
                "MONTHNAME(t_sales_order.so_date) AS kelompok"
            );
        } else {
            $field = array(
                "t_sales_order.*",
                "m_customer.customer_code",
                "m_customer.customer_name",
                "m_employee.employee_nip",
                "m_employee.employee_name",
                "day(t_sales_order.so_date) AS kelompok"
            );
        }
        
        $join = array(
            array('table' => 'm_customer', 'where' => 'm_customer.id=t_sales_order.id_customer', 'join' => 'left'),
            array('table' => 'm_employee', 'where' => 'm_employee.id=t_sales_order.id_sales', 'join' => 'left')
        );
        $like = array();
        $where = array();
        if ($this->input->get('type') == 'monthly') {
            $where = array(
                'YEAR(t_sales_order.so_date)' => $this->input->get('year2'),
            );
            //$groupby = array('MONTH(so_date)');
        } else {
            $where = array(
                'MONTH(t_sales_order.so_date)' => $this->input->get('month'),
                'YEAR(t_sales_order.so_date)' => $this->input->get('year'),
            );
        }
        if ($this->input->get('branch') != "all") {
            $where['t_sales_order.id_branch'] = $this->input->get('branch');
        }
        $sort = array(
            'sort_field' => isset($_POST['sort']) ? $_POST['sort'] : "t_sales_order.so_date",
            'sort_direction' => isset($_POST['sort_dir']) ? $_POST['sort_dir'] : "asc"
        );
        
        $data['list'] = $this->m_penjualan->getListTable($field,$table, $join, $like, $where, $sort, false);
        $data['template_excel'] = "r_penjualan/table_excel";        log_message('DEBUG', print_r($data['list'],true));
        $data['file_name'] = "report_penjualan";
        $this->load->view('template_excel', $data);
    }

}
