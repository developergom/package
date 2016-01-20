<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Sign
 *
 * @author nanank
 */
class Sign extends GN_Controller {

    protected $models = ['Sign'];
    protected $helpers = [];

    public function __construct() {
        parent::__construct();
        $this->load->driver('Service_login_auth');
        $this->view = FALSE;
    }

    public function index() {
        $this->load->view('sign');
    }

    public function in() {
        $key = $this->security->sanitize_filename($this->input->post('email'));
        $pass = $this->input->post('pass');
        $in = $this->Sign->in($key, $pass);
        if ($in == 'invalid') {
            redirect('sign/index?error=invalid');
        } else if ($in == 'wrong') {
            redirect('sign/index?error=wrong');
        } else if ($in == 'blocked') {
            redirect('sign/index?error=blocked');
        } else if ($in == 'warning') {
            redirect('sign/index?error=warning');
        } else if ($in == 'success') {
            redirect('home/');
        }
    }

    protected function out() {
        debug('out');
    }

}
