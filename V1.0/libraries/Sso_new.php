<?php

defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 *
 * Description of SSO
 * 
 * @author soniibrol
 *
 */

 class Sso_new {

 	var $ci;
 	var $id;
 	private $data = [];
 	public $menu = [];
 	public $access = [];

 	public function __construct() {
 		$this->ci =& get_instance();
 		$this->ci->load->helper('recursive');

 		$this->id = 1;
 		$this->data = $this->get_data();
 		$this->menu = $this->set_menu();
 		$this->access = $this->set_access();
 		if(!isset($this->id))
 			return;
 	}

 	private function get_data() {
 		$this->ci->db->join('modules md', 'md.module_id = m.module_id');
 		$this->ci->db->join('role_access r', 'r.menu_id = m.menu_id');
        $this->ci->db->join('user_role u', 'u.role_id = r.role_id');
        $query = $this->ci->db->get_where('menus m', ['u.user_id' => $this->id, 'm.menu_status' => 'ACTIVE', 'md.module_status' => 'ACTIVE']);
        $result = $query->result_array();
        if(!empty($result)){
        	$data = [];
        	$tmp = [];
			foreach($result as $val){
				$menu_parent = ($val['menu_parent'] == 1) ? 0 : $val['menu_parent'];
				$tmp[$val['menu_id']][] = unserialize($val['access_key']);
				$data[$val['menu_id']] = [
					'menu_id' => $val['menu_id'],
					'menu_parent' => $menu_parent,
					'module_id' => $val['module_id'],
					'module_name' => $val['module_name'],
					'menu_name' => $val['menu_name'],
					'menu_icon' => $val['menu_icon'],
					'menu_link' => $val['menu_link']
				];
			}

			$array_key = [];
			foreach($tmp as $k => $v){
				$array_key[$k] = [];
				foreach($v as $vv){
					if(is_array($vv) == FALSE)
						continue;

					$array_key[$k] = array_merge($array_key[$k], $vv);
				}
				$array_key[$k] = array_unique($array_key[$k]);
				sort($array_key[$k]);
			}        	

			foreach($data as $kk => $vvv)
				$data[$kk]['key'] = $array_key[$kk];
        }

        return (isset($data)) ? $data : [];
 	}

 	private function set_menu() {
        $tmp = [];
        foreach ($this->data as $v)
            $tmp[] = $v;

        $menu = data_recursive($tmp, 'menu_id', 'menu_parent');
        echo '<pre>';
        print_r($menu);die;
        return $this->menu_tree($menu);
    }
 }