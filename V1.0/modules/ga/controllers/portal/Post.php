<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Post
 *
 * @author nanank
 */
class Post extends GN_Controller {

    protected $models = ['Post'];
    protected $helpers = ['extension', 'string'];

    public function __construct() {
        parent::__construct();
        $this->view = FALSE;
    }
    
    public function index() {
        $this->load->view('header');
        $this->load->view('footer');
    }

}
