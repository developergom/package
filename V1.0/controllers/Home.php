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
    }
    
    public function index() {
        $this->view = FALSE;
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */