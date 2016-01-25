<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Vehicle_model
 *
 * @author nanank
 */
class Vehicle_model extends GN_Model {
    
    public $_db_group = 'GAFFAIR';
    public $primary_key = 'vehicle_id';
    
    public function __construct() {
        parent::__construct();
    }
}
