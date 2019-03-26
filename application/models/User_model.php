<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    private $_table = 'tabel_user';
    public $nama;
    public $email;
    public $password;

    public function rules(){
        return [
            ['field'=>'email','label'=>'Email','rules'=>'required'],
            ['field'=>'password','label'=>'Password','rules'=>'required']
        ];
    }
    public function login(){
        $post = $this->input->post();
        $data = array(
            'email' => $post['email'],
            'password' => $post['password']
        );
        return $this->db->get_where($this->_table,$data);
    }

}