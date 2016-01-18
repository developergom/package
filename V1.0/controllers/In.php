<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of in
 *
 * @author nanank
 */
class In extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Sso_ORI/Usr', 'usr');
    }

    public function index() {
        $this->load->view('in');
    }

    public function come() {
        $key = $this->security->sanitize_filename($this->input->post('key'));
        $pass = $this->input->post('pass');
        $in = $this->usr->in($key, $pass);
        if ($in == 'invalid') {
            redirect('in/index?error=invalid');
        } else if ($in == 'wrong') {
            redirect('in/index?error=wrong');
        } else if ($in == 'blocked') {
            redirect('in/index?error=blocked');
        } else if ($in == 'warning') {
            redirect('in/index?error=warning');
        } else if ($in == 'success') {
            redirect('home/');
        }
    }

    public function out() {
        $this->session->unset_userdata();
        $this->session->sess_destroy();
        redirect('in/');
    }

}

/* End of file in.php */
/* Location: ./application/controllers/in.php */