<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Item_type
 *
 * @author nanank
 */
class Item_type extends GN_Controller {
    
    protected $models = ['item_type'];
    protected $helpers = [];
    
    public function __construct() {
        parent::__construct();
        $this->view = FALSE;
        $this->data['item_type'] = $this->item_type->get_all();
    }
    
    public function index() {
        debug($this->data);
    }
}
