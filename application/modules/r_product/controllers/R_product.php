<?php

class R_product extends MX_Controller {

    var $table = "t_sales_order";

    public function __construct() {
        parent::__construct();
            $this->load->model(array('M_r_product' => 'm_product', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Report', '/dasboard');
        $this->breadcrumbs->push('Report Product', '/employee-level');
    }

    public function index() {
        $data['template_title'] = array('Report Product', 'List');
        $data['view'] = 'r_product/main';
        $this->load->view('default', $data);
    }

    public function getReport() {
        $month = $this->input->post('month');
        $year = $this->input->post('year');

        $arr_month = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
        $arr_month_long = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'Augustus', 'September', 'October', 'November', 'December');
        $product = explode(',',$this->input->post('product'));
        if ($month == NULL || $month == "") {
            //log_message('DEBUG',print_r($product,true));
            $dt_product = array();
            foreach ($product as $k => $v) {
                $nm_product = $this->db->get_where('m_product',array('product_code'=>$v))->row_array();
                $dt = $this->m_product->getYearlyReport($year,$v);
                $dt_product[] =array('name'=>$nm_product['product_name'],'data'=>$dt);
            }
            unset($arr_month_long[0]);
            $title = 'Product Report ' . $year;
            $subtitle = 'Sales Order';
            $category = $arr_month_long;
            $value = $dt_product;
        } else {
            $tgl = array();
            for ($i=1;$i<=31;$i++) {
                $tgl[] = (int) $i;
            }
            $dt_product = array();
            foreach ($product as $k => $v) {
                $nm_product = $this->db->get_where('m_product',array('product_code'=>$v))->row_array();
                $dt = $this->m_product->getDailyReport($month,$year,$v);
                $dt_product[] =array('name'=>$nm_product['product_name'],'data'=>$dt);
            }

            $title = 'Product Report ' . $arr_month_long[$month];
            $subtitle = 'Sales Order';
            unset($arr_month[0]);
            $category = $tgl;
            $value = $dt_product;
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
                "m_product.product_name",
                "m_product.id as product_id",
                "t_sales_order.id as so_id",
                "t_sales_order.so_code",
                "t_sales_order.so_date",
                "concat(m_product.product_name,' - ',DATE_FORMAT(t_sales_order.so_date,'%M')) as kelompok"
            );
        } else {
            $field = array(
                "m_product.product_name",
                "m_product.id as product_id",
                "t_sales_order.id as so_id",
                "t_sales_order.so_code",
                "t_sales_order.so_date",
                "concat(m_product.product_name,' - ',DATE_FORMAT(t_sales_order.so_date,'%M, %d')) as kelompok"
            );
        }

        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 't_sales_order_product', 'where' => 't_sales_order.id=t_sales_order_product.id_sales_order', 'join' => 'INNER'),
            array('table' => 'm_product', 'where' => 'm_product.id=t_sales_order_product.id_product', 'join' => 'INNER')
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
        $where_in = explode(',',$this->input->post('product'));
        $sort = array(
            'sort_field' => isset($_POST['sort']) ? $_POST['sort'] : "t_sales_order.so_date",
            'sort_direction' => isset($_POST['sort_dir']) ? $_POST['sort_dir'] : "asc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );

        $list = $this->m_product->getListTable($field, $table, $join, $like, $where, $sort, $limit_row,$where_in);
        $dt_new = array();
        foreach ($list as $k=>$v) {
            $qty_product = $this->m_product->countProduct($v)->row_array();
            $dt_new[] = array(
                'qty' => $qty_product['total'],
                'product_name' => $v['product_name'],
                'product_id' => $v['product_id'],
                'so_id' => $v['so_id'],
                'so_code' => $v['so_code'],
                'so_date' => $v['so_date'],
                'kelompok' => $v['kelompok']
            );
        }
        $total_records = count($dt_new);
        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $total_records,
            "data" => $dt_new,
        );
        //output to json format
        echo json_encode($output);
    }
    
    public function getListProduct() {
        $list = $this->db->get_where('m_product',array('product_status'=>1))->result_array();
        echo json_encode($list);
    }

}
