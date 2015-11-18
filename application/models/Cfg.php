<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of cfg
 *
 * @author nanank
 */
class Cfg extends CI_Model {

    private $_tbl = 'cfg';

    public $sess = NULL;
    public $app_name = NULL;
    public $perpage = 0;


    public function __construct() {
        parent::__construct();
        
        $this->sess = $this->session->userdata('user');
        $this->app_name = $this->init('APPLICATION_NAME');
        $this->perpage = (int) $this->init('ROW_PERPAGE');
    }

    public function init($key = NULL) {
        if (empty($key))
            return;

        $this->db->select('value');
        $query = $this->db->get_where($this->_tbl, ['key' => $key]);
        $b = $query->row_array();
        return reset($b);
    }


}

/* End of file cfg.php */
/* Location: ./application/model/cfg.php */