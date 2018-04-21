<?php

class R_call extends MX_Controller {

    var $table = "sales_visit";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_r_call' => 'm_call', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Report', '/dasboard');
        $this->breadcrumbs->push('Report Call', '/r_call');
    }

    public function index() {
        $data['branch'] = $this->db->get_where('m_branch',array('branch_status' => 1))->result_array();
        $data['template_title'] = array('Report Call', 'List');
        $data['view'] = 'r_call/main';
        $this->load->view('default', $data);
    }

    public function getReport() {
        $month = $this->input->post('month');
        $year = $this->input->post('year');

        $arr_month = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
        $arr_month_long = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'Augustus', 'September', 'October', 'November', 'December');
        $employee = $this->input->post('employee');
        if ($month == NULL || $month == "") {
            $nm_employee = $this->db->get_where('m_employee',array('employee_nip'=>$employee,'employee_status'=>1))->row_array();
            $dt = $this->m_call->getYearlyReport($year,$nm_employee['id']);
            unset($arr_month_long[0]);
            $title = 'Call Report ' . $year;
            $subtitle = $nm_employee['employee_nip'] . " - " . $nm_employee['employee_name'];
            $category = $arr_month_long;
            $value = $dt;
        } else {
            $tgl = array();
            for ($i=1;$i<=31;$i++) {
                $tgl[] = (int) $i;
            }
            $dt_employee = array();
            //foreach ($employee as $k => $v) {
                $nm_employee = $this->db->get_where('m_employee',array('employee_nip'=>$employee,'employee_status'=>1))->row_array();
                $dt = $this->m_call->getDailyReport($month,$year,$nm_employee['id']);
                //$dt_employee[] =array('name'=>$nm_employee['employee_name'],'data'=>$dt);
            //}

            $title = 'Call Report ' . $arr_month_long[$month];
            $subtitle = $nm_employee['employee_nip'] . " - " . $nm_employee['employee_name'];
            unset($arr_month[0]);
            $category = $tgl;
            $value = $dt;
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

        $table = 'sales_visit';

        if ($this->input->post('month') == NULL || $this->input->post('month') == '') {
            $field = array(
                "sales_visit.*",
                "m_customer.customer_code",
                "m_customer.customer_name",
                "m_objective.objective",
                "DATE_FORMAT(sales_visit.sales_visit_date,'%M') as kelompok"
            );
        } else {
            $field = array(
                "sales_visit.*",
                "m_customer.customer_code",
                "m_customer.customer_name",
                "m_objective.objective",
                "DATE_FORMAT(sales_visit.sales_visit_date,'%M, %d') as kelompok"
            );
        }

        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'm_customer', 'where' => 'm_customer.id=sales_visit.id_customer', 'join' => 'INNER'),
            array('table' => 'm_objective', 'where' => 'm_objective.id=sales_visit.activity', 'join' => 'INNER'),
            array('table' => 'm_employee', 'where' => 'm_employee.id=sales_visit.id_sales', 'join' => 'INNER')
        );
        $like = array();
        $where = array();
        if ($this->input->post('month') == NULL || $this->input->post('month') == '') {
            $where = array(
                'YEAR(sales_visit.sales_visit_date)' => $this->input->post('year'),
                'm_employee.employee_nip' => $this->input->post('employee')
            );
            //$groupby = array('MONTH(so_date)');
        } else {
            $where = array(
                'MONTH(sales_visit.sales_visit_date)' => $this->input->post('month'),
                'YEAR(sales_visit.sales_visit_date)' => $this->input->post('year'),
                'm_employee.employee_nip' => $this->input->post('employee')
            );
        }

        $sort = array(
            'sort_field' => isset($_POST['sort']) ? $_POST['sort'] : "sales_visit.sales_visit_date",
            'sort_direction' => isset($_POST['sort_dir']) ? $_POST['sort_dir'] : "asc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );

        $list = $this->m_call->getListTable($field, $table, $join, $like, $where, $sort, $limit_row);
        /*$dt_new = array();
        foreach ($list as $k=>$v) {
            $qty_employee = $this->m_call->countProduct($v)->row_array();
            $dt_new[] = array(
                'qty' => $qty_employee['total'],
                'employee_name' => $v['employee_name'],
                'employee_id' => $v['employee_id'],
                'so_id' => $v['so_id'],
                'so_code' => $v['so_code'],
                'so_date' => $v['so_date'],
                'kelompok' => $v['kelompok']
            );
        }*/
        $total_records = count($list);
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
        
        $data['list'] = $this->m_call->getListTable($field,$table, $join, $like, $where, $sort, false);
        $data['template_excel'] = "r_call/table_excel";        log_message('DEBUG', print_r($data['list'],true));
        $data['file_name'] = "report_penjualan";
        $this->load->view('template_excel', $data);
    }

}
