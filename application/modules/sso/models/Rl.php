<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of rl
 *
 * @author nanank
 */
class Rl extends CI_Model {
    
    public $rid;
    public $rnme;
    public $rstat;
    public $tdata;
    private $tbl = 'rl';
    private $core;
    
    public function __construct() {
        parent::__construct();
        $this->core =& get_instance();
    }
    
    public function init($rid = null) {
        if(empty($rid))
            return;
        
        $this->db->where('rid', $rid);
        $query = $this->db->get($this->tbl);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $this->setval($result);
        }
    }

    public function setval($array_key) {
        $REF_CLASS = new ReflectionClass($this);
        if (is_array($array_key) and !empty($array_key)) {
            foreach ($array_key as $key => $value) {
                if ($REF_CLASS->hasProperty($key)) {
                    $this->$key = $value;
                    $this->tdata[$key] = $value;
                }
            }
        } else if (is_string($array_key) and !empty($array_key)) {
            if ($REF_CLASS->hasProperty($array_key)) {
                $this->$array_key = $value;
                $this->tdata[$array_key] = $value;
            }
        }
    }
    
    public function frl($limit = 0, $start = 0, $stat = false) {
        $this->db->join('usr u', 'u.uid = r.uu', 'LEFT');
        if($stat)
            $this->db->where('r.rstat', true);
        
        if(!empty($limit))
            $this->db->limit($limit, $start);
        
        $query = $this->db->get($this->tbl . ' r ');
        $result = $query->result_array();
        return ($query->num_rows() > 0) ? $result : false;
    }
    
    public function crl($stat = false) {
        if($stat)
            $this->db->where('rstat', true);
        
        return $this->db->count_all($this->tbl);
    }
    
    public function srl($param = null) {
        if(empty($param))
            return;
        
        $this->db->join('usr u', 'u.uid = r.uu', 'LEFT');
        $this->db->like('r.rnme', $param);
        $query = $this->db->get($this->tbl . ' r');
        $result = $query->result_array();
        return ($query->num_rows() > 0) ? $result : false;
    }
    
    public function opt() {
        $data = $this->frl();
        $tmp = array(null => 'Select role');
        foreach ($data as $v)
            $tmp[$v['rid']] = $v['rnme'];
        
        return $tmp;
    }

    public function irl() {
        $this->tdata['cu'] = $this->core->sess;
        $this->tdata['cd'] = date('Y-m-d H:i:s');
        $this->tdata['uu'] = $this->core->sess;
        $this->tdata['ud'] = date('Y-m-d H:i:s');
        $this->db->insert($this->tbl, $this->tdata);
        return ($this->db->affected_rows() > 0) ? $this->db->insert_id() : false;
    }

    public function erl() {
        if (empty($this->rid))
            return;
        
        $this->tdata['uu'] = $this->core->sess;
        $this->tdata['ud'] = date('Y-m-d H:i:s');
        $this->db->where('rid', $this->rid);
        $this->db->update($this->tbl, $this->tdata);
        return ($this->db->affected_rows() > 0) ? true : false;
    }

    public function drl() {
        if (empty($this->rid))
            return;
        
        $this->db->where('rid', $this->rid);
        $this->db->delete($this->tbl);
        return ($this->db->affected_rows() > 0) ? true : false;
    }
}

/* End of file rl.php */
/* Location: ./application/model/rl.php */