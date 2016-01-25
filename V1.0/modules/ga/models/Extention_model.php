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
    
    public function __construct() {
        parent::__construct();
    }
}
