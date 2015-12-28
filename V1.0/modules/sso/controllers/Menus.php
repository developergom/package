<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of menus
 *
 * @author nanank
 */
class Menus extends CI_Controller {

    private $_id = NULL;
    private $_attr = [];

    public function __construct() {
        parent::__construct();
        $this->cfg->check_session();
        $this->_id = $this->uri->segment($this->cfg->segment);
    }

    public function index() {
        if (!empty($this->input->get('search'))) {
            $this->_attr['data'] = $this->mn->fmn($this->input->get('search'));
            $this->_attr['row'] = count($this->_attr['data']);
        } else {
            $udata = data_recursive($this->mn->fmn(), 'mid', 'mpar');
            $recursive = datagrid_recursive($udata, 'mnme');
            $page = (!empty($this->input->get('page'))) ? $this->cfg->perpage * ($this->input->get('page') - 1) : 0;
            $config['base_url'] = base_url('sso/menus/');
            $config['per_page'] = $this->cfg->perpage;
            $config['uri_segment'] = $this->cfg->segment;
            $config['total_rows'] = count($recursive);
            $this->pagination->initialize($config);
            $this->_attr['data'] = array_slice($recursive, $page, $config['per_page']);
            $this->_attr['row'] = count($recursive);
        }

        $this->_attr['breadcrumb'] = [anchor('/', '<i class="fa fa-home"></i> Home'), $this->cfg->page['mnme']];
        $this->_attr['pagination'] = $this->pagination->create_links();
        $this->template->load($this->cfg->template . '/default', 'sso/menu', $this->_attr);
    }

    public function form() {
        $this->cfg->script = ['list-icon-modal'];
        $this->_attr['data'] = [];
        if (!empty($this->_id)) {
            $this->mn->init($this->_id);
            $this->_attr['data'] = $this->mn->tdata;
        }

        $br3 = (empty($this->_attr['data'])) ? 'Insert' : 'Edit';
        $this->_attr['breadcrumb'] = [anchor('/', '<i class="fa fa-home"></i> Home'), anchor($this->cfg->page['mlnk'], $this->cfg->page['mnme']), $br3];
        $this->_attr['opt'] = data_recursive($this->mn->fmn(), 'mid', 'mpar');
        $this->template->load($this->cfg->template . '/default', 'sso/menu_form', $this->_attr);
        $this->load->view('sso/modal-list-icon');
    }

    public function act() {
        $this->form_validation->set_rules('mnme', 'menu name', 'required');
        if ($this->input->post('quick') != TRUE) {
            $this->form_validation->set_rules('mpar', 'menu parent', 'is_natural');
            $this->form_validation->set_rules('mlnk', 'menu link', 'required');
            $this->form_validation->set_rules('mordr', 'menu order', 'required|numeric|min_length[1]|max_length[2]');
            $this->form_validation->set_rules('mico', 'menu icon', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            redirect('sso/menus/form/');
        } else {
            $stat = ($this->input->post('mstat')) ? TRUE : FALSE;
            $this->mn->init($this->input->post('mid'));
            $this->mn->tdata = [
                'mnme' => $this->input->post('mnme'),
                'mpar' => (!empty($this->input->post('mpar'))) ? $this->input->post('mpar') : $this->mn->mpar,
                'mlnk' => (!empty($this->input->post('mlnk'))) ? $this->input->post('mlnk') : $this->mn->mlnk,
                'mico' => (!empty($this->input->post('mico'))) ? $this->input->post('mico') : $this->mn->mico,
                'mstat' => (!empty($this->input->post('mstat'))) ? $stat : $this->mn->mstat
            ];
            (empty($this->mn->mid)) ? $this->mn->imn() : $this->mn->emn();
            redirect('sso/menus/', 'refresh');
        }
    }

    public function erase() {
        if (empty($this->_id))
            return;

        $this->mn->init($this->_id);
        (!empty($this->mn->mpar)) ? $this->mn->drmn($this->mn->mid) : $this->mn->dmn();
        redirect('sso/menus/', 'refresh');
    }

}

/* End of file menu.php */
/* Location: ./application/controllers/menus.php */