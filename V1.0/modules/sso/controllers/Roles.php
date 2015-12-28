<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of roles
 *
 * @author nanank
 */
class Roles extends CI_Controller {

    private $_attr = [];
    private $_id = NULL;

    public function __construct() {
        parent::__construct();
        $this->cfg->check_session();
        $this->_id = $this->uri->segment($this->cfg->segment);
    }

    public function index() {
        $config['base_url'] = base_url('sso/roles/');
        $config['per_page'] = $this->cfg->perpage;
        $config['uri_segment'] = $this->cfg->segment;
        $config['total_rows'] = $this->rl->crl($this->input->get());
        $this->pagination->initialize($config);
        $this->_attr['breadcrumb'] = [anchor('/', '<i class="fa fa-home"></i> Home'), $this->cfg->page['mnme']];
        $this->_attr['data'] = $this->rl->frl($this->cfg->perpage, $this->input->get());
        $this->_attr['row'] = $this->rl->crl($this->input->get());
        $this->_attr['pagination'] = $this->pagination->create_links();
        $this->template->load($this->cfg->template . '/default', 'sso/role', $this->_attr);
    }

    public function form() {
        $this->cfg->script = ['rolemenu-checkbox'];
        $this->_attr['data'] = [];
        if (!empty($this->_id)) {
            $this->rl->init($this->_id);
            $this->_attr['data'] = $this->rl->tdata;
        }
        $br3 = (empty($this->_attr['data'])) ? 'Create New' : 'Edit Data';
        $this->_attr['breadcrumb'] = [anchor('/', '<i class="fa fa-home"></i> Home'), anchor($this->cfg->page['mlnk'], $this->cfg->page['mnme']), $br3];
        $this->_attr['mdata'] = $this->mn->fmn();
        $this->_attr['rmdata'] = $this->rm->init($this->_id);
        $this->_attr['acc_key'] = json_decode($this->cfg->access_key);
        $this->template->load($this->cfg->template . '/default', 'sso/role_form', $this->_attr);
    }

    public function act() {
        $rid = $this->input->post('rid');
        $rnme = $this->input->post('rnme');
        $rdesc = $this->input->post('rdesc');
        $rstat = $this->input->post('rstat');
        $rm_acc = $this->input->post('acc');
        $this->form_validation->set_rules('rnme', 'role name', 'required');
        if ($this->form_validation->run() == FALSE) {
            redirect('sso/roles/form/');
        } else {
            $stat = ($rstat) ? TRUE : FALSE;
            $this->rl->init($rid);
            $this->rl->tdata = ['rnme' => $rnme, 'rdesc' => $rdesc, 'rstat' => (isset($rstat)) ? $stat : $this->rl->rstat];
            if (empty($this->rl->rid)) {
                $this->rl->irl();
            } else {
                if(!empty($rm_acc)) {
                    $this->rm->init($this->rl->rid);
                    if (!empty($this->rm->rid))
                        $this->rm->drm();

                    foreach ($rm_acc as $k => $v) {
                        $v[] = 'r';
                        $this->rm->tdata['rid'] = $rid;
                        $this->rm->tdata['mid'] = $k;
                        $this->rm->tdata['rmk'] = json_encode_db($v);
                        $this->rm->irm();
                    }
                }
                $this->rl->erl();
            }
            redirect('sso/roles/', 'refresh');
        }
    }

    public function erase() {
        if (empty($this->_id))
            return;

        $this->rl->init($this->_id);
        $this->rl->drl();
        redirect('sso/roles/', 'refresh');
    }

}

/* End of file roles.php */
/* Location: ./application/controllers/roles.php */