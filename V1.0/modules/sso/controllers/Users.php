<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Users
 *
 * @author nanank
 */
class Users extends GN_Controller {

    public $models = ['User'];
    public $helpers = [];

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->data['datagrid'] = $this->Usr->get_all();
        //$this->data['dropdown_related'] = $this->Rl->dropdown('rnme');
    }

    public function form() {
        
    }


}
