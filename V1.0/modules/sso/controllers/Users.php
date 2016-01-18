<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Users
 *
 * @author nanank
 */
class Users extends GN_Controller {

    public $models = ['Usr', 'Rl'];
    public $helpers = [];

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->data['datagrid'] = $this->Usr->get_all();
        $this->data['dropdown_related'] = $this->Rl->dropdown('rnme');
    }

    public function form() {
        
    }

    public function show($id) {
        if ($this->input->is_ajax_request()) {
            $this->layout = FALSE;
        }

        $this->data['user'] = $this->Usr->get($id);
        $this->data['role'] = $this->Rl->get_all();
    }

}
