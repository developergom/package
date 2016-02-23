<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Configs_model
 *
 * @author soniibrol
 */
class Configs_model extends GN_Model {
    
    public $_db_group = 'SSO';
    public $primary_key = 'config_id';
    public $protected_attributes = ['config_id'];
    public $before_create = ['create_log'];
    public $before_update = ['update_log'];
    public $validate = [
    	[
            'name' => 'config_key',
            'label' => 'Key',
            'rules' => 'required|max_length[100]|alpha_dash'
        ],
        [
            'name' => 'config_value',
            'label' => 'Value',
            'rules' => 'required|max_length[255]'
        ],
        [
            'name' => 'config_desc',
            'label' => 'Description',
            'rules' => NULL
        ]
    ];
    
    public function __construct() {
        parent::__construct();
    }
}
