<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of home
 *
 * @author nanank
 */
class Home extends GN_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(['extension', 'string']);
        $this->view = FALSE;
    }
    
    public function index() {
        $this->load->view('header');
        $this->load->view('home');
        $this->load->view('footer');
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */