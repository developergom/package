<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Module_model
 *
 * @author soniibrol
 */
class Module_model extends GN_Model {
    
    public $_db_group = 'SSO';
    public $primary_key = 'module_id';
    public $protected_attributes = ['module_id'];
    public $before_create = ['create_log'];
    public $before_update = ['update_log'];
    public $validation = [
    		[
                'field' => 'app_id',
                'label' => 'Apps',
                'rules' => 'required'
            ],
            [
                'field' => 'module_name',
                'label' => 'Modules',
                'rules' => 'required'
            ],
            [
                'field' => 'module_desc',
                'label' => 'Description',
                'rules' => 'required'
            ]
    ];
    
    public function __construct() {
        parent::__construct();
    }
}
