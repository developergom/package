<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Extention_model
 *
 * @author nanank
 */
class Extention_model extends GN_Model {
    
    public $_db_group = 'GAFFAIR';
    public $primary_key = 'extention_id';
    public $protected_attributes = ['extention_id'];
    public $before_create = ['create_log'];
    public $before_update = ['update_log'];
    
    public function __construct() {
        parent::__construct();
    }
}
