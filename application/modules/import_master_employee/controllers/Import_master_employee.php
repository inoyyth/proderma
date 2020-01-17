<?php

class Import_master_employee extends MX_Controller {

    var $table = "m_employee_temp";
    private $countRow = 2;
    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_import_master_employee' => 'm_employee_temp', 'Datatable_model' => 'data_table', 'Main_model'=>'main_model'));
        $this->load->helper('download');
        $this->load->library(array('upload', 'encryption', 'Printpdf', 'Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Utility', '/dasboard');
        $this->breadcrumbs->push('Import Master Employee', '/import-master-employee');
    }

    public function index() {
        $data['template_title'] = array('Import Master Employee', 'Form');
        $data['view'] = 'import_master_employee/main';
        $this->load->view('default', $data);
    }
    
    public function template_excel() {
        //ob_clean();
        //force_download('master-list-template.xlsx',file_get_contents('assets/excelTemplate/templateMasterList.xlsx'));
        $this->load->library("phpexcel/PHPExcel");
        $this->load->library("phpexcel/PHPExcel/IOFactory");
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'B3FFb3')
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                )
        );
        $objPHPExcel->getActiveSheet()->getStyle('I1:J1')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'B3FFb3')
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                )
        );
        $objPHPExcel->getActiveSheet()->getStyle('L1:M1')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'B3FFb3')
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                )
        );
        $objPHPExcel->getActiveSheet()->getStyle('O1:P1')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'B3FFb3')
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                )
        );
        
        $objPHPExcel->setActiveSheetIndex(0);
        $HeaderTitle = array('NIP', 'Name', 'Email', 'Phone', 'Gender', 'ID Jabatan', 'ID Branch Office');
        $headerMulai = "A";
        foreach ($HeaderTitle as $headerTitleV) {
            $objPHPExcel->getActiveSheet()->SetCellValue($headerMulai . "1", $headerTitleV);
            $headerMulai++;
        }
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'ID Jabatan');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Detail Jabatan');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'ID Branch Office');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Detail Branch Office');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Gender');
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Detail Gender');
       
        $rowCount1 = $this->countRow;
        $source = $this->db->get_where('m_jabatan',array('jabatan_status'=>1))->result_array();
        foreach ($source as $k => $row) {
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount1, $row['id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount1, $row['jabatan']);
            $rowCount1++;
        }
        $objPHPExcel->getActiveSheet()->getStyle('I2:J'.(count($source)+1))->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '80BFFF')
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                )
        );
        
        $rowCount2 = $this->countRow;
        $status = $this->db->get_where('m_branch',array('branch_status'=>1))->result_array();
        foreach ($status as $k => $row) {
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount2, $row['id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount2, $row['branch_name']);
            $rowCount2++;
        }
        $objPHPExcel->getActiveSheet()->getStyle('L2:M'.(count($status)+1))->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '80BFFF')
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                )
        );
        
        $rowCount3 = $this->countRow;
        $status = array('F'=>'Female (Perempuan)','M'=>'Male (Laki-laki)');
        foreach ($status as $k => $row) {
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount3, $k);
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount3, $row);
            $rowCount3++;
        }
        $objPHPExcel->getActiveSheet()->getStyle('O2:P'.(count($status)+1))->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '80BFFF')
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                )
        );
        
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $fileName = 'assets/excelTemplate/templateMasterEmployee.xlsx';
        $objWriter->save($fileName);
        force_download('assets/excelTemplate/templateMasterEmployee.xlsx', NULL);
    }
    
    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_employee_temp'; 
        
        $field = array(
            "m_employee_temp.*",
            "IF(m_employee_temp.employee_gender='F','Female','Male') AS gender",
            "m_jabatan.jabatan",
            "m_branch.branch_name"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'm_jabatan', 'where' => 'm_jabatan.id=m_employee_temp.id_jabatan', 'join' => 'INNER'),
            array('table' => 'm_branch', 'where' => 'm_branch.id=m_employee_temp.id_branch', 'join' => 'INNER')
        );
        
        $like = array();
        $where = array('m_employee_temp.sys_create_user' => $this->sessionGlobal['id']);
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_employee_temp.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"asc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_employee_temp->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

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
            $config['max_size'] = '200000000';
            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('excel_file')) {
                $media = $this->upload->data();
                $inputFileName = "./assets/" . $folder . "/" . $media['file_name'];

                //  Read your Excel workbook
                try {
                    $inputFileType = IOFactory::identify($inputFileName);
                    $objReader = IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                } catch (Exception $e) {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                }

                $this->db->delete('m_employee_temp', array('sys_create_user' => $this->sessionGlobal['id']));

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
                    $explode_area = explode("-",$rowData[0][6]);
                    $pass = "";
                    if ($rowData[0][5] == 1) {
                        $pass = $this->encrypt->encode(1234);
                    }
                    $data = array(
                        "employee_nip" => $rowData[0][0],
                        "employee_name" => $rowData[0][1],
                        "employee_email" => $rowData[0][2],
                        "employee_phone" => ($rowData[0][3] != "" ? $rowData[0][3] : "-"),
                        "employee_gender" => ($rowData[0][4] != "" ? $rowData[0][4] : "-"),
                        "sales_password" => $pass,
                        "id_jabatan" => $rowData[0][5],
                        "id_branch" => $rowData[0][6],
                        "sys_create_user" => $this->sessionGlobal['id'],
                        "sys_create_date" => date('Y-m-d H:i:s')
                    );
                    //log_message('debug',print_r($data,true));
                    //$this->db->insert("penerimaan_motor_temp", $data); 
                    if( ($rowData[0][0] != "" || $rowData[0][0] != NULL) && 
                        ($rowData[0][2] != "" || $rowData[0][2] != NULL) && 
                        ($rowData[0][5] != "" || $rowData[0][5] != NULL) && 
                        ($rowData[0][6] != "" || $rowData[0][6] != NULL)
                    ) {
                        if($this->__cekDuplicate('m_employee_temp','employee_nip',$rowData[0][0])) {
                            $sql = $this->db->insert_string('m_employee_temp', $data) . ' ON DUPLICATE KEY UPDATE employee_nip=employee_nip';
                            $this->db->query($sql);
                        }
                    }
                }
                    return true;
            } else {
                $error = array('error' => $this->upload->display_errors());
                var_dump($error);
            }

            
        }
    }
    
    public function deleteListTable($dx=null){
        if($dx == null){
            $data = json_decode($this->input->post('data'),true);
            $dt_array = array_column($data,'id');
        } else {
            $dt_array = $dx;
        }
        
        
        $this->db->where_in('id', $dt_array);
       if($this->db->delete('m_employee_temp')){
           $result = array('code'=>200,'message'=>'success');
       } else {
           $result = array('code'=>204,'message'=>'failed');
       }
       echo json_encode($result);
    }
    
    public function saveListTable() {
        $data = json_decode($this->input->post('data'),TRUE);
        
        foreach ((array)$data as $k=>$v) {
            $dt = array(
                'id_jabatan'=>$v['id_jabatan'],
                'employee_nip'=>$v['employee_nip'],
                'employee_name'=>$v['employee_name'],
                'employee_email'=>$v['employee_email'],
                'employee_phone'=>$v['employee_phone'],
                'employee_gender'=>$v['employee_gender'],
                'sales_password'=>$v['sales_password'],
                'id_branch'=>$v['id_branch'],
                'sys_create_date'=>date('Y-m-d H:i:s'),
                'sys_create_user'=>$this->sessionGlobal['id']
            );
            if($this->__cekDuplicate('m_employee',array('employee_nip'=>$v['employee_nip'],'employee_email'=>$v['employee_email']))) {
                if($this->db->insert('m_employee', $dt)){
                    $this->db->delete('m_employee_temp',array('id'=>$v['id']));
                } else {
                    $result = array('code'=>204,'message'=>'failed');
                    echo json_encode($result);
                    die;
                }
            } else {
                 $this->db->delete('m_employee_temp',array('id'=>$v['id']));
            }
        }
        $result = array('code'=>200,'message'=>'Success');
        echo json_encode($result);
    }
    
    private function __cekDuplicate($table,$where){
        $this->db->select('count(*) as total');
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get()->row_array();
        if($query['total'] > 0) {
            return false;
        }
        return true;
    }

}
