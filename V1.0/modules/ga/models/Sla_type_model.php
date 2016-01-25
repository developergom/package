<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Sla_type_model
 *
 * @author nanank
 */
class Sla_type_model extends GN_Model {
    
    public $_db_group = 'GAFFAIR';
    public $primary_key = 'sla_type_id';
    
    public function __construct() {
        parent::__construct();
    }
    
}
