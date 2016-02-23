<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of home
 *
 * @author nanank
 */
class Home extends GN_Controller {
	protected $models = ['home'];
    protected $helpers = [];

    public function __construct() {
        parent::__construct();
        $this->data['form'] = [];
        
        $this->data['style'] = [];
        $this->data['script'] = [];
    }
    
    public function index() {
        //$this->load->view('home');
        $this->data['datagrid_header'] = [];
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */