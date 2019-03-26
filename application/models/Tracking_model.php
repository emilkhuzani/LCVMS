<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking_model extends CI_Model {
    private $_table = 'tabel_tracking';
    public function addTracking($data){
        $this->db->insert($this->_table,$data);
    }
    public function cekLastTracking($data){
        return $this->db->get_where($this->_table,$data);
    }
}