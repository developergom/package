<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Country
 *
 * @author nanank
 */
class Cntry extends CI_Model {

    public $cid;
    public $ccd;
    public $cnm;
    public $ciso3cd;
    public $cncd;
    public $tdata = [];
    private $_tbl = 'cntry';
    private $_db = NULL;

    public function __construct() {
        parent::__construct();
        $this->_db = $this->load->database('RESIDENCE', TRUE);
    }

    public function init($cid = NULL) {
        if (empty($cid))
            return;

        $query = $this->_db->get_where($this->_tbl, ['cid' => $cid]);
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

    public function dttable($param = []) {
        $draw = (empty($param['draw'])) ? 1 : $param['draw'];
        if (!empty($param['search']['value'])) {
            $this->_db->like('ccd', $param['search']['value']);
            $this->_db->or_like('cnm', $param['search']['value']);
            $this->_db->or_like('ciso3cd', $param['search']['value']);
        }

        if (!empty($param['order'])) {
            $order = reset($param['order']);
            $column = (!empty($order['column'])) ? $order['column'] : 'cnm';
            $this->_db->order_by($column . ' ' . strtoupper($order['dir']));
        } else {
            $this->_db->order_by('cnm ASC');
        }

        if (!empty($param['start']) && !empty($param['length'])) {
            $this->_db->limit($param['length'], $param['start']);
        } else if (empty($param['start']) && !empty($param['length'])) {
            $this->_db->limit($param['length'], 0);
        } else {
            $this->_db->limit(10, 0);
        }

        $query = $this->_db->select('ccd, cnm, ciso3cd')->get($this->_tbl);
        $data = [];
        foreach ($query->result_array() as $row) {
            $data[] = [
                $row['ccd'],
                $row['cnm'],
                $row['ciso3cd']
            ];
        }

        return [
            'draw' => (int) $draw,
            'recordsTotal' => (int) $this->_db->get($this->_tbl)->num_rows(),
            'recordsFiltered' => (int) $this->_db->get($this->_tbl)->num_rows(),
            'data' => $data
        ];
    }

    public function ecntry() {
        if (empty($this->cid))
            return;

        $this->tdata['ub'] = $this->cfg->sess;
        $this->tdata['uw'] = date('Y-m-d H:i:s');
        $this->_db->where('cid', $this->cid);
        $this->_db->update($this->_tbl, $this->tdata);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

}

/* End of file Cntry.php */
/* Location: ./application/model/Cntry.php */