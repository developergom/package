<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Vehicle_type_model
 *
 * @author nanank
 */
class Vehicle_type_model extends GN_Model {
    
    public $_db_group = 'GAFFAIR';
    public $primary_key = 'vehicle_type_id';
    public $protected_attributes = ['vehicle_type_id'];
    public $before_create = ['create_log'];
    public $before_update = ['update_log'];
    
    public function __construct() {
        parent::__construct();
    }
}
