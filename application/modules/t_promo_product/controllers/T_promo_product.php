<?php

class T_promo_product extends MX_Controller {

    var $table = "m_promo_product";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_t_promo_product' => 'm_promo', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Master Promo Product', '/promo-product');
    }

    public function index() {
        $data['template_title'] = array('Master Promo Product', 'List');
        $data['view'] = 't_promo_product/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_promo_product'; 
        
        $field = array(
            "m_promo_product.*",
            "IF(m_promo_product.promo_status=1,'Active','Not Active') AS status"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array();
        
        $like = array(
            'm_promo_product.promo_code'=>isset($_POST['code'])?$_POST['code']:"",
            'm_promo_product.promo_name'=>isset($_POST['name'])?$_POST['name']:"",
        );
        $where = array('m_promo_product.promo_status !=' => '3');
		if($this->sessionGlobal['super_admin'] == "1") {
            $where['m_promo_product.id_branch'] = $this->sessionGlobal['id_branch'];
        }
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_promo_product.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_promo->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);
		$dx = array();
		foreach ($list as $k => $v) {
			$file = explode('/',$v['promo_file']);
			$dx[] = array(
				'promo_code' => $v['promo_code'],
				'promo_name' => $v['promo_name'],
				'promo_description' => $v['promo_description'],
				'status' => $v['status'],
				'file' => 'print-promo-'.end($file)
			);
		}
        $total_records = count($this->m_promo->getListTable($field,$table, $join, $like, $where, $sort, false));
        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $total_records,
            "data" => $dx,
        );
        //output to json format
        echo json_encode($output);
    }

    public function add() {
        $this->breadcrumbs->push('Add', '/promo-product-add');
        $data['code'] = $this->main_model->generate_code('m_promo_product', $this->config->item('promo_code').'/1','/' , $digit = 5, true,false, $where=array(),'id','id');
		$data['admin_status'] = $this->sessionGlobal['super_admin'];
        $data['view'] = "t_promo_product/add";
        $this->load->view('default', $data);
    }

    public function edit($id) {
        $this->breadcrumbs->push('Edit', '/promo-product-edit');
        $data['data'] = $this->db->get_where($this->table, array('id' => $id))->row_array();
		$data['admin_status'] = $this->sessionGlobal['super_admin'];
        $data['view'] = 't_promo_product/edit';
        $this->load->view('default', $data);
    }

    function delete($id) {
        if ($this->db->update($this->table, array('promo_status' => 3),array('id'=>$id))) {
            $this->session->set_flashdata('success', 'Data Berhasil Di Hapus !');
        } else {
            $this->session->set_flashdata('error', 'Data Gagal Di Hapus !');
        }
        redirect("promo-product");
    }

    function save() {
        //var_dump(serialize($_POST['menu']));die;
        if ($_POST) {
            if ($this->m_promo->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("promo-product");
        } else {
            show_404();
        }
    }
	
	public function getListBranch() {
		$dt = $this->db->get_where('m_branch',array('branch_status'=>1))->result_array();
		echo json_encode($dt);
	}

    public function print_pdf($filex) {
        $file = base_url('assets/images/promo_product/'.$filex); 
		$filename = 'promo.pdf'; /* Note: Always use .pdf at the end. */
		$content = file_get_contents($file);

		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="' . $file. '"');
		header('Content-Transfer-Encoding: binary');
		//header('Content-Length: ' . filesize($content));
		header('Accept-Ranges: bytes');

		@readfile($file);
    }

    public function print_excel() {
		$table = 'm_promo_product'; 
        $field = array(
            "m_promo_product.*",
            "IF(m_promo_product.promo_status=1,'Active','Not Active') AS status"
        );
        $join = array();
        $like = array();
        $where = array('m_promo_product.promo_status !=' => '3');
		if($this->sessionGlobal['super_admin'] == "1") {
            $where['m_promo_product.id_branch'] = $this->sessionGlobal['id_branch'];
        }
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_promo_product.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );
        $data['list'] = $this->m_promo->getListTable($field,$table, $join, $like, $where, $sort, false);
        $data['template_excel'] = "t_promo_product/table_excel";
        $data['file_name'] = "master_promo";
        $this->load->view('template_excel', $data);
    }

}
