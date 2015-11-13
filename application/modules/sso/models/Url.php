<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of url
 *
 * @author nanank
 */
class Url extends CI_Model {
    
    public $uid;
    public $rid;
    public $tdata;
    private $tbl = 'url';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function init($uid = null) {
        $query = $this->db->get_where($this->tbl, array('uid' => $uid));
        $tmp = array();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $this->uid = $uid;
            foreach($result as $v) {
                $tmp[] = $v['rid'];
            }
            return $tmp;
        }
    }
    
    public function iurl() {
        $this->db->insert($this->tbl, $this->tdata);
        return ($this->db->affected_rows() > 0) ? true : false;
    }
    
    public function durl() {
        if (empty($this->uid))
            return;
        
        $this->db->where('uid', $this->uid);
        $this->db->delete($this->tbl);
        return ($this->db->affected_rows() > 0) ? true : false;
    }

}

/* End of file url.php */
/* Location: ./application/model/url.php */