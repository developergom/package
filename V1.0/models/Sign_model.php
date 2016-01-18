<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of In_model
 *
 * @author nanank
 */
class Sign_model extends GN_Model {
    
    public $_table = 'users';
    public $primary_key = 'user_id';


    public function __construct() {
        parent::__construct();
    }
    
    
    
}
