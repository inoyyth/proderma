<?php

class Import_master_product extends MX_Controller {

    var $table = "m_product_temp";
    private $countRow = 2;
    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_import_master_product' => 'm_product_temp', 'Datatable_model' => 'data_table', 'Main_model'=>'main_model'));
        $this->load->helper('download');
        $this->load->library(array('upload', 'encryption', 'Printpdf', 'Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Utility', '/dasboard');
        $this->breadcrumbs->push('Import Master Product', '/import-master-product');
    }

    public function index() {
        $data['template_title'] = array('Import Master Product', 'Form');
        $data['view'] = 'import_master_product/main';
        $this->load->view('default', $data);
    }
    
    public function template_excel() {
        //ob_clean();
        //force_download('master-list-template.xlsx',file_get_contents('assets/excelTemplate/templateMasterList.xlsx'));
        $this->load->library("phpexcel/PHPExcel");
        $this->load->library("phpexcel/PHPExcel/IOFactory");
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray(
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
        $objPHPExcel->getActiveSheet()->getStyle('J1:K1')->applyFromArray(
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
        $objPHPExcel->getActiveSheet()->getStyle('M1:N1')->applyFromArray(
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
        $HeaderTitle = array('Product Code', 'Product Name', 'Product Price', 'Klasifikasi', 'Komposisi', 'Sediaan', 'ID Category', 'ID Group Product');
        $headerMulai = "A";
        foreach ($HeaderTitle as $headerTitleV) {
            $objPHPExcel->getActiveSheet()->SetCellValue($headerMulai . "1", $headerTitleV);
            $headerMulai++;
        }
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'ID Catagory');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Detail Category');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'ID Group Product');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Detail Group Product');
       
        $rowCount1 = $this->countRow;
        $source = $this->m_product_temp->getSubAndCategory(array('m_product_category.product_category_status'=>1,'m_product_sub_category.product_sub_category_status'=>1))->result_array();
        foreach ($source as $k => $row) {
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount1, $row['Kode']);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount1, $row['Name']);
            $rowCount1++;
        }
        $objPHPExcel->getActiveSheet()->getStyle('J2:K'.(count($source)+1))->applyFromArray(
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
        $status = $this->db->get_where('m_group_product',array('group_product_status'=>1))->result_array();
        foreach ($status as $k => $row) {
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount2, $row['id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount2, $row['group_product']);
            $rowCount2++;
        }
        $objPHPExcel->getActiveSheet()->getStyle('M2:N'.(count($status)+1))->applyFromArray(
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
        $fileName = 'assets/excelTemplate/templateMasterProduct.xlsx';
        $objWriter->save($fileName);
        force_download('assets/excelTemplate/templateMasterProduct.xlsx', NULL);
    }
    
    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_product_temp'; 
        
        $field = array(
            "m_product_temp.*",
            "m_product_category.product_category",
            "m_product_sub_category.sub_category_name"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array(
            array('table' => 'm_product_category', 'where' => 'm_product_category.id=m_product_temp.id_product_category', 'join' => 'left'),
            array('table' => 'm_product_sub_category', 'where' => 'm_product_sub_category.id=m_product_temp.id_product_sub_category', 'join' => 'left')
        );
        
        $like = array();
        $where = array('m_product_temp.sys_create_user' => $this->sessionGlobal['id']);
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_product_temp.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"asc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_product_temp->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

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

                $this->db->delete('m_product_temp', array('sys_create_user' => $this->sessionGlobal['id']));

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
                    $data = array(
                        "product_code" => $rowData[0][0],
                        "product_name" => $rowData[0][1],
                        "product_price" => $rowData[0][2],
                        "klasifikasi" => ($rowData[0][3] != "" ? $rowData[0][3] : "-"),
                        "komposisi" => ($rowData[0][4] != "" ? $rowData[0][4] : "-"),
                        "sediaan" => ($rowData[0][5] != "" ? $rowData[0][5] : "-"),
                        "id_product_category" => $explode_area[0],
                        "id_product_sub_category" => $explode_area[1],
                        "id_group_product" => $rowData[0][7],
                        "sys_create_user" => $this->sessionGlobal['id'],
                        "sys_create_date" => date('Y-m-d H:i:s')
                    );
                    //log_message('debug',print_r($data,true));
                    //$this->db->insert("penerimaan_motor_temp", $data); 
                    if($rowData[0][0] != "" || $rowData[0][0] != NULL) {
                        if($this->__cekDuplicate('m_product_temp','product_code',$rowData[0][0])) {
                            $sql = $this->db->insert_string('m_product_temp', $data) . ' ON DUPLICATE KEY UPDATE product_code=product_code';
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
			//var_dump(array_column($data,'id'));die;
            $dt_array = array_column($data,'id');
        } else {
            $dt_array = $dx;
        }
        
        
        $this->db->where_in('id', $dt_array);
       if($this->db->delete('m_product_temp')){
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
                'id_product_category'=>$v['id_product_category'],
                'id_product_sub_category'=>$v['id_product_sub_category'],
                'id_group_product'=>$v['id_group_product'],
                'product_code'=>$v['product_code'],
                'product_name'=>$v['product_name'],
                'product_price'=>$v['product_price'],
                'klasifikasi'=>$v['klasifikasi'],
                'komposisi'=>$v['komposisi'],
                'sediaan'=>$v['sediaan'],
                'sys_create_date'=>date('Y-m-d H:i:s'),
                'sys_create_user'=>$this->sessionGlobal['id']
            );
            if($this->__cekDuplicate('m_product','product_code',$v['product_code'])) {
                if($this->db->insert('m_product', $dt)){
                    $this->db->delete('m_product_temp',array('id'=>$v['id']));
                } else {
                    $result = array('code'=>204,'message'=>'failed');
                    echo json_encode($result);
                    die;
                }
            } else {
                 $this->db->delete('m_product_temp',array('id'=>$v['id']));
            }
        }
        $result = array('code'=>200,'message'=>'Success');
        echo json_encode($result);
    }
    
    private function __cekDuplicate($table,$field,$where){
        $this->db->select('count(*) as total');
        $this->db->from($table);
        $this->db->where($field,$where);
        $query = $this->db->get()->row_array();
        if($query['total'] > 0) {
            return false;
        }
        return true;
    }

}
