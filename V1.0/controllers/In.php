<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of In
 *
 * @author nanank
 */
class In extends GN_Controller {
    
    protected $models = ['Sign'];
    protected $helpers = [];

    public function __construct() {
        parent::__construct();
        $this->view = FALSE;
    }
    
    public function index() {
        //$this->load->view('in');
        $data = $this->Sign->get(1);
        debug($data);
    }
    
    
}
