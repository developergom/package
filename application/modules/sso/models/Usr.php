<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

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
    public $tdata = [];
    private $_tbl = 'usr';
    private $_core;
    protected $cwp;

    public function __construct() {
        parent::__construct();
        $this->_core = & get_instance();
        $this->cwp = (int) $this->cfg->init('COUNT_WRONG_PASSWORD');
    }

    public function init($uid = NULL) {
        if (empty($uid))
            return;

        $this->db->where('uid', $uid);
        $query = $this->db->get($this->_tbl);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $this->setval($result);
        }
    }

    public function setval($array_key = []) {
        $REF_CLASS = new ReflectionClass($this);
        if (is_array($array_key) and ! empty($array_key)) {
            foreach ($array_key as $key => $value) {
                if ($REF_CLASS->hasProperty($key)) {
                    $this->$key = $value;
                    $this->tdata[$key] = $value;
                }
            }
        } else if (is_string($array_key) and ! empty($array_key)) {
            if ($REF_CLASS->hasProperty($array_key)) {
                $this->$array_key = $value;
                $this->tdata[$array_key] = $value;
            }
        }
    }

//    public function fusr($limit = 0, $start = 0, $where = NULL, $stat = FALSE) {
//        if(isset($where) && !empty($where)) {
//            $this->db->like('unme', $where);
//            $this->db->or_like('uninme', $where);
//            $this->db->or_like('ufnme', $where);
//            $this->db->or_like('umail', $where);
//        }
//            
//        if($stat)
//            $this->db->where('ustat', TRUE);
//        
//        if(!empty($limit))
//            $this->db->limit($limit, $start);
//        
//        $query = $this->db->get($this->_tbl);
//        $result = $query->result_array();
//        return ($query->num_rows() > 0) ? $result : FALSE;
//    }

    public function fusr($limit = 0, $start = 0, $param = []) {
        if (isset($param) && !empty($param)) {
            foreach ($param as $key => $val) {
                if ($key === 'sort' OR $key === 'order') {
                    
                } else if ($key === 'search') {
                    $this->db->like('unme', $val);
                    $this->db->or_like('uninme', $val);
                    $this->db->or_like('ufnme', $val);
                    $this->db->or_like('umail', $val);
                } else {
                    continue;
                }
            }
        }

        if (!empty($limit))
            $this->db->limit($limit, $start);

        $query = $this->db->get($this->_tbl);
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function cusr() {
        return $this->db->count_all($this->_tbl);
    }

    public function iusr() {
        $this->tdata['cu'] = $this->_core->sess;
        $this->tdata['cd'] = date('Y-m-d H:i:s');
        $this->tdata['uu'] = $this->_core->sess;
        $this->tdata['ud'] = date('Y-m-d H:i:s');
        $this->db->insert($this->_tbl, $this->tdata);
        return ($this->db->affected_rows() > 0) ? $this->db->insert_id() : FALSE;
    }

    public function eusr() {
        if (empty($this->uid))
            return;

        $this->tdata['uu'] = $this->_core->sess;
        $this->tdata['ud'] = date('Y-m-d H:i:s');
        $this->db->where('uid', $this->uid);
        $this->db->update($this->_tbl, $this->tdata);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function dusr() {
        if (empty($this->uid))
            return;

        $this->db->where('uid', $this->uid);
        $this->db->delete($this->_tbl);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function in($key = NULL, $pass = NULL) {
        $key = $this->_core->security->xss_clean($key);
        $this->db->where(['ustat' => TRUE, 'unme' => $key]);
        $this->db->or_where('umail', $key);
        $query = $this->db->get($this->_tbl);
        if ($query->num_rows() == 0)
            return 'invalid';

        $result = $query->row_array();
        $decode = $this->_core->encrypt->decode($result['upass']);
        if ($pass == $decode) {
            $this->_core->session->set_userdata('user', $result['uid']);
            $this->_core->session->set_userdata('name', $result['ufnme']);
            $this->_core->session->set_userdata('username', $result['unme']);
            $this->_core->session->set_userdata('nick', $result['uninme']);
            $this->_core->session->set_userdata('uava', $result['upp']);
            return 'success';
        } else {
            $this->init($result['uid']);
            $this->tdata = ['uu' => $this->uid, 'ud' => date('Y-m-d H:i:s')];
            if ($this->uwpas < $this->cwp) {
                $this->tdata['uwpas'] = $this->uwpas + 1;
                $count = $this->eusr();
                return ($count) ? 'warning' : FALSE;
            } else if ($this->uwpas == $this->cwp) {
                $this->tdata['ustat'] = FALSE;
                $block = $this->eusr();
                return ($block) ? 'blocked' : FALSE;
            } else {
                return 'wrong';
            }
        }
    }

}

/* End of file usr.php */
/* Location: ./application/model/usr.php */