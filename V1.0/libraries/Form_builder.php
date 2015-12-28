<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Form_builder
 *
 * @author nanank
 */
class Form_builder {

    var $ci;
    private $_db = NULL;
    protected $attr = [];
    protected $attribute = [];
    protected $primary = NULL;
    protected $index = NULL;
    protected $field = [];
    protected $form_data = [];
    protected $form_validation = [];
    protected $status = [];
    protected $tdata = [];
    protected $perpage = 0;

    public function __construct($attribute = []) {
        $this->ci = & get_instance();
        $this->ci->load->library('template');
        if (!empty($attribute))
            $this->initialize($attribute);
    }

    public function initialize($attribute = []) {
        $this->ci->setting->check_session();
        $this->attribute = array_to_object($attribute);
        $this->_db = (!isset($this->attribute->connection) && empty($this->attribute->connection)) ? $this->ci->db : $this->ci->load->database($this->attribute->connection, TRUE);

        if (!isset($this->attribute->grid) && empty($this->attribute->grid))
            $this->attribute->grid = 'DEFAULT';

        foreach ($this->attribute->field as $index => $row) {
            if ($row->is_primary) {
                $this->primary = $index;
                continue;
            }

            if ($row->show) {
                $this->field[$index] = $row->label;
                $this->form_data[$index] = [
                    'primary' => $row->is_primary,
                    'name' => $index,
                    'label' => $row->label,
                    'type' => $row->type,
                    'form' => $row->form,
                    'rules' => $row->rules
                ];
                $this->form_validation[$index] = [
                    'label' => $row->label,
                    'rules' => $row->rules
                ];
            }
        }

        $this->status = array_filter(array_keys($this->field), function ($key) {
            return strpos($key, 'stat');
        });

        $this->form_data = array_to_object($this->form_data);
        $this->status = implode(',', $this->status);
        $this->perpage = ($this->attribute->grid == 'SIMPLE') ? $this->ci->setting->perpage * 2 : $this->ci->setting->perpage;
    }

    protected function build($id = NULL) {
        if (empty($id))
            $id = $this->ci->uri->segment(4);

        $query = $this->_db->get_where($this->attribute->table, [$this->primary => $id]);
        if ($query->num_rows() > 0)
            $this->tdata = $query->row_array();

        $query->free_result();
    }

    public function show_index() {
        if (!empty($this->ci->input->post('act')) && $this->ci->input->post('act') == 'delsel')
            $this->do_submit();

        $this->attr['breadcrumb'] = [anchor('/', '<i class="fa fa-home"></i> Home'), $this->ci->setting->page['mnme']];
        $this->attr['create'] = $this->ci->setting->uri_string() . '/form/';
        $this->attr['datagrid'] = $this->_set_datagrid();
        $this->ci->template->load($this->ci->setting->template . '/default', $this->ci->setting->template . '/default_index', $this->attr, TRUE);
    }

    public function show_form() {
        $this->ci->setting->script = ['jquery.inputmask', 'jquery.inputmask.extensions', 'jquery.inputmask.date.extensions', 'bootstrap-datepicker'];
        $this->ci->setting->style = ['datepicker3'];
        $this->build();
        $br3 = (empty($this->tdata)) ? 'Create New' : 'Edit Data';
        $this->attr['breadcrumb'] = [anchor('/', '<i class="fa fa-home"></i> Home'), anchor($this->ci->setting->page['mlnk'], $this->ci->setting->page['mnme']), $br3];
        $this->attr['action'] = $this->ci->setting->uri_string() . '/act/';
        $this->attr['key'] = (!empty($this->tdata)) ? [$this->primary => $this->tdata[$this->primary]] : NULL;
        $this->attr['field'] = $this->form_data;
        $this->attr['data'] = $this->tdata;
        $this->ci->template->load($this->ci->setting->template . '/default', $this->ci->setting->template . '/default_form', $this->attr, TRUE);
    }

    public function do_submit() {
        $this->ci->load->library('form_validation');
        $postdata = $this->ci->input->post();
        if (isset($postdata['act']) && $postdata['act'] == 'delsel')
            $this->_do_delete($postdata[$this->primary]);
        
        foreach ($this->form_validation as $index => $row) {
            if (array_key_exists($index, $postdata))
                $this->ci->form_validation->set_rules($index, $row['label'], $row['rules']);
        }

        if ($this->ci->form_validation->run() === FALSE) {
            $this->show_form();
        } else {
            if (!empty($postdata[$this->primary]))
                $this->build($postdata[$this->primary]);

            $this->tdata = $postdata;
            if (!isset($postdata[$this->status]))
                $this->tdata[$this->status] = FALSE;

            $this->_do();
            redirect($this->ci->setting->uri_string(), 'refresh');
        }
    }

    private function _do() {
        $this->tdata['ub'] = $this->ci->setting->sess;
        $this->tdata['uw'] = date('Y-m-d H:i:s');
        if (empty($this->tdata[$this->primary])) {
            $this->tdata['cb'] = $this->ci->setting->sess;
            $this->tdata['cw'] = date('Y-m-d H:i:s');
            $this->_db->insert($this->attribute->table, $this->tdata);
            $insert = ($this->_db->affected_rows() > 0) ? $this->_db->insert_id() : FALSE;
        } else {
            $this->_db->where($this->primary, $this->tdata[$this->primary]);
            unset($this->tdata[$this->primary]);
            $this->_db->update($this->attribute->table, $this->tdata);
            $update = ($this->_db->affected_rows() > 0) ? TRUE : FALSE;
        }
    }

    private function _do_delete($primary = []) {
        if (empty($primary))
            return;

        array_walk($primary, function($value) {
            $this->_db->delete($this->attribute->table, [$this->primary => $value]);
        });

        redirect($this->ci->setting->uri_string(), 'refresh');
    }

    public function _set_datagrid() {
        if (isset($this->attribute->grid) && !empty($this->attribute->grid)) {
            switch ($this->attribute->grid) {
                case 'SIMPLE' : return $this->_simple_grid();
                    break;
                case 'DATAGRID' : return $this->_jquery_grid();
                    break;
                default : return $this->_default_grid();
                    break;
            }
        } else {
            return $this->_default_grid();
        }
    }

    private function _simple_grid() {
        $this->ci->load->library(['table', 'pagination']);
        $config['total_rows'] = (int) $this->_get_coundata();
        $config['per_page'] = (int) $this->perpage;
        $this->ci->pagination->initialize($config);

        $delete = nbs();
        if ($this->ci->setting->can_delete()) {
            array_splice($this->field, 0, 0, [nbs(2) . '#']);
            $delete = form_button('delete', '<i class="fa fa-trash"></i> Delete Selected', 'class="btn btn-danger" data-toggle="modal" data-target="#confirm-delete" data-href="submit"');
        }

        $this->ci->table->set_heading($this->field);
        foreach ($this->_datagrid() as $row) {
            if ($this->ci->setting->can_edit())
                $row[key($row)] = anchor($this->ci->setting->uri_string() . '/form/' . $row[$this->primary], $row[key($row)], 'title="Edit data" class="text-purple"');

            if ($this->ci->setting->can_delete())
                array_splice($row, 0, 0, [form_checkbox($this->primary . '[]', $row[$this->primary], NULL, 'class="id"')]);

            unset($row[$this->primary]);
            if (!empty($this->status))
                $row['status'] = $this->status_label($row['status']);

            $this->ci->table->add_row($row);
        }

        $row = '<div class="pull-right">Total ' . singular_plural((int) $this->_get_coundata(), 'record') . '</div>';
        $pagination = '<div class="pull-right">' . $this->ci->pagination->create_links() . '</div>';
        return form_open(current_url() . '/act/', ['class' => 'simplegrid'], ['act' => 'delsel']) . $this->ci->table->generate() . $delete . $row . form_close() . $pagination;
    }

    private function _jquery_grid() {
        return;
    }

    private function _default_grid() {
        $this->ci->load->library('pagination');
        $config['total_rows'] = (int) $this->_get_coundata();
        $config['per_page'] = (int) $this->perpage;
        $this->ci->pagination->initialize($config);

        $table = '<div class="table-responsive"><table class="table table-condensed table-hover"><thead><tr>';
        $order = ($this->ci->input->get('order') === 'desc') ? 'asc' : 'desc';
        foreach ($this->field as $khead => $vhead) {
            if ($khead != $this->status)
                $table .= sprintf('<th aria-name="%s">%s</th>', $khead, anchor(current_url() . '?sort=' . $khead . '&order=' . $order, $vhead));
        }
        $table .= '</tr></thead><tbody>';
        foreach ($this->_datagrid() as $vbody) {
            $table .= sprintf('<tr class="tr%s" data-key="%s">', (!empty($vbody['status']) && $vbody['status'] == FALSE) ? ' danger' : NULL, $vbody[$this->primary]);
            foreach ($vbody as $index => $row) {
                if ($index != 'status')
                    $table .= ($index !== $this->primary) ? sprintf('<td>%s</td>', $row) : NULL;
            }
            $table .= '</tr>';
        }
        $table .= '</tbody></table></div>' . br();
        $rows = sprintf('<em class="pull-right text-muted">%s</em>', singular_plural($this->_get_coundata(), 'row'));
        return $this->_search_default_grid() . $table . $rows . $this->ci->pagination->create_links();
    }

    private function _search_default_grid() {
        $search = form_open($this->ci->setting->uri_string(), ['method' => 'GET']);
        $search .= '<div class="row"><div class="col-xs-offset-9 col-xs-3"><div class="input-group input-group-sm">';
        $search .= form_input('search', '', 'class="form-control" placeholder="Search..."');
        $search .= '<div class="input-group-btn">';
        $search .= form_button('search', '<i class="fa fa-search"></i>', 'class="btn btn-default"');
        $search .= '</div></div></div></div>';
        $search .= form_close(br());
        return $search;
    }

    private function _getdata() {
        $param = $this->ci->input->get();
        $this->field[$this->primary] = 'Primary Key';
        if ($this->attribute->grid == 'SIMPLE')
            array_shift($this->field);

        $this->_db->select(array_keys($this->field));
        if (!empty($param['search'])) {
            foreach (array_keys($this->field) as $index => $row) {
                $like = (($index + 1) < 1) ? 'like' : 'or_like';
                $this->_db->$like($row, $param['search']);
            }
        }

        $sort = (!empty($param['sort'])) ? $param['sort'] : $this->primary;
        $this->_db->order_by($sort, (!empty($param['sort'])) ? strtoupper($param['order']) : 'ASC');

        $offset = (!empty($param['page'])) ? $this->perpage * ($param['page'] - 1) : 0;
        $this->_db->limit($this->perpage, $offset);
        return $this->_db->get($this->attribute->table)->result_array();
    }

    private function _get_coundata() {
        $search = $this->ci->input->get('search');
        if (!empty($search)) {
            foreach (array_keys($this->field) as $index => $row) {
                $like = (($index + 1) < 1) ? 'like' : 'or_like';
                $this->_db->$like($row, $search);
            }
        }
        $query = $this->_db->get($this->attribute->table);
        return $query->num_rows();
    }

    private function _datagrid() {
        $data = $this->_getdata();
        foreach ($data as $index => $row) {
            if ($this->attribute->grid !== 'SIMPLE') {
                $data[$index][key($row)] = $row[key($row)] . sprintf('<div class="small action" id="qe-%s">', $row[$this->primary]);
                if ($this->ci->setting->can_edit()) {
                    $data[$index][key($row)] .= anchor($this->ci->setting->uri_string() . '/form/' . $row[$this->primary], '<i class="fa fa-edit"></i> Edit', 'title="Edit data"');
                    if ($this->ci->setting->quick_edit()) {
                        $data[$index][key($row)] .= nbs(2) . '<span class="text-muted">|</span>' . nbs(2);
                        $data[$index][key($row)] .= anchor('#', '<i class="fa fa-pencil"></i>  Quick Edit', 'title="Quick Edit" class="quick-edit" id="qt-' . $row[$this->primary] . '"');
                    }
                }
                if ($this->ci->setting->can_delete()) {
                    $data[$index][key($row)] .= nbs(2) . '<span class="text-muted">|</span>' . nbs(2);
                    $data[$index][key($row)] .= anchor('#', '<i class="fa fa-trash"></i> Delete', 'class="text-danger" title="Delete data" data-toggle="modal" data-target="#confirm-delete" data-href="' . base_url($this->ci->setting->uri_string() . '/erase/' . $row[$this->primary]) . '"');
                }
                $data[$index][key($row)] .= '</div>';
                if ($this->ci->setting->quick_edit()) {
                    $data[$index][key($row)] .= sprintf('<div class="quick-form" id="qf-%s">', $row[$this->primary]);
                    $data[$index][key($row)] .= form_open($this->ci->setting->uri_string() . '/act/', 'class="form-horizontal"', [$this->primary => $row[$this->primary]]);
                    $data[$index][key($row)] .= '<div class="form-group">' . form_label('', '', ['class' => 'col-xs-4 col-md-2 control-label']);
                    $data[$index][key($row)] .= '<div class="col-xs-4 col-md-10">' . form_input('', NULL, 'class="input-sm form-control" id="rnme"');
                    $data[$index][key($row)] .= '</div></div><div class="form-group"><div class="col-sm-offset-2 col-sm-10">';
                    $data[$index][key($row)] .= form_button('submit', '<i class="fa fa-pencil"></i> Update data', 'class="btn btn-sm btn-primary"');
                    $data[$index][key($row)] .= form_button('cancel', 'Cancel', 'class="btn btn-sm btn-default" id="cqe-' . $row[$this->primary] . '"');
                    $data[$index][key($row)] .= '</div></div>' . form_close() . '</div>';
                }
            }
            if (filter_var_array($row, FILTER_VALIDATE_EMAIL)) {
                $email = array_filter(filter_var_array($row, FILTER_VALIDATE_EMAIL));
                $data[$index][key($email)] = mailto(reset($email));
            }

            $data[$index] = array_intersect_key($data[$index], $this->field);
            if (!empty($this->status)) {
                $data[$index]['status'] = $row[$this->status];
                unset($data[$index][$this->status]);
            }
        }
        return $data;
    }

    protected function status_label($status = FALSE) {
        $label = [
            '<span class="label label-danger">Not Active</span>',
            '<span class="label label-success">Active</span>'
        ];

        return $label[$status];
    }

}
