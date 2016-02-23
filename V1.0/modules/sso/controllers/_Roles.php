<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Roles
 *
 * @author nanank
 */
class Roles extends GN_Controller {

    public $models = ['Rl', 'Usr'];
    public $helpers = [];

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->data['roles'] = $this->Rl->get_all();
    }
    
    public function show($id) {
        if($this->input->is_ajax_request()) {
            $this->layout = FALSE;
        }
        
        $this->data['user'] = $this->Usr->get($id);
        $this->data['role'] = $this->Rl->get_all();
    }

}
