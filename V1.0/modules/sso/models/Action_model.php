<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Action_model
 *
 * @author soniibrol
 */
class Action_model extends GN_Model {
    
    public $_db_group = 'SSO';
    public $primary_key = 'action_id';
    public $protected_attributes = ['action_id'];
    public $before_create = ['create_log'];
    public $before_update = ['update_log'];
    public $validate = [
        [
            'field' => 'action_name',
            'label' => 'Action Name',
            'rules' => 'required|max_length[100]'
        ],
        [
            'field' => 'action_alias',
            'label' => 'Alias',
            'rules' => 'required|max_length[50]|is_unique[actions.action_alias]'
        ],
        [
            'field' => 'action_desc',
            'label' => 'Description',
            'rules' => 'required'
        ]
    ];
    
    public function __construct() {
        parent::__construct();
    }
}
