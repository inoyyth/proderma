<?php

class M_login extends CI_Model {

    private $table = "account";

    function login($username, $password) {
        $key = array('username' => $username, 'status' => '1');
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($key);
        $this->db->limit(1);
        $query = $this->db->get();
        $qry = $query->row_array(); //var_dump($this->encrypt->decode($qry['password']));die;
        if ($query->num_rows() == 1 && $this->encrypt->decode($qry['password']) === $password) {
            $this->__last_login($username, $qry['id']);
            return $this->__select_data($username); //if data is true
        } else {
            return false; //if data is wrong
        }
    }

    public function __last_login($username, $token) {
        //$this->load->library('my_encrypt');
        $data = array('last_login' => date('Y-m-d H:i:s'), 'token' => $token);
        $key = array('username' => $username);
        $this->db->where($key);
        $this->db->update($this->table, $data, $key);
        return true;
    }

    public function __select_data($username) {
        $key = array('username' => $username);
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($key);
        $this->db->limit(1);
        return $this->db->get()->result();
    }

    function login_candolite($token) {
        
        $data = json_decode($this->__decrypt($token,$this->config->item('key_aes')),true);
        //var_dump($data);die;
        $key = array('username' => $data['email'], 'status' => '1');
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($key);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $this->__last_login($data['email'],$token);
            return $this->__select_data($data['email']); //if data is true
        } else {
            return false; //if data is wrong
        }
    }

    function __encrypt($plaintext, $key) {
        $plaintext = pkcs5_pad($plaintext, 16);
        return bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, hex2bin($key), $plaintext, MCRYPT_MODE_ECB));
    }

    function __decrypt($encrypted, $key) {
        $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, hex2bin($key), hex2bin($encrypted), MCRYPT_MODE_ECB);
        $padSize = ord(substr($decrypted, -1));
        return substr($decrypted, 0, $padSize * -1);
    }

    function pkcs5_pad($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

}
