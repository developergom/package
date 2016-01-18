<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of users
 *
 * @author nanank
 */
class Users extends CI_Controller {

    private $_attr = [];

    public function __construct() {
        parent::__construct();
        $this->cfg->check_session();
        $this->load->library('encrypt');
    }

    public function index() {
        $config['base_url'] = base_url('sso/users/');
        $config['per_page'] = $this->cfg->perpage;
        $config['uri_segment'] = $this->cfg->segment;
        $config['total_rows'] = $this->usr->cusr($this->input->get());
        $this->pagination->initialize($config);
        $this->_attr['breadcrumb'] = [anchor('/', '<i class="fa fa-home"></i> Home'), $this->cfg->page['mnme']];
        $this->_attr['data'] = $this->usr->fusr($this->cfg->perpage, $this->input->get());
        $this->_attr['row'] = $this->usr->cusr($this->input->get());
        $this->_attr['pagination'] = $this->pagination->create_links();
        $this->template->load($this->cfg->template . '/default', 'sso/user', $this->_attr);
    }

    public function form() {
        $id = $this->uri->segment($this->cfg->segment);
        $udata = [];
        if (!empty($id)) {
            $this->usr->init($id);
            $udata = $this->usr->tdata;
        }

        $rldata = $this->rl->opt();
        $urldata = $this->url->init($id);
        $br3 = (empty($udata)) ? 'Create New' : 'Edit Data';
        $this->_attr['breadcrumb'] = [anchor('/', '<i class="fa fa-home"></i> Home'), anchor($this->cfg->page['mlnk'], $this->cfg->page['mnme']), $br3];
        $this->_attr['data'] = $udata;
        $this->_attr['rldata'] = $rldata;
        $this->_attr['urldata'] = $urldata;
        $this->template->load($this->cfg->template . '/default', 'sso/user_form', $this->_attr);
    }

    public function act() {
        $uid = $this->input->post('uid');
        $upass = $this->input->post('upass');
        $unme = $this->input->post('unme');
        $uninme = $this->input->post('uninme');
        $ufnme = $this->input->post('ufnme');
        $umail = $this->input->post('umail');
        $ustat = $this->input->post('ustat');
        $rl = $this->input->post('rl');
        $this->form_validation->set_rules('unme', 'username', 'required');
        $this->form_validation->set_rules('uninme', 'nickname', 'required');
        $this->form_validation->set_rules('ufnme', 'name', 'required');
        $this->form_validation->set_rules('umail', 'email', 'required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $this->form(); //redirect('sso/users/form/');
        } else {
            $stat = ($ustat) ? TRUE : FALSE;
            $this->usr->init($uid);
            $pass = $this->encrypt->encode($upass);
            $this->usr->tdata = ['unme' => $unme, 'uninme' => $uninme, 'ufnme' => $ufnme, 'umail' => $umail, 'upp' => 'avatar.png', 'ubirth' => '1990-01-01', 'ustat' => $stat];
            if (!empty($upass))
                $this->usr->tdata['upass'] = $pass;

            if (empty($this->usr->uid)) {
                $insert = $this->usr->iusr();
            } else {
                $this->usr->eusr();
            }

            $this->url->init($this->usr->uid);
            if (!empty($this->url->uid))
                $this->url->durl();

            foreach ($rl as $v) {
                $this->url->tdata['uid'] = (empty($this->usr->uid)) ? $insert : $this->usr->uid;
                $this->url->tdata['rid'] = $v;
                $this->url->iurl();
            }
            $this->usr->eusr();
            redirect('sso/users/', 'refresh');
        }
    }

    public function erase() {
        $id = $this->uri->segment($this->cfg->segment);
        if (empty($id))
            return;

        $this->usr->init($id);
        $this->usr->dusr();
        redirect('sso/users/', 'refresh');
    }

}

/* End of file user.php */
/* Location: ./application/controllers/users.php */