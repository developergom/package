<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of article
 *
 * @author nanank
 */
class Article extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('string');
    }

    public function index() {
        $this->load->view('header');
        $this->load->view('article');
        $this->load->view('footer');
    }

}
