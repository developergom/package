<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Item_type_model
 *
 * @author nanank
 */
class Item_type_model extends GN_Controller {
    
    public $_db_group = 'GAFFAIR';
    public $primary_key = 'item_type_id';
    
    public function __construct() {
        parent::__construct();
    }
}
