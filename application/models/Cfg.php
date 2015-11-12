<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of cfg
 *
 * @author nanank
 */
class Cfg extends CI_Model {
    
    public $key;
    public $value;
    public $description;
    public $tdata;
    private $tbl = 'cfg';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function init($key = 'null') {
        if(empty($key))
            return;
        
        $this->db->select('value');
        $query = $this->db->get_where($this->tbl, array('key' => $key));
        $b = $query->row_array();
        return reset($b);
    }

}

/* End of file cfg.php */
/* Location: ./application/model/cfg.php */