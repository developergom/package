<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Building_plan_model
 *
 * @author nanank
 */
class Building_plan_model extends GN_Model {
    
    public $_db_group = 'GAFFAIR';
    public $primary_key = 'building_plan_id';
    
    public function __construct() {
        parent::__construct();
    }
    
}
