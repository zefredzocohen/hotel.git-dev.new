<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends MY_Model
{
    var $table = 'email';
    var $key = 'email_id';

    function getList($input = array()){
//		$this->db->select($this->table.'.*,role_name');
		$this->get_list_set_input($input);
		$this->db->from($this->table);
//		$this->db->join('role',$this->table.'.role_id = role.role_id');
		$query = $this->db->get();
		return $query->result();
    }
}