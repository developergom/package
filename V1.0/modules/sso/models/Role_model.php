<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Role_model
 *
 * @author soniibrol
 */
class Role_model extends GN_Model {
    
    public $_db_group = 'SSO';
    public $primary_key = 'role_id';
    public $protected_attributes = ['role_id'];
    public $before_create = ['create_log'];
    public $before_update = ['update_log'];
    public $before_delete = ['delete_role_module'];
    public $validate = [
    	[
            'field' => 'role_name',
            'label' => 'Role Name',
            'rules' => 'required|max_length[100]'
        ]
    ];
    
    public function __construct() {
        parent::__construct();
    }

    public function delete_role_module() {
        $this->role_module->delete_by($this->primary_key,$this->uri->segment(4));
    }
}
