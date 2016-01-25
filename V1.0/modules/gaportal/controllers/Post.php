<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Post
 *
 * @author nanank
 */
class Post extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('string');
    }

    public function index() {
        $this->load->view('header');
        $this->load->view('post');
        $this->load->view('footer');
    }

}
