<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of test
 *
 * @author nanank
 */
class Tester extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Test', 'test');
        $this->form_builder->initialize($this->test->attribute);
    }

    public function index() {
        $this->form_builder->show_index();
    }
    
    public function form() {
        $this->form_builder->show_form();
    }
    
    public function act() {
        $this->form_builder->do_submit();
    }

}
