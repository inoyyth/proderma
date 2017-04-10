<?php

class Stock_management extends MX_Controller {

    protected $table = "stock_management";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_Stock_management' => 'stock_management','product_list/M_product_list'=>'product_list'));
        $this->load->library(array('Auth_log','Table_fitersession'));
        //set breadcrumb
        //$this->breadcrumbs->push('Master Gudang', '/stock_management');
    }

    public function index() {
        $data_session = $this->table_fitersession->renders(array('page','product_list_sku','product_category_name','product_brand_name','product_list_name','product_list_stock','product_list_status'));
        $config['base_url'] = base_url() . 'stock-management-page';
        $config['per_page'] = (!empty($data_session['page']) ? $data_session['page'] : 10);
        $config['total_rows'] = count($this->product_list->getdata('product_list', 0, 1000, $like = $data_session, $where = array('product_list_status!=' => '3', 'product_list`.`user_id' => $this->sessionGlobal['id'])));
        $config['uri_segment'] = 2;
        $limit = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $this->pagination->initialize($config);
        $data['paging'] = $this->pagination->create_links();
        $data['data'] = $this->product_list->getdata('product_list', $limit, $config['per_page'], $like = $data_session, $where = array('product_list_status!=' => '3', 'product_list`.`user_id' => $this->sessionGlobal['id']));
        $data['total_rows'] = $config['total_rows'];
        $data['sr_data'] = $data_session;
        $data['params_status'] = $this->main_model->getMaster('global_params', array(), array('params' => 'status', 'code !=' => '3'));
        $data['view'] = 'stock_management/main';
        $this->load->view('default', $data);
    }

    public function add() {
        //$this->breadcrumbs->push('Add', '/stock_management-tambah');
        $data['params_status']=$this->main_model->getMaster('global_params',array(),array('params'=>'status','code !='=>'3'));
        $data['code'] = $this->main_model->generate_code($this->table, 'CTY', '-',4,false,false,array('user_id'=>$this->sessionGlobal['id']),'stock_management_code','id');
        $data['view'] = "stock_management/add";
        $this->load->view('default', $data);
    }

    public function edit($id) {
        //$this->breadcrumbs->push('Edit', '/stock_management-edit');
        $data['params_status']=$this->main_model->getMaster('global_params',array(),array('params'=>'status','code !='=>'3'));
        $data['detail'] = $this->db->get_where($this->table, array('id' => $id,'user_id'=>$this->sessionGlobal['id']))->row_array();
        $data['view'] = 'stock_management/edit';
        $this->load->view('default', $data);
    }

    function delete($id) {
        $this->main_model->delete('stock_management', array('id' => $id), array('stock_management_status' => '3','user_id'=>$this->sessionGlobal['id']));
        redirect("stock_management");
    }

    function save() {
        if ($_POST) {
            $user_id = $this->sessionGlobal['id'];
            if ($this->stock_management->save($user_id)) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("stock_management");
        } else {
            show_404();
        }
    }
    
    public function get_product_sku(){
        $query = $this->input->get('query');
        $data = $this->main_model->getMaster('product_list', $like=array('product_list_sku'=>$query), $where=array('product_list_status !='=>'3','user_id'=>$this->sessionGlobal['id']));
        echo json_encode($data);
    }
    
    public function get_detail_product(){
        $id = $this->input->post('id');
        $data['product'] = $this->main_model->getMaster('product_list', $like=array(), $where=array('id'=>$id,'user_id'=>$this->sessionGlobal['id']));
        echo json_encode($data);
    }
    
    public function get_stock_detail() {
        $table = 'product_stock';
        $join = array(
            array('table' => 'product_list', 'where' => $table.'.product_id=product_list.id', 'join' => 'INNER'),
        );
        $where = array('product_id'=>$this->input->post('kode'));
        $column_order = array(null, 'product_list_sku', 'jumlah', 'tanggal', 'add_or_min', 'description');
        $column_search = array('product_list_sku', 'jumlah', 'tanggal', 'add_or_min', 'description');
        $list = $this->datatable_model->get_datatables($table, $column_order, $column_search, $order = array($table.'.id'=>'asc'),$where,$join);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $result) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $result->product_list_sku;
            $row[] = $result->jumlah;
            $row[] = $result->tanggal;
            $row[] = ($result->add_or_min=="1"?"Tambah":"Kurang");
            $row[] = $result->description;

            $data[] = $row;
        }
    
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->datatable_model->count_all($table),
            "recordsFiltered" => $this->datatable_model->count_filtered($table, $column_order, $column_search, $order = array($table.'.id'=>'asc'),$where,$join),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function print_pdf() {
        $data['template'] = array("template" => "stock_management/" . $_GET['template'], "filename" => $_GET['name']);
        $data['list'] = $this->stock_management->getdata($this->table, 0, 1000, $like = array(), $where = array('stock_management_status!=' => '3','user_id'=>$this->sessionGlobal['id']));
        $this->printpdf->create_pdf($data);
    }

    public function print_excel() {
        $data['template_excel'] = "stock_management/" . $_GET['template'];
        $data['file_name'] = $_GET['name'];
        $data['list'] = $this->stock_management->getdata($this->table, 0, 1000, $like = array(), $where = array('stock_management_status!=' => '3','user_id'=>$this->sessionGlobal['id']));
        $this->load->view('template_excel', $data);
    }
}
