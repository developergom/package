<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of roles
 *
 * @author nanank
 */
class Roles extends CI_Controller {

    public $sess = null;
    protected $app_name = null;
    protected $page = array();
    protected $perpage = null;
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
        $this->script = array('rolemenu-checkbox');
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
        $config['base_url'] = base_url('sso/roles/index/');
        $config['per_page'] = $this->perpage;
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->rl->crl();
        $udata = $this->rl->frl($config['per_page'], $page);
        $this->pagination->initialize($config);
        $this->header['breadcrumb'] = array(anchor('/', '<i class="fa fa-home"></i> Home'), $this->page['mnme']);
        $this->load->view('header', $this->header);
        $this->load->view('sso/role', array('data' => $udata, 'row' => $this->rl->crl(), 'links' => $this->pagination->create_links()));
        $this->load->view('footer', $this->footer);
    }

    public function search() {
        $key = $this->input->post('key');
        $data = $this->rl->srl($key);
        $this->header['breadcrumb'] = array(anchor('/', '<i class="fa fa-home"></i> Home'), anchor($this->page['mlnk'], $this->page['mnme']), 'Search');
        $this->load->view('header', $this->header);
        $this->load->view('sso/role', array('data' => $data, 'row' => count($data)));
        $this->load->view('footer', $this->footer);
    }

    public function form() {
        $id = $this->uri->segment(4);
        $udata = array();
        if (!empty($id)) {
            $this->rl->init($id);
            $udata = $this->rl->tdata;
        }
        $mdata = $this->mn->fmn(true);
        $acc_key = $this->cfg->init('ACCESS_KEY');
        $br3 = (empty($udata)) ? 'Insert' : 'Edit';
        $this->header['breadcrumb'] = array(anchor('/', '<i class="fa fa-home"></i> Home'), anchor($this->page['mlnk'], $this->page['mnme']), $br3);
        $rmdata = $this->rm->init($id);
        $this->load->view('header', $this->header);
        $this->load->view('sso/role_form', array('data' => $udata, 'mdata' => $mdata, 'rmdata' => $rmdata, 'acc_key' => json_decode($acc_key)));
        $this->load->view('footer', $this->footer);
    }

    public function act() {
        $rid = $this->input->post('rid');
        $rnme = $this->input->post('rnme');
        $rstat = $this->input->post('rstat');
        $rm_acc = (isset($_POST['acc'])) ? $_POST['acc'] : array();
        $this->form_validation->set_rules('rnme', 'role name', 'required');
        if ($this->form_validation->run() == false) {
            redirect('sso/roles/form/');
        } else {
            $stat = ($rstat) ? true : false;
            $this->rl->init($rid);
            $this->rl->tdata = array('rnme' => $rnme, 'rstat' => (isset($rstat)) ? $stat : $this->rl->rstat);
            if (empty($this->rl->rid)) {
                $this->rl->irl();
            } else {
                if(!empty($rm_acc)) {
                    $this->rm->init($this->rl->rid);
                    if (!empty($this->rm->rid))
                        $this->rm->drm();

                    foreach ($rm_acc as $k => $v) {
                        $this->rm->tdata['rid'] = $rid;
                        $this->rm->tdata['mid'] = $k;
                        $this->rm->tdata['rmk'] = json_encode($v);
                        $this->rm->irm();
                    }
                }
                $this->rl->erl();
            }
            redirect('sso/roles/', 'refresh');
        }
    }

    public function erase() {
        $id = $this->uri->segment(4);
        if (empty($id))
            return;

        $this->rl->init($id);
        $this->rl->drl();
        redirect('sso/roles/', 'refresh');
    }

}

/* End of file roles.php */
/* Location: ./application/controllers/roles.php */