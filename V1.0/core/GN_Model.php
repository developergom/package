<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of GN_Model
 *
 * @author nanank
 */
class GN_Model extends CI_Model {

    protected $_db_group;
    protected $_table;
    public $_database;
    protected $primary_key = 'id';
    protected $soft_delete = FALSE;
    protected $soft_delete_key = 'deleted';
    protected $_temporary_with_deleted = FALSE;
    protected $_temporary_only_deleted = FALSE;
    protected $before_create = [];
    protected $after_create = [];
    protected $before_update = [];
    protected $after_update = [];
    protected $before_get = [];
    protected $after_get = [];
    protected $before_delete = [];
    protected $after_delete = [];
    protected $callback_parameters = [];
    protected $protected_attributes = [];
    protected $belongs_to = [];
    protected $has_many = [];
    protected $_with = [];
    protected $validate = [];
    protected $skip_validation = FALSE;
    protected $return_type = 'object';
    protected $_temporary_return_type = NULL;

    public function __construct() {
        parent::__construct();
        $this->load->helper('inflector');
        $this->_fetch_table();
        $this->_database = $this->_db_group === NULL ? $this->db : $this->load->database($this->_db_group, TRUE);
        array_unshift($this->before_create, 'protect_attributes');
        array_unshift($this->before_update, 'protect_attributes');
        $this->_temporary_return_type = $this->return_type;
    }

    public function get($primary_value) {
        return $this->get_by($this->primary_key, $primary_value);
    }

    public function get_by() {
        $where = func_get_args();
        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE)
            $this->_database->where($this->soft_delete_key, (bool) $this->_temporary_only_deleted);

        $this->_set_where($where);
        $this->trigger('before_get');
        $row = $this->_database->get($this->_table)->{$this->_return_type()}();
        $this->_temporary_return_type = $this->return_type;
        $row = $this->trigger('after_get', $row);
        $this->_with = [];
        return $row;
    }

    public function get_many($values) {
        $this->_database->where_in($this->primary_key, $values);
        return $this->get_all();
    }

    public function get_many_by() {
        $where = func_get_args();
        $this->_set_where($where);
        return $this->get_all();
    }

    public function get_all() {
        $this->trigger('before_get');
        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE)
            $this->_database->where($this->soft_delete_key, (bool) $this->_temporary_only_deleted);

        $result = $this->_database->get($this->_table)->{$this->_return_type(1)}();
        $this->_temporary_return_type = $this->return_type;
        foreach ($result as $key => &$row)
            $row = $this->trigger('after_get', $row, ($key == count($result) - 1));

        $this->_with = [];
        return $result;
    }

    public function insert($data, $skip_validation = FALSE) {
        if ($skip_validation === FALSE)
            $data = $this->validate($data);

        if ($data !== FALSE) {
            $data = $this->trigger('before_create', $data);
            $this->_database->insert($this->_table, $data);
            $insert_id = $this->_database->insert_id();
            $this->trigger('after_create', $insert_id);
            return $insert_id;
        } else {
            return FALSE;
        }
    }

    public function insert_many($data, $skip_validation = FALSE) {
        $ids = [];
        foreach ($data as $key => $row)
            $ids[] = $this->insert($row, $skip_validation, ($key == count($data) - 1));

        return $ids;
    }

    public function update($primary_value, $data, $skip_validation = FALSE) {
        $data = $this->trigger('before_update', $data);
        if ($skip_validation === FALSE)
            $data = $this->validate($data);

        if ($data !== FALSE) {
            $result = $this->_database->where($this->primary_key, $primary_value)->set($data)->update($this->_table);
            $this->trigger('after_update', [$data, $result]);
            return $result;
        } else {
            return FALSE;
        }
    }

    public function update_many($primary_values, $data, $skip_validation = FALSE) {
        $data = $this->trigger('before_update', $data);
        if ($skip_validation === FALSE)
            $data = $this->validate($data);

        if ($data !== FALSE) {
            $result = $this->_database->where_in($this->primary_key, $primary_values)->set($data)->update($this->_table);
            $this->trigger('after_update', [$data, $result]);
            return $result;
        } else {
            return FALSE;
        }
    }

    public function update_by() {
        $args = func_get_args();
        $data = array_pop($args);
        $data = $this->trigger('before_update', $data);
        if ($this->validate($data) !== FALSE) {
            $this->_set_where($args);
            $result = $this->_database->set($data)->update($this->_table);
            $this->trigger('after_update', [$data, $result]);
            return $result;
        } else {
            return FALSE;
        }
    }

    public function update_all($data) {
        $data = $this->trigger('before_update', $data);
        $result = $this->_database->set($data)->update($this->_table);
        $this->trigger('after_update', [$data, $result]);
        return $result;
    }

    public function delete($id) {
        $this->trigger('before_delete', $id);
        $this->_database->where($this->primary_key, $id);
        if ($this->soft_delete) {
            $result = $this->_database->update($this->_table, [$this->soft_delete_key => TRUE]);
        } else {
            $result = $this->_database->delete($this->_table);
        }
        $this->trigger('after_delete', $result);
        return $result;
    }

    public function delete_by() {
        $where = func_get_args();
        $where = $this->trigger('before_delete', $where);
        $this->_set_where($where);
        if ($this->soft_delete) {
            $result = $this->_database->update($this->_table, [$this->soft_delete_key => TRUE]);
        } else {
            $result = $this->_database->delete($this->_table);
        }
        $this->trigger('after_delete', $result);
        return $result;
    }

    public function delete_many($primary_values) {
        $primary_values = $this->trigger('before_delete', $primary_values);
        $this->_database->where_in($this->primary_key, $primary_values);
        if ($this->soft_delete) {
            $result = $this->_database->update($this->_table, [$this->soft_delete_key => TRUE]);
        } else {
            $result = $this->_database->delete($this->_table);
        }
        $this->trigger('after_delete', $result);
        return $result;
    }

    public function truncate() {
        return $this->_database->truncate($this->_table);
    }

    public function with($relationship) {
        $this->_with[] = $relationship;
        if (!in_array('relate', $this->after_get))
            $this->after_get[] = 'relate';

        return $this;
    }

    public function relate($row) {
        if (empty($row))
            return $row;

        foreach ($this->belongs_to as $key => $value) {
            if (is_string($value)) {
                $relationship = $value;
                $options = ['primary_key' => $value . '_id', 'model' => $value . '_model'];
            } else {
                $relationship = $key;
                $options = $value;
            }

            if (in_array($relationship, $this->_with)) {
                $this->load->model($options['model'], $relationship . '_model');
                if (is_object($row)) {
                    $row->{$relationship} = $this->{$relationship . '_model'}->get($row->{$options['primary_key']});
                } else {
                    $row[$relationship] = $this->{$relationship . '_model'}->get($row[$options['primary_key']]);
                }
            }
        }
        foreach ($this->has_many as $key => $value) {
            if (is_string($value)) {
                $relationship = $value;
                $options = ['primary_key' => singular($this->_table) . '_id', 'model' => singular($value) . '_model'];
            } else {
                $relationship = $key;
                $options = $value;
            }
            if (in_array($relationship, $this->_with)) {
                $this->load->model($options['model'], $relationship . '_model');
                if (is_object($row)) {
                    $row->{$relationship} = $this->{$relationship . '_model'}->get_many_by($options['primary_key'], $row->{$this->primary_key});
                } else {
                    $row[$relationship] = $this->{$relationship . '_model'}->get_many_by($options['primary_key'], $row[$this->primary_key]);
                }
            }
        }
        return $row;
    }

    public function dropdown() {
        $args = func_get_args();
        if (count($args) == 2) {
            list($key, $value) = $args;
        } else {
            $key = $this->primary_key;
            $value = $args[0];
        }
        $this->trigger('before_dropdown', [$key, $value]);
        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE)
            $this->_database->where($this->soft_delete_key, FALSE);

        $result = $this->_database->select([$key, $value])->get($this->_table)->result();
        foreach ($result as $row)
            $options[$row->{$key}] = $row->{$value};

        return $this->trigger('after_dropdown', $options);
    }

    public function multiselect() {
        $args = func_get_args();
        if (count($args) == 2) {
            list($key, $value) = $args;
        } else {
            $key = $this->primary_key;
            $value = $args[0];
        }
        $this->trigger('before_multiselect', [$key, $value]);
        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE)
            $this->_database->where($this->soft_delete_key, FALSE);

        $result = $this->_database->select([$key, $value])->get($this->_table)->result();
        foreach ($result as $row)
            $options[$row->{$key}] = $row->{$value};

        return $this->trigger('after_multiselect', $options);
    }

    public function count_by() {
        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE)
            $this->_database->where($this->soft_delete_key, (bool) $this->_temporary_only_deleted);

        $where = func_get_args();
        $this->_set_where($where);
        return $this->_database->count_all_results($this->_table);
    }

    public function count_all() {
        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE)
            $this->_database->where($this->soft_delete_key, (bool) $this->_temporary_only_deleted);

        return $this->_database->count_all($this->_table);
    }

    public function skip_validation() {
        $this->skip_validation = TRUE;
        return $this;
    }

    public function get_skip_validation() {
        return $this->skip_validation;
    }

    public function get_next_id() {
        return (int) $this->_database->select('AUTO_INCREMENT')
                        ->from('information_schema.TABLES')
                        ->where('TABLE_NAME', $this->_table)
                        ->where('TABLE_SCHEMA', $this->_database->database)->get()->row()->AUTO_INCREMENT;
    }

    public function table() {
        return $this->_table;
    }

    public function as_array() {
        $this->_temporary_return_type = 'array';
        return $this;
    }

    public function as_object() {
        $this->_temporary_return_type = 'object';
        return $this;
    }

    public function with_deleted() {
        $this->_temporary_with_deleted = TRUE;
        return $this;
    }

    public function only_deleted() {
        $this->_temporary_only_deleted = TRUE;
        return $this;
    }

    public function create_log($row) {
        if (is_object($row)) {
            $row->create_by = $this->session->userdata('username');
            $row->create_when = date('Y-m-d H:i:s');
            $row->update_by = $this->session->userdata('username');
            $row->update_when = date('Y-m-d H:i:s');
        } else {
            $row['create_by'] = $this->session->userdata('username');
            $row['create_when'] = date('Y-m-d H:i:s');
            $row['update_by'] = $this->session->userdata('username');
            $row['update_when'] = date('Y-m-d H:i:s');
        }
        return $row;
    }

    public function update_log($row) {
        if (is_object($row)) {
            $row->update_by = $this->session->userdata('username');
            $row->update_when = date('Y-m-d H:i:s');
        } else {
            $row['update_by'] = $this->session->userdata('username');
            $row['update_when'] = date('Y-m-d H:i:s');
        }
        return $row;
    }

    public function serialize($row) {
        foreach ($this->callback_parameters as $column)
            $row[$column] = serialize($row[$column]);

        return $row;
    }

    public function unserialize($row) {
        foreach ($this->callback_parameters as $column) {
            if (is_array($row)) {
                $row[$column] = unserialize($row[$column]);
            } else {
                $row->$column = unserialize($row->$column);
            }
        }
        return $row;
    }

    public function protect_attributes($row) {
        foreach ($this->protected_attributes as $attr) {
            if (is_object($row)) {
                unset($row->$attr);
            } else {
                unset($row[$attr]);
            }
        }
        return $row;
    }

    public function order_by($criteria, $order = 'ASC') {
        if (is_array($criteria)) {
            foreach ($criteria as $key => $value)
                $this->_database->order_by($key, $value);
        } else {
            $this->_database->order_by($criteria, $order);
        }
        return $this;
    }

    public function limit($limit, $offset = 0) {
        $this->_database->limit($limit, $offset);
        return $this;
    }

    public function trigger($event, $data = FALSE, $last = TRUE) {
        if (isset($this->$event) && is_array($this->$event)) {
            foreach ($this->$event as $method) {
                if (strpos($method, '(')) {
                    preg_match('/([a-zA-Z0-9\_\-]+)(\(([a-zA-Z0-9\_\-\., ]+)\))?/', $method, $matches);
                    $method = $matches[1];
                    $this->callback_parameters = explode(',', $matches[3]);
                }
                $data = call_user_func_array([$this, $method], [$data, $last]);
            }
        }
        return $data;
    }

    public function validate($data) {
        if ($this->skip_validation)
            return $data;

        if (!empty($this->validate)) {
            foreach ($data as $key => $val)
                $_POST[$key] = $val;

            $this->load->library('form_validation');
            if (is_array($this->validate)) {
                $this->form_validation->set_rules($this->validate);
                return $this->form_validation->run() === TRUE ? $data : FALSE;
            } else {
                return $this->form_validation->run($this->validate) === TRUE ? $data : FALSE;
            }
        } else {
            return $data;
        }
    }

    private function _fetch_table() {
        if ($this->_table == NULL)
            $this->_table = plural(preg_replace('/(_m|_model)?$/', '', strtolower(get_class($this))));
    }

    private function _fetch_primary_key() {
        if ($this->primary_key == NULL)
            $this->primary_key = $this->_database->query("SHOW KEYS FROM `" . $this->_table . "` WHERE Key_name = 'PRIMARY'")->row()->Column_name;
    }

    protected function _set_where($params) {
        if (count($params) == 1 && is_array($params[0])) {
            foreach ($params[0] as $field => $filter) {
                if (is_array($filter)) {
                    $this->_database->where_in($field, $filter);
                } else {
                    if (is_int($field)) {
                        $this->_database->where($filter);
                    } else {
                        $this->_database->where($field, $filter);
                    }
                }
            }
        } else if (count($params) == 1) {
            $this->_database->where($params[0]);
        } else if (count($params) == 2) {
            if (is_array($params[1])) {
                $this->_database->where_in($params[0], $params[1]);
            } else {
                $this->_database->where($params[0], $params[1]);
            }
        } else if (count($params) == 3) {
            $this->_database->where($params[0], $params[1], $params[2]);
        } else {
            if (is_array($params[1])) {
                $this->_database->where_in($params[0], $params[1]);
            } else {
                $this->_database->where($params[0], $params[1]);
            }
        }
    }

    protected function _return_type($multi = FALSE) {
        $method = ($multi) ? 'result' : 'row';
        return $this->_temporary_return_type == 'array' ? $method . '_array' : $method;
    }

}
