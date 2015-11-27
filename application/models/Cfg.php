<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of cfg
 *
 * @author nanank
 */
class Cfg extends CI_Model {

    private $_tbl = 'cfg';
    private $_core = NULL;
    
    public $sess = NULL;
    public $app_name = NULL;
    public $perpage = 0;
    public $cwp = 0;
    public $segment = 4;
    public $access_key = NULL;
    public $style = [];
    public $script = [];
    public $page = NULL;

    public function __construct() {
        parent::__construct();
        $this->_core =& get_instance();
        $this->sess = $this->session->userdata('user');
        $this->app_name = $this->init('APPLICATION_NAME');
        $this->perpage = (int) $this->init('ROW_PERPAGE');
        $this->cwp = (int) $this->init('COUNT_WRONG_PASSWORD');
        $this->access_key = $this->init('ACCESS_KEY');
        $this->page = $this->_core->mn->gtbylnk($this->_core->uri->segment(1) . '/' . $this->_core->uri->segment(2));
    }

    public function init($key = NULL) {
        if (empty($key))
            return;

        $this->db->select('value');
        $query = $this->db->get_where($this->_tbl, ['key' => $key]);
        $b = $query->row_array();
        return reset($b);
    }

    public function check_session() {
        if (empty($this->sess))
            redirect('in/');
        
        return;
    }

}

/* End of file cfg.php */
/* Location: ./application/model/cfg.php */