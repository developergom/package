<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of mn
 *
 * @author nanank
 */
class Mn extends CI_Model {

    public $mid;
    public $mpar;
    public $mnme;
    public $mlnk;
    public $mico;
    public $mordr;
    public $mstat;
    public $tdata = [];
    private $_tbl = 'mn';

    public function __construct() {
        parent::__construct();
    }

    public function init($mid = NULL) {
        if (empty($mid))
            return;

        $query = $this->db->get_where($this->_tbl, ['mid' => $mid]);
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
        } else if (is_string($array_key) && !empty($array_key)) {
            if ($REF_CLASS->hasProperty($array_key)) {
                $this->$array_key = $value;
                $this->tdata[$array_key] = $value;
            }
        }
    }

    public function fmn($param = NULL) {
        if (!empty($param)) {
            $this->db->like('m.mnme', $param);
            $this->db->or_like('m.mlnk', $param);
        }

        $this->db->join('usr u', 'u.uid = m.uu', 'LEFT');
        $query = $this->db->get($this->_tbl . ' m');
        $result = $query->result_array();
        return ($query->num_rows() > 0) ? $result : [];
    }

    public function opt() {
        $data = $this->fmn();
        $tmp = [NULL => 'Select parent menu'];
        foreach ($data as $k => $v)
            $tmp[$k] = $v;

        return $tmp;
    }

    public function imn() {
        $this->tdata['cu'] = $this->cfg->sess;
        $this->tdata['cd'] = date('Y-m-d H:i:s');
        $this->tdata['uu'] = $this->cfg->sess;
        $this->tdata['ud'] = date('Y-m-d H:i:s');
        $this->db->insert($this->_tbl, $this->tdata);
        return ($this->db->affected_rows() > 0) ? $this->db->insert_id() : FALSE;
    }

    public function emn() {
        if (empty($this->mid))
            return;

        $this->tdata['uu'] = $this->cfg->sess;
        $this->tdata['ud'] = date('Y-m-d H:i:s');
        $this->db->where('mid', $this->mid);
        $this->db->update($this->_tbl, $this->tdata);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function dmn() {
        if (empty($this->mid))
            return;

        $this->db->delete($this->_tbl, ['mid' => $this->mid]);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function drmn($mid = NULL) {
        if (empty($mid))
            return;

        $this->init($mid);
        $query = $this->db->get_where($this->_tbl, ['mpar' => $this->mid]);
        $result = $query->result_array();
        if ($query->num_rows() > 0) {
            foreach ($result as $v)
                $this->drmn($v['mid']);
        }
        $this->db->delete($this->_tbl, ['mid' => $this->mid]);
    }

    public function gtbylnk($link = NULL) {
        if (empty($link))
            return;

        $query = $this->db->get_where($this->_tbl, ['mlnk' => $link]);
        return $query->row_array();
    }

}

/* End of file mn.php */
/* Location: ./application/model/mn.php */