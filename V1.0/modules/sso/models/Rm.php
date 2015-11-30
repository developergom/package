<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of rm
 *
 * @author nanank
 */
class Rm extends CI_Model {
    
    public $rid;
    public $mid;
    public $rmk;
    public $tdata = [];
    private $_tbl = 'rm';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function init($rid = NULL) {
        $query = $this->db->select('mid, rmk')->get_where($this->_tbl, ['rid' => $rid]);
        $tmp = [];
        if ($query->num_rows() > 0) {
            $this->rid = $rid;
            foreach($query->result_array() as $row)
                $tmp[$row['mid']] = json_decode_db($row['rmk']);
            
            return $tmp;
        }
    }
    
    public function irm() {
        $this->db->insert($this->_tbl, $this->tdata);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
    
    public function drm() {
        if (empty($this->rid))
            return;
        
        $this->db->delete($this->_tbl, ['rid' => $this->rid]);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

}

/* End of file rm.php */
/* Location: ./application/model/rm.php */