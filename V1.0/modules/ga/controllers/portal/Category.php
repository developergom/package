<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Category
 *
 * @author nanank
 */
class Category extends GN_Controller {

    protected $models = ['category'];
    protected $helpers = [];
    

    public function __construct() {
        parent::__construct();
        $this->view = FALSE;
        $this->data['category'] = $this->category->get_all();
    }
    
    public function index() {
        debug($this->data);
    }

}
