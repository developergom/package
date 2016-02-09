<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Apps_model
 *
 * @author soniibrol
 */
class Apps_model extends GN_Model {
    
    public $_db_group = 'SSO';
    public $primary_key = 'app_id';
    public $protected_attributes = ['app_id'];
    public $before_create = ['create_log'];
    public $before_update = ['update_log'];
    public $validate = [
    	[
            'field' => 'app_name',
            'label' => 'Apps Name',
            'rules' => 'required|max_length[100]'
        ],
        [
            'field' => 'app_order',
            'label' => 'Order',
            'rules' => 'required|numeric'
        ],
        [
            'field' => 'app_url',
            'label' => 'Apps URL',
            'rules' => 'required|max_length[255]'
        ]
    ];
    
    public function __construct() {
        parent::__construct();
    }
}
