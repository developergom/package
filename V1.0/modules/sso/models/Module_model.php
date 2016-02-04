<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Module_model
 *
 * @author soniibrol
 */
class Module_model extends GN_Model {
    
    public $_db_group = 'SSO';
    public $_table = 'modules';
    public $primary_key = 'module_id';
    public $protected_attributes = ['module_id'];
    public $before_create = ['create_log'];
    public $before_update = ['update_log'];
    
    public function __construct() {
        parent::__construct();
    }
}
