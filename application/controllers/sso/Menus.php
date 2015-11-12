<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of menus
 *
 * @author nanank
 */
class Menus extends CI_Controller {

    public $sess = null;
    protected $app_name = null;
    protected $page = array();
    protected $perpage = null;
    protected $style = array();
    protected $script = array('list-icon-modal');
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
        $udata = data_recursive($this->mn->fmn(), 'mid', 'mpar');
        $recursive = datagrid_recursive($udata, 'mnme');
        $this->header['breadcrumb'] = array(anchor('/', '<i class="fa fa-home"></i> Home'), $this->page['mnme']);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $config['base_url'] = base_url('sso/menus/index/');
        $config['per_page'] = $this->perpage;
        $config['uri_segment'] = 4;
        $config['total_rows'] = count($recursive);
        $this->pagination->initialize($config);
        $data = array_slice($recursive, $page, $config['per_page']);
        $this->load->view('header', $this->header);
        $this->load->view('sso/menu', array('data' => $data, 'row' => count($recursive), 'links' => $this->pagination->create_links()));
        $this->load->view('footer', $this->footer);
    }

    public function search() {
        $key = $this->input->post('key');
        $data = $this->mn->smn($key);
        $this->header['breadcrumb'] = array(anchor('/', '<i class="fa fa-home"></i> Home'), anchor($this->page['mlnk'], $this->page['mnme']), 'Search');
        $this->load->view('header', $this->header);
        $this->load->view('sso/menu', array('data' => $data, 'row' => count($data)));
        $this->load->view('footer', $this->footer);
    }

    public function form() {
        $id = $this->uri->segment(4);
        $udata = array();
        if (!empty($id)) {
            $this->mn->init($id);
            $udata = $this->mn->tdata;
        }

        $opt = $this->mn->fmn();
        $br3 = (empty($udata)) ? 'Insert' : 'Edit';
        $this->header['breadcrumb'] = array(anchor('/', '<i class="fa fa-home"></i> Home'), anchor($this->page['mlnk'], $this->page['mnme']), $br3);
        $this->load->view('header', $this->header);
        $this->load->view('sso/menu_form', array('data' => $udata, 'opt' => $opt));
        $this->load->view('sso/modal-list-icon');
        $this->load->view('footer', $this->footer);
    }

    public function act() {
        $mid = $this->input->post('mid');
        $mnme = $this->input->post('mnme');
        $mpar = $this->input->post('mpar');
        $mlnk = $this->input->post('mlnk');
        $mico = $this->input->post('mico');
        $mstat = $this->input->post('mstat');
        
        $this->form_validation->set_rules('mnme', 'menu name', 'required');
        if($this->input->post('quick') != TRUE) {
            $this->form_validation->set_rules('mpar', 'menu parent', 'is_natural');
            $this->form_validation->set_rules('mlnk', 'menu link', 'required');
            $this->form_validation->set_rules('mico', 'menu icon', 'required');
        }
        
        if ($this->form_validation->run() == FALSE) {
            redirect('sso/menus/form/');
        } else {
            $stat = ($mstat) ? TRUE : FALSE;
            $this->mn->init($mid);
            $this->mn->tdata = array(
                'mnme' => $mnme, 
                'mpar' => (!empty($mpar)) ? $mpar : $this->mn->mpar, 
                'mlnk' => (!empty($mlnk)) ? $mlnk : $this->mn->mlnk, 
                'mico' => (!empty($mico)) ? $mico : $this->mn->mico, 
                'mstat' => (!empty($mstat)) ? $stat : $this->mn->mstat
            );
            (empty($this->mn->mid)) ? $this->mn->imn() : $this->mn->emn();
            redirect('sso/menus/', 'refresh');
        }
    }

    public function erase() {
        $id = $this->uri->segment(4);
        if (empty($id))
            return;

        $this->mn->init($id);
        (!empty($this->mn->mpar)) ? $this->mn->drmn($this->mn->mid) : $this->mn->dmn();
        redirect('sso/menus/', 'refresh');
    }

}

/* End of file menu.php */
/* Location: ./application/controllers/menus.php */