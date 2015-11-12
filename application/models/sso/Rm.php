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
    public $tdata = array();
    private $tbl = 'rm';
    private $core;
    
    public function __construct() {
        parent::__construct();
        $this->core =& get_instance();
    }
    
    public function init($rid = null) {
        $this->db->select('mid, rmk');
        $query = $this->db->get_where($this->tbl, array('rid' => $rid));
        $tmp = array();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $this->rid = $rid;
            foreach($result as $v) {
                $tmp[$v['mid']] = json_decode($v['rmk']);
            }
            return $tmp;
        }
    }
    
    public function irm() {
        $this->db->insert($this->tbl, $this->tdata);
        return ($this->db->affected_rows() > 0) ? true : false;
    }
    
    public function drm() {
        if (empty($this->rid))
            return;
        
        $this->db->where('rid', $this->rid);
        $this->db->delete($this->tbl);
        return ($this->db->affected_rows() > 0) ? true : false;
    }

}

/* End of file rm.php */
/* Location: ./application/model/rm.php */