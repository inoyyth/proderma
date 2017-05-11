<?php

class Backup_db extends MX_Controller {

    var $table = "m_backup_db";

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_backup_db' => 'm_backup_db', 'Datatable_model' => 'data_table'));
        $this->load->library(array('Auth_log'));
        //set breadcrumb
        $this->breadcrumbs->push('Backup Database', '/backup-database');
    }

    public function index() {
        $data['template_title'] = array('Backup Database', 'List');
        $data['view'] = 'backup_db/main';
        $this->load->view('default', $data);
    }

    public function getListTable() {
        $page = ($_POST['page']==0?1:$_POST['page']);
        $limit = $_POST['size'];
        
        $table = 'm_backup_db'; 
        
        $field = array(
            "m_backup_db.*"
            //"IF(m_jabatan.jabatan_status=1,'Active','Not Active') AS status"
        );
        
        $offset = ($page - 1) * $limit;

        $join = array();
        
        $like = array(
            'm_backup_db.backup_file'=>isset($_POST['backup_file'])?$_POST['backup_file']:""
        );
        $where = array();
        $sort = array(
            'sort_field' => isset($_POST['sort'])?$_POST['sort']:"m_backup_db.id",
            'sort_direction' => isset($_POST['sort_dir'])?$_POST['sort_dir']:"desc"
        );

        $limit_row = array(
            'offset' => $offset,
            'limit' => $limit
        );
        
        $list = $this->m_backup_db->getListTable($field,$table, $join, $like, $where, $sort, $limit_row);

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

    public function add() {
        $this->load->dbutil();

        $prefs = array(
            'format' => 'zip',
            'filename' => 'my_db_backup.sql'
        );

        $backup = & $this->dbutil->backup($prefs);

        $db_name = 'backup-on-' . date("Y-m-d-H-i-s") . '.zip';
        $folder = "backupdb";
        if (!is_dir('./assets/' . $folder)) {
            mkdir('./assets/' . $folder, 0777, TRUE);
        }
        $save = 'assets/' . $folder . '/' . $db_name;
        chmod($save,777);
        
        $this->load->helper('file');

        try {
            write_file($save, $backup);
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        } finally {
            try {
                $this->db->insert('m_backup_db',$this->main_model->create_sys(array('backup_file'=>$db_name)));
            } catch (Exception $e) {
                echo 'Caught exception: ', $e->getMessage(), "\n";
            } finally {
                $this->load->helper('download');
                force_download($db_name, $backup);
            }
        }
    }

    public function edit($id) {
        $this->breadcrumbs->push('Edit', '/backup-database-edit');
        $data['detail'] = $this->db->get_where($this->table, array('id' => $id))->row_array();
        $data['view'] = 'backup_db/edit';
        $this->load->view('default', $data);
    }

    function delete($id) {
        $db = $this->db->get_where('m_backup_db',array('id'=>$id))->row_array();
        delete_files('/assets/backupdb/'.$db['backup_file']);
        $this->db->delete('m_backup_db', array('id' => $id));
        redirect("backup-database");
    }

    function save() {
        if ($_POST) {
            if ($this->m_backup_db->save()) {
                $this->session->set_flashdata('success', 'Data Berhasil Di Simpan !');
            } else {
                $this->session->set_flashdata('error', 'Data Gagal Di Simpan !');
            }
            redirect("backup-database");
        } else {
            show_404();
        }
    }

    public function __getSession() {
        if ($_POST) {
            return $data = array(
                'page' => set_session_table_search('page', $this->input->get_post('page', TRUE)),
                'backup_file' => set_session_table_search('backup_file', $this->input->get_post('backup_file', TRUE)),
                'sys_create_date' => set_session_table_search('sys_create_date', $this->input->get_post('sys_create_date', TRUE))
            );
        } else {
            return $data = array(
                'page' => $this->session->userdata('page'),
                'backup_file' => $this->session->userdata('backup_file'),
                'sys_create_date' => $this->session->userdata('sys_create_date')
            );
        }
    }

    public function print_pdf() {
        $data['template'] = array("template" => "backup_db/" . $_GET['template'], "filename" => $_GET['name']);
        $data['list'] = $this->m_backup_db->getdata($this->table, 0, 1000, $like = array(), $where = array('status_gudang!=' => '3'));
        $this->printpdf->create_pdf($data);
    }

    public function print_excel() {
        $data['template_excel'] = "backup_db/" . $_GET['template'];
        $data['file_name'] = $_GET['name'];
        $data['list'] = $this->m_backup_db->getdata($this->table, 0, 1000, $like = array(), $where = array('status_gudang!=' => '3'));
        $this->load->view('template_excel', $data);
    }

}
