<?php

class Configs_lib {
	var $ci;
	public function __construct() {
		$this->ci =& get_instance();
		$data = $this->ci->db->get('configs')->result_array();
		foreach($data as $key => $value) {
			defined($value['config_key']) OR define($value['config_key'], $value['config_value']);
		}
	}
}