<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Item_model
 *
 * @author nanank
 */
class Item_model extends GN_Model {
    
    public $_db_group = 'GAFFAIR';
    public $primary_key = 'item_id';
    public $protected_attributes = ['item_id'];
    public $before_create = ['create_log'];
    public $before_update = ['update_log'];
    
    public function __construct() {
        parent::__construct();
    }
}
