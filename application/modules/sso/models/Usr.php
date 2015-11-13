<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of usr
 *
 * @author nanank
 */
class Usr extends CI_Model {
    
    public $uid;
    public $unme;
    public $uninme;
    public $ufnme;
    public $upass;
    public $umail;
    public $uwpas;
    public $upp;
    public $ubirth;
    public $ustat;
    public $tdata = array();
    private $tbl = 'usr';
    private $core;
    protected $cwp;
    
    public function __construct() {
        parent::__construct();
        $this->core =& get_instance();
        $this->cwp = (int) $this->cfg->init('COUNT_WRONG_PASSWORD');
    }
    
    public function init($uid = null) {
        if(empty($uid))
            return;
        
        $this->db->where('uid', $uid);
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
    
    public function fusr($limit = 0, $start = 0, $stat = false) {
        if($stat)
            $this->db->where('ustat', true);
        
        if(!empty($limit))
            $this->db->limit($limit, $start);
        
        $query = $this->db->get($this->tbl);
        $result = $query->result_array();
        return ($query->num_rows() > 0) ? $result : false;
    }
    
    public function cusr($stat = false) {
        if($stat)
            $this->db->where('ustat', true);
        
        return $this->db->count_all($this->tbl);
    }
    
    public function susr($param = null) {
        if(empty($param))
            return;
        
        $this->db->like('unme', $param);
        $this->db->or_like('uninme', $param);
        $this->db->or_like('ufnme', $param);
        $this->db->or_like('umail', $param);
        $query = $this->db->get($this->tbl);
        $result = $query->result_array();
        return ($query->num_rows() > 0) ? $result : false;
    }

    public function iusr() {
        $this->tdata['cu'] = $this->core->sess;
        $this->tdata['cd'] = date('Y-m-d H:i:s');
        $this->db->insert($this->tbl, $this->tdata);
        return ($this->db->affected_rows() > 0) ? $this->db->insert_id() : false;
    }

    public function eusr() {
        if (empty($this->uid))
            return;
        
        $this->tdata['uu'] = $this->core->sess;
        $this->tdata['ud'] = date('Y-m-d H:i:s');
        $this->db->where('uid', $this->uid);
        $this->db->update($this->tbl, $this->tdata);
        return ($this->db->affected_rows() > 0) ? true : false;
    }

    public function dusr() {
        if (empty($this->uid))
            return;
        
        $this->db->where('uid', $this->uid);
        $this->db->delete($this->tbl);
        return ($this->db->affected_rows() > 0) ? true : false;
    }
    
    public function in($key = null, $pass = null) {
        $key = $this->core->security->xss_clean($key);
        $this->db->where(array('ustat' => true, 'unme' => $key));
        $this->db->or_where('umail', $key);
        $query = $this->db->get($this->tbl);
        if ($query->num_rows() == 0)
            return 'invalid';

        $result = $query->row_array();
        $decode = $this->core->encrypt->decode($result['upass']);
        if ($pass == $decode) {
            $this->core->session->set_userdata('user', $result['uid']);
            $this->core->session->set_userdata('name', $result['ufnme']);
            $this->core->session->set_userdata('username', $result['unme']);
            $this->core->session->set_userdata('nick', $result['uninme']);
            $this->core->session->set_userdata('uava', $result['upp']);
            return 'success';
        } else {
            $this->init($result['uid']);
            $this->tdata = array('uu' => $this->uid, 'ud' => date('Y-m-d H:i:s'));
            if ($this->uwpas < $this->cwp) {
                $this->tdata['uwpas'] = $this->uwpas + 1;
                $count = $this->eusr();
                return ($count) ? 'warning' : false;
            } else if ($this->uwpas == $this->cwp) {
                $this->tdata['ustat'] = false;
                $block = $this->eusr();
                return ($block) ? 'blocked' : false;
            } else {
                return 'wrong';
            }
        }
    }
    
}

/* End of file usr.php */
/* Location: ./application/model/usr.php */