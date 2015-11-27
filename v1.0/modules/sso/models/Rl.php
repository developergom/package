<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of rl
 *
 * @author nanank
 */
class Rl extends CI_Model {

    public $rid;
    public $rnme;
    public $rdesc;
    public $rstat;
    public $tdata;
    private $_tbl = 'rl';

    public function __construct() {
        parent::__construct();
    }

    public function init($rid = null) {
        if (empty($rid))
            return;

        $query = $this->db->get_where($this->_tbl, ['rid' => $rid]);
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

    public function frl($limit = 0, $param = []) {
        $this->db->select('r.rid, r.rnme, r.rdesc, r.rstat, r.ud, u.ufnme');
        if (array_key_exists('search', $param))
            $this->db->like('r.rnme', $param['search']);

        $offset = (!empty($param['page'])) ? $this->cfg->perpage : 0;
        $this->db->join('usr u', 'u.uid = r.uu', 'INNER');

        if (!empty($param['sort'])) {
            $this->db->order_by($param['sort']);
        } else {
            $this->db->order_by('r.rid');
        }

        $this->db->limit($limit, $offset);
        $query = $this->db->get($this->_tbl . ' r ');
        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    public function crl($param = []) {
        if (array_key_exists('search', $param))
            $this->db->like('rnme', $param['search']);

        $query = $this->db->get($this->_tbl);
        return $query->num_rows();
    }

    public function opt() {
        $data = $this->frl();
        $tmp = [NULL => 'Select role'];
        foreach ($data as $row)
            $tmp[$row['rid']] = $row['rnme'];

        return $tmp;
    }

    public function irl() {
        $this->tdata['cu'] = $this->cfg->sess;
        $this->tdata['cd'] = date('Y-m-d H:i:s');
        $this->tdata['uu'] = $this->cfg->sess;
        $this->tdata['ud'] = date('Y-m-d H:i:s');
        $this->db->insert($this->_tbl, $this->tdata);
        return ($this->db->affected_rows() > 0) ? $this->db->insert_id() : FALSE;
    }

    public function erl() {
        if (empty($this->rid))
            return;

        $this->tdata['uu'] = $this->cfg->sess;
        $this->tdata['ud'] = date('Y-m-d H:i:s');
        $this->db->where('rid', $this->rid);
        $this->db->update($this->_tbl, $this->tdata);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function drl() {
        if (empty($this->rid))
            return;

        $this->db->delete($this->_tbl, ['rid' => $this->rid]);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

}

/* End of file rl.php */
/* Location: ./application/model/rl.php */