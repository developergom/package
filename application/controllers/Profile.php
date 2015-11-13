<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of profile
 *
 * @author nanank
 */

class Profile extends CI_Controller {
    
    public $sess = null;
    protected $app_name = null;
    protected $style = array();
    protected $script = array();
    protected $header = array();
    protected $footer = array();

    public function __construct() {
        parent::__construct();
        $this->sess = $this->session->userdata('user');
        if (empty($this->sess))
            redirect('in/');

        $this->app_name = $this->cfg->init('APPLICATION_NAME');
        $this->header = array(
            'app_name' => $this->app_name,
            'title' => 'User Profile',
            'content_header' => '<i class="fa fa-user"></i> Profile',
            'style' => $this->style
        );
        $this->footer = array('script' => $this->script);
    }
    
    public function index($id = null) {
        $id = (empty($id)) ? $this->uri->segment(1) : $id;
        $this->usr->init($id);
        $this->header['breadcrumb'] = array(anchor('/', '<i class="fa fa-home"></i> Home'), 'Profile');
        $this->load->view('header', $this->header);
        $this->load->view('profile', $this->usr);
        $this->load->view('footer', $this->footer);
    }
    
    public function change() {
        $uid = $this->input->post('uid');
        $npass = $this->input->post('npass');

        $this->usr->init($uid);
        $this->form_validation->set_rules('uid', '', 'required');
        $this->form_validation->set_rules('npass', 'new password', 'required|min_length[8]');
        $this->form_validation->set_rules('rpass', 'retype password', 'required|matches[npass]');
        if ($this->form_validation->run() == false) {
            $this->index($uid);
        } else {
            $this->usr->tdata = array('upass' => $this->encrypt->encode($npass));
            $this->usr->eusr();
            redirect('/', 'refresh');
        }
    }

    public function change_birth() {
        $uid = $this->input->post('uid');
        $ubirth = mdate('%Y-%m-%d',strtotime($this->input->post('ubirth')));

        $this->usr->init($uid);
        $this->form_validation->set_rules('uid', '', 'required');
        $this->form_validation->set_rules('ubirth', 'Birthdate', 'required|max_length[10]');
        if ($this->form_validation->run() == false) {
            $this->index($uid);
        } else {
            $this->usr->tdata = array('ubirth' => $ubirth);
            $this->usr->eusr();
            redirect('/', 'refresh');
        }
    }

    public function change_ava() {
        $uid = $this->input->post('uid');

        $this->usr->init($uid);
        $this->form_validation->set_rules('uid', '', 'required');
        //$this->form_validation->set_rules('upp', 'Avatar', 'required');
        if ($this->form_validation->run() == false) {
            $this->index($uid);
        } else {
            $config['upload_path']          = './asset/img/avatar/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 100;
            $config['max_width']            = 1024;
            $config['max_height']           = 1024;
            $config['file_name']            = $uid.'-ava';

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('upp'))
            {
                    $data = array('error' => $this->upload->display_errors());

                    $this->index($uid);
            }
            else
            {
                    $data = array('upload_data' => $this->upload->data());

                    $this->usr->tdata = array('upp' => $data['upload_data']['file_name']);
                    $this->usr->eusr();

                    $this->session->set_userdata('uava', $data['upload_data']['file_name']);

                    redirect('/', 'refresh');
            }
        }
    }
}
/* End of file profile.php */
/* Location: ./application/controllers/profile.php */