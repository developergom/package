<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Role_model
 *
 * @author soniibrol
 */
class User_role_model extends GN_Model {
    public $_table = 'user_role';
    public $_db_group = 'SSO';
    /*public $before_create = ['create_log'];
    public $before_update = ['update_log'];*/
    /*public $validate = [
    	[
            'field' => 'user_id',
            'label' => 'User ID',
            'rules' => 'required'
        ],
        [
            'field' => 'role_id',
            'label' => 'Role ID',
            'rules' => 'required'
        ]
    ];*/
    
    public function __construct() {
        parent::__construct();
    }
}
