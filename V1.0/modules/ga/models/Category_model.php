<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Category_model
 *
 * @author nanank
 */
class Category_model extends GN_Model {
    
    public $_db_group = 'GAPORTAL';
    public $primary_key = 'category_id';
    
    public function __construct() {
        parent::__construct();
    }
}
