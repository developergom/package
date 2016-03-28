<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of mn
 *
 * @author soniibrol
 */
class Ts extends CI_Model {

    public $mid;
    public $mpar;
    public $mnme;
    public $mlnk;
    public $mico;
    public $mstat;
    public $tdata;
    private $tbl = 'mn';
    private $core;

    public function __construct() {
        parent::__construct();
        $this->core = & get_instance();
    }

    public function init($mid = null) {
        if (empty($mid))
            return;

        $this->db->where('mid', $mid);
        $query = $this->db->get($this->tbl);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $this->setval($result);
        }
    }

    public function setval($array_key) {
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

    public function fmn($stat = false) {
        $this->db->join('usr u', 'u.uid = m.uu', 'LEFT');
        if ($stat)
            $this->db->where('m.mstat', true);

        $query = $this->db->get($this->tbl . ' m');
        $result = $query->result_array();
        return ($query->num_rows() > 0) ? $result : false;
    }

    public function opt() {
        $data = $this->fmn(true);
        $tmp = array(null => 'Select parent menu');
        foreach ($data as $k => $v) {
            $tmp[$k] = $v;
        }
        return $tmp;
    }

    public function smn($param = null) {
        if (empty($param))
            return;

        $this->db->join('usr u', 'u.uid = m.uu', 'LEFT');
        $this->db->like('m.mnme', $param);
        $this->db->or_like('m.mlnk', $param);
        $query = $this->db->get($this->tbl . ' m');
        $result = $query->result_array();
        return ($query->num_rows() > 0) ? $result : false;
    }

    public function imn() {
        $this->tdata['cu'] = $this->core->sess;
        $this->tdata['cd'] = date('Y-m-d H:i:s');
        $this->tdata['uu'] = $this->core->sess;
        $this->tdata['ud'] = date('Y-m-d H:i:s');
        $this->db->insert($this->tbl, $this->tdata);
        return ($this->db->affected_rows() > 0) ? $this->db->insert_id() : false;
    }

    public function emn() {
        if (empty($this->mid))
            return;

        $this->tdata['uu'] = $this->core->sess;
        $this->tdata['ud'] = date('Y-m-d H:i:s');
        $this->db->where('mid', $this->mid);
        $this->db->update($this->tbl, $this->tdata);
        return ($this->db->affected_rows() > 0) ? true : false;
    }

    public function dmn() {
        if (empty($this->mid))
            return;

        $this->db->where('mid', $this->mid);
        $this->db->delete($this->tbl);
        return ($this->db->affected_rows() > 0) ? true : false;
    }

    public function drmn($mid = null) {
        if (empty($mid))
            return;

        $this->init($mid);
        $query = $this->db->get_where($this->tbl, array('mpar' => $this->mid));
        $result = $query->result_array();
        if ($query->num_rows() > 0) {
            foreach ($result as $v)
                $this->drmn($v['mid']);
        }
        $this->db->delete($this->tbl, array('mid' => $this->mid));
    }

    public function gtbylnk($link = null) {
        if (empty($link))
            return;

        $query = $this->db->get_where($this->tbl, array('mlnk' => $link));
        return $query->row_array();
    }

    function get_paged_list($limit = 10, $offset = 0, $order_column = '', $order_type = 'asc', $search = '', $fields = '') {

        if ($search != '' AND $fields != '') {
            $likeclause = '(';
            $i = 0;
            foreach ($fields as $field) {
                if ($i == count($fields) - 1) {
                    $likeclause .= $field . " LIKE '%" . $search . "%'";
                } else {
                    $likeclause .= $field . " LIKE '%" . $search . "%' OR ";
                }
                ++$i;
            }
            $likeclause .= ')';
            $this->db->where($likeclause);
        }

        $this->db->select('mid,mpar,mnme,mlnk,mordr,mico,mstat,mn.ud,u.ufnme');
        $this->db->join('usr u', 'u.uid = mn.uu', 'LEFT');

        if (empty($order_column) || empty($order_type)) {
            $this->db->order_by('mid', 'desc');
        } else {
            $this->db->order_by($order_column, $order_type);
        }


        return $this->db->get('mn', $limit, $offset);
    }

    function count_all($search = '', $fields = '') {

        if ($search != '' AND $fields != '') {
            $likeclause = '(';
            $i = 0;
            foreach ($fields as $field) {
                if ($i == count($fields) - 1) {
                    $likeclause .= $field . " LIKE '%" . $search . "%'";
                } else {
                    $likeclause .= $field . " LIKE '%" . $search . "%' OR ";
                }
                ++$i;
            }
            $likeclause .= ')';
            $this->db->where($likeclause);
        }

        $this->db->select('mid,mpar,mnme,mlnk,mordr,mico,mstat,mn.ud,u.ufnme');
        $this->db->join('usr u', 'u.uid = mn.uu', 'LEFT');

        return $this->db->count_all_results('mn');
    }

}

/* End of file mn.php */
/* Location: ./application/model/mn.php */