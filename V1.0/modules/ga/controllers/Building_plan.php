<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Building_plan
 *
 * @author nanank
 */
class Building_plan extends GN_Controller {
    
    protected $models = ['building_plan'];
    protected $helpers = [];
    
    public function __construct() {
        parent::__construct();
        $this->view = FALSE;
        $this->data['building_plan'] = $this->building_plan->get_all();
    }
    
    public function index() {
        debug($this->data);
    }
}
