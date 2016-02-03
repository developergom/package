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
    
    public function __construct() {
        parent::__construct();
    }
}
