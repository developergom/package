<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Portalga
 *
 * @author nanank
 */
class Portalga extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->load->view('gaportal/header');
        $this->load->view('gaportal/home');
        $this->load->view('gaportal/footer');
    }
    
    public function articles() {
        
    }
    
    public function article($slug) {
        echo $slug;
    }


    public function categories() {
        
    }
    
    public function tags() {
        
    }
}
