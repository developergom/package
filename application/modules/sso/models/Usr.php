<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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

    public function __construct() {
        parent::__construct();
        $this->_core = & get_instance();
    }

    public function init($uid = NULL) {
        if (empty($uid))
            return;

        $query = $this->db->get_where($this->_tbl, ['uid' => $uid]);
        if ($query->num_rows() > 0)
            $this->_setval($query->row_array());
    }

    private function _setval($array_key = []) {
        $REF_CLASS = new ReflectionClass($this);
        if (is_array($array_key) && !empty($array_key)) {
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

    public function fusr($limit = 0, $param = []) {
        if (array_key_exists('search', $param)) {
            $this->db->like('unme', $param['search']);
            $this->db->or_like('ufnme', $param['search']);
            $this->db->or_like('uninme', $param['search']);
            $this->db->or_like('umail', $param['search']);
        }

        if (!empty($param['sort'])) {
            $this->db->order_by($param['sort']);
        } else {
            $this->db->order_by('uid');
        }

        $offset = (!empty($param['page'])) ? $this->cfg->perpage : 0;
        $this->db->limit($limit, $offset);
        $query = $this->db->get($this->_tbl);
        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    public function cusr($param = []) {
        if (array_key_exists('search', $param)) {
            $this->db->like('unme', $param['search']);
            $this->db->or_like('ufnme', $param['search']);
            $this->db->or_like('uninme', $param['search']);
            $this->db->or_like('umail', $param['search']);
        }
        $query = $this->db->get($this->_tbl);
        return $query->num_rows();
    }

    public function iusr() {
        $this->tdata['cu'] = $this->cfg->sess;
        $this->tdata['cd'] = date('Y-m-d H:i:s');
        $this->tdata['uu'] = $this->cfg->sess;
        $this->tdata['ud'] = date('Y-m-d H:i:s');
        $this->db->insert($this->_tbl, $this->tdata);
        return ($this->db->affected_rows() > 0) ? $this->db->insert_id() : FALSE;
    }

    public function eusr() {
        if (empty($this->uid))
            return;

        $this->tdata['uu'] = $this->cfg->sess;
        $this->tdata['ud'] = date('Y-m-d H:i:s');
        $this->db->where('uid', $this->uid);
        $this->db->update($this->_tbl, $this->tdata);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function dusr() {
        if (empty($this->uid))
            return;

        $this->db->delete($this->_tbl, ['uid' => $this->uid]);
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
            if ($this->uwpas < $this->cfg->cwp) {
                $this->tdata['uwpas'] = $this->uwpas + 1;
                return ($this->eusr()) ? 'warning' : FALSE;
            } else if ($this->uwpas == $this->cfg->cwp) {
                $this->tdata['ustat'] = FALSE;
                return ($this->eusr()) ? 'blocked' : FALSE;
            } else {
                return 'wrong';
            }
        }
    }

}

/* End of file usr.php */
/* Location: ./application/model/usr.php */