<?php

class Media_model extends CI_Model{
	public function get(){
		$CI =& get_instance();

		$this->db_asm = $CI->load->database('db_asm', TRUE);
		$this->db_asm->select("*");
		$this->db_asm->from("TBMedia");
		return $this->db_asm->get()->result_array();
	}
}