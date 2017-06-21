<?php

class Import_master_list extends MX_Controller {

    var $table = "m_customer_temp";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_import_master_list' => 'm_master_list', 'Datatable_model' => 'data_table'));
        $this->load->helper('download');
        $this->load->library(array('upload', 'encrypt', 'Printpdf', 'Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Import Master List', '/import-master-list');
    }

    public function index() {
        $data['template_title'] = array('Import Master List', 'Form');
        $data['view'] = 'import_master_list/main';
        $this->load->view('default', $data);
    }
    
    public function template_excel() {
        ob_clean();
        force_download('master-list-template.xlsx',file_get_contents('assets/excelTemplate/templateMasterList.xlsx'));
    }
    
    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_customer_temp'; 
        
        $field = array(
            "m_customer_temp.*"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array();
        
        $like = array();
        $where = array('m_customer_temp.sys_create_user' => $this->sessionGlobal['id']);
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_customer_temp.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"asc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_master_list->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

        $total_records = $this->data_table->count_all($table, $where);
        $total_pages = ceil($total_records / $limit);
        $output = array(
            "last_page" => $total_pages,
            "recordsTotal" => $this->data_table->count_all($table, $where),
            "data" => $list,
        );
        //output to json format
        echo json_encode($output);
    }
    
    public function upload_excel() {
        if (!isset($_POST)) {
            show_404();
        } else {
            $this->load->library("phpexcel/PHPExcel");
            $this->load->library("phpexcel/PHPExcel/IOFactory");
            $folder = "excel";
            if (!is_dir('./assets/' . $folder)) {
                mkdir('./assets/' . $folder, 0777, TRUE);
            }
            $fileName = $_FILES['excel_file']['name'];

            $config['upload_path'] = "./assets/" . $folder;
            $config['upload_url'] = "./assets/" . $folder;
            $config['file_name'] = date('YmdHis') . "-" . $fileName;
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = '20000';
            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('excel_file')) {
                $media = $this->upload->data();
            }

            $inputFileName = "./assets/" . $folder . "/" . $media['file_name'];

            //  Read your Excel workbook
            try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }

            $this->db->delete('m_customer_temp', array('sys_create_user' => $this->sessionGlobal['id']));

            //  Get worksheet dimensions
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            //  Loop through each row of the worksheet in turn
            for ($row = 2; $row <= $highestRow; $row++) {                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                //insert new motor type if not existing
                //  Insert row data array into your database of choice here
                //dump(validate_date($rowData[0][2]),true);
                $data = array(
                    "customer_code" => $rowData[0][0],
                    "customer_name" => $rowData[0][1],
                    "customer_clinic" => $rowData[0][2],
                    "customer_address" => $rowData[0][3],
                    "customer_province" => $rowData[0][4],
                    "customer_city" => $rowData[0][5],
                    "customer_district" => $rowData[0][6],
                    "customer_phone" => $rowData[0][7],
                    "customer_email" => $rowData[0][8],
                    "customer_latitude" => $rowData[0][9],
                    "customer_longitude" => $rowData[0][10],
                    "id_source_lead_customer" => $rowData[0][11],
                    "id_status_list_customer" => $rowData[0][12],
                    "sys_create_user" => $this->sessionGlobal['id'],
                    "sys_create_date" => date('Y-m-d H:i:s')
                );
                //log_message('debug',print_r($data,true));
                //$this->db->insert("penerimaan_motor_temp", $data); 
                $sql = $this->db->insert_string('m_customer_temp', $data) . ' ON DUPLICATE KEY UPDATE customer_code=customer_code';
                $this->db->query($sql);
            }
            return true;
        }
    }
    
    public function deleteListTable($dx=null){
        if($dx == null){
            $data = json_decode($this->input->post('data'));
        } else {
            $data = json_decode($dx);
        }
        
        $dt_array = array_column($data,'id');
        $this->db->where_in('id', $dt_array);
       if($this->db->delete('m_customer_temp')){
           $result = array('code'=>200,'message'=>'success');
       } else {
           $result = array('code'=>204,'message'=>'failed');
       }
       echo json_encode($result);
    }
    
    public function saveListTable() {
        $data = json_decode($this->input->post('data'),TRUE);
        
        $dt = [];
        foreach ((array)$data as $k=>$v) {
            $dt[] = array(
                'customer_code'=>$v['customer_code'],
                'customer_name'=>$v['customer_name'],
                'customer_clinic'=>$v['customer_clinic'],
                'customer_address'=>$v['customer_address'],
                'customer_province'=>$v['customer_province'],
                'customer_city'=>$v['customer_city'],
                'customer_district'=>$v['customer_district'],
                'customer_phone'=>$v['customer_phone'],
                'customer_email'=>$v['customer_email'],
                'customer_latitude'=>$v['customer_latitude'],
                'customer_longitude'=>$v['customer_longitude'],
                'id_source_lead_customer'=>$v['id_source_lead_customer'],
                'id_status_list_customer'=>$v['id_status_list_customer'],
                'current_lead_customer_status'=>'L',
                'sys_create_date'=>date('Y-m-d H:i:s'),
                'sys_create_user'=>$this->sessionGlobal['id']
            );
        }
        if($this->db->insert_batch('m_customer', $dt)){
            $this->deleteListTable($this->input->post('data'));
        } else {
            $result = array('code'=>204,'message'=>'failed');
            echo json_encode($result);
        }
    }

}
