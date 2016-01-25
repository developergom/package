<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Sla_type
 *
 * @author nanank
 */
class Sla_type extends GN_Controller {
    
    protected $models = ['sla_type'];
    protected $helpers = [];
    
    public function __construct() {
        parent::__construct();
        $this->view = FALSE;
        $this->data['sla_type'] = $this->sla_type->get_all();
    }
    
    public function index() {
        debug($this->data);
    }
}
