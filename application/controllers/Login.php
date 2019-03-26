<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model(array('user_model'));
        $this->load->library(array('form_validation'));
    }
    public function index(){
		$this->load->view('login');
    }
    public function auth(){
        $user = $this->user_model;
        $validation = $this->form_validation;
        $validation->set_rules($user->rules());
        if($validation->run()){
            $data=$user->login();
            if($data->num_rows()>0){
                $row=$data->row();
                $mysession = array(
                    'logged' => TRUE,
                    'nama' => $row->nama,
                    'id' => $row->id_user,
                    'email' => $row->email
                );
                $this->session->set_userdata($mysession);
                redirect('dashboard');
            }else{
                echo $this->session->set_flashdata('error','Email atau password anda salah!');
                redirect(BASE_URL());
            }
        }else{
            echo $this->session->set_flashdata('error','Email atau password harus diisi!');
            redirect(BASE_URL());
        }
    }

    public function logout(){
        $this->session->sess_destroy();
		redirect('login');
    }
}
