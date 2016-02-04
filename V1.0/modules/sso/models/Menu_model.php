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
    
    public function __construct() {
        parent::__construct();
    }
}
