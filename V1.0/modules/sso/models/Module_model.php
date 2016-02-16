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
    public $protected_attributes = [];
    public $before_create = ['create_log'];
    public $before_update = ['update_log'];
    public $belongs_to = ['apps' =>
        [
            'model' => 'apps_model',
            'primary_key' => 'app_id'
        ]
    ];
    public $validation = [
            [
                'field' => 'module_id',
                'label' => 'Module ID',
                'rules' => 'required|max_length[255]|is_unique[modules.module_id]'
            ],
    		[
                'field' => 'module_action',
                'label' => 'Action',
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
