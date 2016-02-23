<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Menu_model
 *
 * @author soniibrol
 */
class Menu_model extends GN_Model {
    
    public $_db_group = 'SSO';
    public $_table = 'menus';
    public $primary_key = 'menu_id';
    public $protected_attributes = ['menu_id'];
    public $before_create = ['create_log'];
    public $before_update = ['update_log'];
    public $belongs_to = ['modules' =>
        [
            'model' => 'module_model',
            'primary_key' => 'module_id'
        ]
    ];
    public $validate = [
    	[
            'field' => 'module_id',
            'label' => 'Module',
            'rules' => 'required'
        ],
        [
            'field' => 'menu_name',
            'label' => 'Menu Name',
            'rules' => 'required|max_length[50]'
        ],
        [
            'field' => 'menu_desc',
            'label' => 'Description',
            'rules' => 'required'
        ],
        [
            'field' => 'menu_icon',
            'label' => 'Icon',
            'rules' => 'max_length[255]'
        ],
        [
            'field' => 'menu_order',
            'label' => 'Order',
            'rules' => 'required|numeric'
        ]
	];
    
    public function __construct() {
        parent::__construct();
    }
}
