<?php

class R_performance extends MX_Controller {

    var $table = "t_sales_order";

    public function __construct() {
        parent::__construct();
            $this->load->model(array('M_r_performance' => 'm_performance', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Report', '/dasboard');
        $this->breadcrumbs->push('Report Performance', '/employee-level');
    }

    public function index() {
        $data['template_title'] = array('Report Performance', 'List');
        $data['view'] = 'r_performance/main';
        $this->load->view('default', $data);
    }

    public function getReport() {
        $month = $this->input->post('month');
        $year = $this->input->post('year');

        $arr_month = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
        $arr_month_long = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'Augustus', 'September', 'October', 'November', 'December');
        $employee = explode(',',$this->input->post('employee'));
        if ($month == NULL || $month == "") {
            //log_message('DEBUG',print_r($employee,true));
            $dt_employee = array();
            foreach ($employee as $k => $v) {
                $nm_employee = $this->db->get_where('m_employee',array('employee_nip'=>$v,'employee_status' => 1))->row_array();
                $dt = $this->m_performance->getYearlyReport($year,$v);
                $dt_employee[] =array('name'=>$nm_employee['employee_name'],'data'=>$dt);
            }
            unset($arr_month_long[0]);
            $title = 'Performance Report ' . $year;
            $subtitle = 'Sales Order';
            $category = $arr_month_long;
            $value = $dt_employee;
        } else {
            $tgl = array();
            for ($i=1;$i<=31;$i++) {
                $tgl[] = (int) $i;
            }
            $dt_employee = array();
            foreach ($employee as $k => $v) {
                $nm_employee = $this->db->get_where('m_employee',array('employee_nip'=>$v,'employee_status' => 1))->row_array();
                $dt = $this->m_performance->getDailyReport($month,$year,$v);
                $dt_employee[] =array('name'=>$nm_employee['employee_name'],'data'=>$dt);
            }

            $title = 'Performance Report ' . $arr_month_long[$month];
            $subtitle = 'Sales Order';
            unset($arr_month[0]);
            $category = $tgl;
            $value = $dt_employee;
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
                "t_sales_order.id as so_id",
                "t_sales_order.so_code",
                "t_sales_order.so_date",
                "concat(m_employee.employee_name,' - ',DATE_FORMAT(t_sales_order.so_date,'%M')) as kelompok"
            );
        } else {
            $field = array(
                "t_sales_order.id as so_id",
                "t_sales_order.so_code",
                "t_sales_order.so_date",
                "concat(m_employee.employee_name,' - ',DATE_FORMAT(t_sales_order.so_date,'%M, %d')) as kelompok"
            );
        }

        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'm_employee', 'where' => 'm_employee.id=t_sales_order.id_sales', 'join' => 'INNER')
        );
        $like = array();
        $where = array();
        if ($this->input->post('month') == NULL || $this->input->post('month') == '') {
            $where = array(
                'YEAR(t_sales_order.so_date)' => $this->input->post('year'),
                't_sales_order.so_status' => 1
            );
            //$groupby = array('MONTH(so_date)');
        } else {
            $where = array(
                'MONTH(t_sales_order.so_date)' => $this->input->post('month'),
                'YEAR(t_sales_order.so_date)' => $this->input->post('year'),
                't_sales_order.so_status' => 1
            );
        }
        $where_in = explode(',',$this->input->post('employee'));
        $sort = array(
            'sort_field' => isset($_POST['sort']) ? $_POST['sort'] : "t_sales_order.so_date",
            'sort_direction' => isset($_POST['sort_dir']) ? $_POST['sort_dir'] : "asc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );

        $list = $this->m_performance->getListTable($field, $table, $join, $like, $where, $sort, $limit_row,$where_in);
        /*$dt_new = array();
        foreach ($list as $k=>$v) {
            $qty_employee = $this->m_performance->countProduct($v)->row_array();
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
    
    public function getListProduct() {
        $list = $this->db->get_where('m_performance',array('employee_status'=>1))->result_array();
        echo json_encode($list);
    }

}
