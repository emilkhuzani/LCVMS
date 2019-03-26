<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if($this->session->userdata('logged')!=TRUE){
			    redirect(BASE_URL().'index.php/login');
		    }
    }
    public function index(){
		$this->load->view('welcome_message');
	}
}