<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of users
 *
 * @author nanank
 */
class Users extends CI_Controller {

    public $sess = NULL;
    protected $app_name = NULL;
    protected $page = array();
    protected $perpage = NULL;
    protected $style = array();
    protected $script = array();
    protected $header = array();
    protected $footer = array();

    public function __construct() {
        parent::__construct();
        $this->sess = $this->session->userdata('user');
        if (empty($this->sess))
            redirect('in/');

        $this->page = $this->mn->gtbylnk($this->uri->segment(1) . '/' . $this->uri->segment(2));
        $this->app_name = $this->cfg->init('APPLICATION_NAME');
        $this->perpage = (int) $this->cfg->init('ROW_PERPAGE');
        $this->header = array(
            'app_name' => $this->app_name,
            'title' => $this->page['mnme'],
            'content_header' => '<i class="fa ' . $this->page['mico'] . '"></i> ' . $this->page['mnme'],
            'style' => $this->style
        );
        $this->footer = array('script' => $this->script);
    }

    public function index() {
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $config['base_url'] = base_url('sso/users/index/');
        $config['per_page'] = $this->perpage;
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->usr->cusr();
        $udata = $this->usr->fusr($config['per_page'], $page);
        $this->pagination->initialize($config);
        $this->header['breadcrumb'] = array(anchor('/', '<i class="fa fa-home"></i> Home'), $this->page['mnme']);
        $this->load->view('header', $this->header);
        $this->load->view('sso/user', array('data' => $udata, 'row' => $this->usr->cusr(), 'links' => $this->pagination->create_links()));
        $this->load->view('footer', $this->footer);
    }

    public function search() {
        $key = $this->input->post('key');
        $data = $this->usr->susr($key);
        $this->header['breadcrumb'] = array(anchor('/', '<i class="fa fa-home"></i> Home'), anchor($this->page['mlnk'], $this->page['mnme']), 'Search');
        $this->load->view('header', $this->header);
        $this->load->view('sso/user', array('data' => $data, 'row' => count($data)));
        $this->load->view('footer', $this->footer);
    }

    public function form() {
        $id = $this->uri->segment(4);
        $udata = array();
        if (!empty($id)) {
            $this->usr->init($id);
            $udata = $this->usr->tdata;
        }

        $rldata = $this->rl->opt();
        $urldata = $this->url->init($id);
        $br3 = (empty($udata)) ? 'Insert' : 'Edit';
        $this->header['breadcrumb'] = array(anchor('/', '<i class="fa fa-home"></i> Home'), anchor($this->page['mlnk'], $this->page['mnme']), $br3);
        $this->load->view('header', $this->header);
        $this->load->view('sso/user_form', array('data' => $udata, 'rldata' => $rldata, 'urldata' => $urldata));
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
            $this->usr->tdata = array('unme' => $unme, 'uninme' => $uninme, 'ufnme' => $ufnme, 'umail' => $umail, 'upp' => 'avatar.png', 'ubirth' => '1990-01-01', 'ustat' => $stat);
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
        $id = $this->uri->segment(4);
        if (empty($id))
            return;

        $this->usr->init($id);
        $this->usr->dusr();
        redirect('sso/users/', 'refresh');
    }

}

/* End of file user.php */
/* Location: ./application/controllers/users.php */