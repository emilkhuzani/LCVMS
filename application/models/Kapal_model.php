<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kapal_model extends CI_Model {
    private $_table = "tabel_kapal";

    public function getAll(){
        return $this->db->get($this->_table)->result();
    }
}