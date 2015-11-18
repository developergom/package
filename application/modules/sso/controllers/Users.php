<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of users
 *
 * @author nanank
 */
class Users extends CI_Controller {

    protected $page = [];
    protected $segment = 4;
    protected $style = [];
    protected $script = [];
    protected $header = [];
    protected $footer = [];

    public function __construct() {
        parent::__construct();
        if (empty($this->cfg->sess))
            redirect('in/');

        $this->page = $this->mn->gtbylnk($this->uri->segment(1) . '/' . $this->uri->segment(2));
        $this->header = [
            'app_name' => $this->cfg->app_name,
            'title' => $this->page['mnme'],
            'content_header' => anchor($this->page['mlnk'], '<i class="fa ' . $this->page['mico'] . '"></i> ' . $this->page['mnme']),
            'style' => $this->style
        ];
        $this->footer = ['script' => $this->script];
    }

    public function index() {
        $page = ($this->uri->segment($this->segment)) ? $this->uri->segment($this->segment) : 0;
        $config['base_url'] = base_url('sso/users/');
        $config['per_page'] = $this->cfg->perpage;
        $config['uri_segment'] = $this->segment;
        $config['total_rows'] = $this->usr->cusr();
        //$key = $this->input->get();
        $udata = $this->usr->fusr($config['per_page'], $page);
        $this->pagination->initialize($config);
        $this->header['breadcrumb'] = [anchor('/', '<i class="fa fa-home"></i> Home'), $this->page['mnme']];
        $this->load->view('header', $this->header);
        $this->load->view('sso/user', ['data' => $udata, 'row' => $this->usr->cusr(), 'links' => $this->pagination->create_links()]);
        $this->load->view('footer', $this->footer);
    }

    public function form() {
        $id = $this->uri->segment($this->segment);
        $udata = [];
        if (!empty($id)) {
            $this->usr->init($id);
            $udata = $this->usr->tdata;
        }

        $rldata = $this->rl->opt();
        $urldata = $this->url->init($id);
        $br3 = (empty($udata)) ? 'Insert' : 'Edit';
        $this->header['breadcrumb'] = [anchor('/', '<i class="fa fa-home"></i> Home'), anchor($this->page['mlnk'], $this->page['mnme']), $br3];
        $this->load->view('header', $this->header);
        $this->load->view('sso/user_form', ['data' => $udata, 'rldata' => $rldata, 'urldata' => $urldata]);
        $this->load->view('footer', $this->footer);
    }

    public function act() {
        $uid = $this->input->post('uid');
        $upass = $this->input->post('upass');
        $unme = $this->input->post('unme');
        $uninme = $this->input->post('uninme');
        $ufnme = $this->input->post('ufnme');
        $umail = $this->input->post('umail');
        $ustat = $this->input->post('ustat');
        $rl = (isset($_POST['rl'])) ? $_POST['rl'] : NULL;
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
        $id = $this->uri->segment($this->segment);
        if (empty($id))
            return;

        $this->usr->init($id);
        $this->usr->dusr();
        redirect('sso/users/', 'refresh');
    }

}

/* End of file user.php */
/* Location: ./application/controllers/users.php */