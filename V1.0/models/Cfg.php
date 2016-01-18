<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of cfg
 *
 * @author nanank
 */
class Cfg extends CI_Model {

    private $_tbl = 'cfg';
    

    public function __construct() {
        parent::__construct();
        
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