<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Upload_cloudinary{
    
    function __construct() {
        //parent::__construct();
        $this->ci =& get_instance();
        $this->ci->load->library('Cloudinarylib');
        $this->ci->load->model('main_model');
        $this->ci->load->library('session');
    }
    
    function upload_image_cloudinary($folder){
        $image_hidden = $this->ci->input->post('image_hidden');
        //$folder = "account";
        if (!is_dir('./assets/images/' . $folder)) {
            mkdir('./assets/images/' . $folder, 0777, TRUE);
        }
        $image_config = array('upload_path' => './assets/images/' . $folder,
            'upload_url' => './assets/images/' . $folder,
            'encrypt_name' => true,
            'detect_mime' => true,
            'allowed_types' => 'gif|jpg|png', 'max_size' => 3000);
        $this->ci->upload->initialize($image_config);
        if ($this->ci->upload->do_upload('path_foto')) {
            $image = $this->ci->upload->data();
            $image_name = 'assets/images/' . $folder ."/". $image['file_name'];
            //upload to cloudinary
            $this->ci->main_model->upload_image_cloudinary($image_name);
        } else {
            if (isset($image_hidden) && !empty($image_hidden)) {
                $image_name = $image_hidden;
            } else {
                $error = array('error' => $this->ci->upload->display_errors());
                if(strpos($error['error'],"You did not select a file to upload.")==true){
                    $image_name = 'assets/images/user_icon.png';
                    //upload to cloudinary
                    //$this->ci->main_model->upload_image_cloudinary($image_name);
                }else{
                    $this->ci->session->set_flashdata('error', $this->ci->upload->display_errors());
                    redirect("user-management-tambah");
                }
            }
        }
        return $image_name;
    }
}
