<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_event_model extends CI_Model {
    private $_table = 'tabel_detail_event';
    public function addDetailEvent($data){
        $this->db->insert($this->_table,$data);
    }
}