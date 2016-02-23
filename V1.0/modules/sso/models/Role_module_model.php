<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Role_module_model
 *
 * @author soniibrol
 */
class Role_module_model extends GN_Model {
    
    public $_db_group = 'SSO';
    public $_table = 'role_module';
    //public $before_create = ['create_log'];
    //public $before_update = ['update_log'];
    public $validate = [
    	[
            'field' => 'role_id',
            'label' => 'Role',
            'rules' => 'required'
        ],
        [
            'field' => 'module_id',
            'label' => 'Module',
            'rules' => 'required'
        ]
    ];
    
    public function __construct() {
        parent::__construct();
    }
}
