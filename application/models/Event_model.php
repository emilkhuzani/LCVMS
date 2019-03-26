<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_model extends CI_Model {
    private $_table = 'tabel_event';
    public function addEvent($data){
        $this->db->insert($this->_table,$data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function cekLastEvent($data){
        return $this->db->get_where($this->_table,$data);
    }
}