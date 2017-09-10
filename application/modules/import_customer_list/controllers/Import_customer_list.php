<?php

class Import_customer_list extends MX_Controller {

    var $table = "m_customer_temp";
    private $countRow = 2;
    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_import_customer_list' => 'm_master_list', 'Datatable_model' => 'data_table', 'Main_model'=>'main_model'));
        $this->load->helper('download');
        $this->load->library(array('upload', 'encrypt', 'Printpdf', 'Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Import Customer List', '/import-customer-list');
    }

    public function index() {
        $data['template_title'] = array('Import Customer List', 'Form');
        $data['view'] = 'import_customer_list/main';
        $this->load->view('default', $data);
    }
    
    public function template_excel() {
        //ob_clean();
        //force_download('master-list-template.xlsx',file_get_contents('assets/excelTemplate/templateMasterList.xlsx'));
        $this->load->library("phpexcel/PHPExcel");
        $this->load->library("phpexcel/PHPExcel/IOFactory");
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->applyFromArray(
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
        
        $objPHPExcel->getActiveSheet()->getStyle('R1:S1')->applyFromArray(
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

        $objPHPExcel->getActiveSheet()->getStyle('U1:V1')->applyFromArray(
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
        
        $objPHPExcel->getActiveSheet()->getStyle('X1:Y1')->applyFromArray(
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
        
        $objPHPExcel->getActiveSheet()->getStyle('AA1:AB1')->applyFromArray(
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
        $HeaderTitle = array('Name', 'Specialis', 'Clinic', 'Province', 'City', 'District', 'Longitude', 'Latitude', 'Address', 'Telephone', 'Email','ID Status List', 'Notes', 'ID Area', 'ID Group Product', 'ID Branch');
        $headerMulai = "A";
        foreach ($HeaderTitle as $headerTitleV) {
            $objPHPExcel->getActiveSheet()->SetCellValue($headerMulai . "1", $headerTitleV);
            $headerMulai++;
        }

        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'ID Group Product');
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Detail Group Product');
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'ID Status Customer');
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Detail Status Customer');
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'ID Area');
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Detail Area');
        $objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'ID Branch');
        $objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'Detail Branch');
        
        $rowCount1 = $this->countRow;
        $status = $this->db->get_where('group_customer_product',array('group_customer_product_status'=>1))->result_array();
        foreach ($status as $k => $row) {
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount1, $row['id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount1, $row['group_customer_product']);
            $rowCount1++;
        }
        $objPHPExcel->getActiveSheet()->getStyle('R2:S'.(count($status)+1))->applyFromArray(
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
        $status = $this->db->get_where('status_list_customer',array('status_list_customer_status'=>1))->result_array();
        foreach ($status as $k => $row) {
            $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount2, $row['id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount2, $row['status_list_customer']);
            $rowCount2++;
        }
        $objPHPExcel->getActiveSheet()->getStyle('U2:V'.(count($status)+1))->applyFromArray(
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
        $status = $this->db->get_where('m_subarea',array('subarea_status'=>1))->result_array();
        foreach ($status as $k => $row) {
            $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount3, $row['id_area']."-".$row['id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount3, $row['subarea_name']);
            $rowCount3++;
        }
        $objPHPExcel->getActiveSheet()->getStyle('X2:Y'.(count($status)+1))->applyFromArray(
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
        
        $rowCount4 = $this->countRow;
        $status = $this->db->get_where('m_branch',array('branch_status'=>1))->result_array();
        foreach ($status as $k => $row) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount4, $row['id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount4, $row['branch_name']);
            $rowCount4++;
        }
        $objPHPExcel->getActiveSheet()->getStyle('AA2:AB'.(count($status)+1))->applyFromArray(
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
        $fileName = 'assets/excelTemplate/templateCustomerList.xlsx';
        $objWriter->save($fileName);
        force_download('assets/excelTemplate/templateCustomerList.xlsx', NULL);
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

                $this->db->delete('m_customer_temp', array('sys_create_user' => $this->sessionGlobal['id']));

                //  Get worksheet dimensions
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                //  Loop through each row of the worksheet in turn
                for ($row = 2; $row <= $highestRow; $row++) {                  //  Read a row of data into an array                 
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                    $explode_area = explode("-",$rowData[0][13]);
                    $data = array(
                        "customer_name" => $rowData[0][0],
                        "customer_specialis" => $rowData[0][1],
                        "customer_clinic" => ($rowData[0][2] != "" ? $rowData[0][2] : "-"),
                        "customer_province" => $rowData[0][3],
                        "customer_city" => $rowData[0][4],
                        "customer_district" => $rowData[0][5],
                        "customer_latitude" => ($rowData[0][6] != "" ? $rowData[0][6] : "-"),
                        "customer_longitude" => ($rowData[0][7] != "" ? $rowData[0][7] : "-"),
                        "customer_address" => $rowData[0][8],
                        "customer_phone" => ($rowData[0][9] != "" ? $rowData[0][9] : "0"),
                        "customer_email" => ($rowData[0][10] != "" ? $rowData[0][10] : "-"),
                        "status_list_customer" => $rowData[0][11],
                        "note" => $rowData[0][12],
                        "area" => $explode_area[0],
                        "subarea" => $explode_area[1],
                        "group_product" => $rowData[0][14],
                        "id_branch" => $rowData[0][15],
                        "sys_create_user" => $this->sessionGlobal['id'],
                        "sys_create_date" => date('Y-m-d H:i:s')
                    );
                    if($rowData[0][0] != "" || $rowData[0][0] != NULL) {
                        $sql = $this->db->insert('m_customer_temp', $data);
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
            $data = json_decode($this->input->post('data'));
            $dt_array = array_column($data,'id');
        } else {
            $dt_array = $dx;
        }
        
        
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
        
        foreach ((array)$data as $k=>$v) {
            $dt = array(
                'customer_code'=>$this->main_model->generate_code('m_customer', $this->config->item('customer_code').'/1','/' , $digit = 5, true,false, $where=array(),'id','id'),
                'customer_name'=>$v['customer_name'],
                'customer_specialis'=>$v['customer_specialis'],
                'customer_clinic'=>$v['customer_clinic'],
                'customer_address'=>$v['customer_address'],
                'customer_province'=>$v['customer_province'],
                'customer_city'=>$v['customer_city'],
                'customer_district'=>$v['customer_district'],
                'customer_phone'=>$v['customer_phone'],
                'customer_email'=>$v['customer_email'],
                'customer_latitude'=>$v['customer_latitude'],
                'customer_longitude'=>$v['customer_longitude'],
                'id_status_list_customer'=>$v['status_list_customer'],
                'customer_internal_notes'=>$v['note'],
                'id_area'=>$v['area'],
                'id_subarea'=>$v['subarea'],
                'id_group_customer_product'=>$v['group_product'],
                'id_branch'=>$v['id_branch'],
                'current_lead_customer_status'=>'C',
                'sys_create_date'=>date('Y-m-d H:i:s'),
                'sys_create_user'=>$this->sessionGlobal['id']
            );
            
            if($this->db->insert('m_customer', $dt)){
                $this->db->delete('m_customer_temp',array('id'=>$v['id']));
            } else {
                $result = array('code'=>204,'message'=>'failed');
                echo json_encode($result);
                die;
            }
        }
        $result = array('code'=>200,'message'=>'Success');
        echo json_encode($result);
    }

}
