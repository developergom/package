<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of url
 *
 * @author nanank
 */
class Url extends CI_Model {
    
    public $uid;
    public $rid;
    public $tdata = [];
    private $_tbl = 'url';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function init($uid = NULL) {
        $query = $this->db->get_where($this->_tbl, ['uid' => $uid]);
        $tmp = [];
        if ($query->num_rows() > 0) {
            $this->uid = $uid;
            foreach($query->result_array() as $row)
                $tmp[] = $row['rid'];
            
            return $tmp;
        }
    }
    
    public function iurl() {
        $this->db->insert($this->_tbl, $this->tdata);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
    
    public function durl() {
        if (empty($this->uid))
            return;
        
        $this->db->delete($this->_tbl, ['uid' => $this->uid]);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

}

/* End of file url.php */
/* Location: ./application/model/url.php */