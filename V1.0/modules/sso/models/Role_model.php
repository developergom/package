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
    
    public function __construct() {
        parent::__construct();
    }
}
