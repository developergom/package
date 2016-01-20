<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Category
 *
 * @author nanank
 */
class Category extends GN_Controller {

    protected $models = ['category'];
    protected $helpers = ['extension', 'string'];
    

    public function __construct() {
        parent::__construct();
        $this->view = FALSE;
        $this->data['category'] = $this->category->get_all();
    }
    
    public function index() {
        $this->load->view('header');
        $this->load->view('portal/category', $this->data);
        $this->load->view('footer');
    }

}
