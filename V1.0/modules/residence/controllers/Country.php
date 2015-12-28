<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Country
 *
 * @author nanank
 */
class Country extends CI_Controller {

    private $_attr = [];

    public function __construct() {
        parent::__construct();
        $this->cfg->check_session();
        $this->load->model('Cntry', 'cntry');
    }

    public function index() {
        $this->cfg->style = ['dataTables.bootstrap'];
        $this->cfg->script = ['jquery.dataTables.min', 'dataTables.bootstrap.min', 'JessicaMila'];
        $this->_attr['breadcrumb'] = [anchor('/', '<i class="fa fa-home"></i> Home'), $this->cfg->page['mnme']];
        $this->template->load('AdminLTE', 'residence/country', $this->_attr);
    }
    
    public function dataTables() {
        $param = (!empty($this->input->post())) ? $this->input->post() : [];
        exit(json_encode($this->cntry->dttable($param)));
    }

}

/* End of file Country.php */
/* Location: ./application/controllers/Country.php */