<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Table_fitersession {

    function __construct() {
        //parent::__construct();
        $this->ci = & get_instance();
        $this->ci->load->library('session');
        $this->ci->load->helper('utility');
    }

    function renders($data) {
        if ($_POST) {
            return $this->fetch_session_post($data);
        } else {
            return $this->fetch_session($data);
        }
    }

    function fetch_session_post($data = array()) {
        $val = array();
        foreach ($data as $key => $field) {
            $val[$field] = $this->set_session_table_search($field, $this->ci->input->get_post($field, TRUE));
        }
        return $val;
    }

    function fetch_session(array $data = array()) {
        $val = array();
        foreach ($data as $key => $field) {
            $val[$field] = $this->ci->session->userdata($field);
        }
        return $val;
    }

    function set_session_table_search($name, $value) {
        if ($value == "" || empty($value)) {
            $this->ci->session->unset_userdata($name);
            $value = $this->ci->session->userdata($name);
            return $value;
        } else {

            if ($value) {
                $this->ci->session->set_userdata($name, $value);
                return $value = $this->ci->session->userdata($name);
            } elseif ($this->ci->session->userdata($name)) {
                $value = $this->ci->session->userdata($name);
                return $value;
            } else {
                $this->ci->session->unset_userdata($name);
                $value = $this->ci->session->userdata($name);
                return $value;
            }
        }
    }

}
