<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of GN_Model
 *
 * @author nanank
 */
class GN_Controller extends CI_Controller {

    protected $view = NULL;
    protected $data = [];
    protected $layout;
    protected $asides = [];
    protected $models = [];
    protected $model_string = '%_model';
    protected $helpers = [];
    protected $alias = [];
    private $_base;
    private $_primary_key;

    public function __construct() {
        parent::__construct();

        $this->_load_models();
        $this->_load_helpers();

        $this->_base = $this->router->fetch_module() . '/' . $this->router->fetch_class();
        $this->_primary_key = $this->{$this->router->fetch_class()}->primary_key;

        $this->data['id'] = $this->_primary_key;
        $this->data['title'] = strlen($this->router->fetch_class()) > 3 ? humanize($this->router->fetch_class()) : strtoupper($this->router->fetch_class());
        $this->data['base'] = $this->_base;
        $this->data['breadcrumb'] = [
            '<i class="fa fa-home"></i> Home',
            strlen($this->router->fetch_module()) > 3 ? humanize($this->router->fetch_module()) : strtoupper($this->router->fetch_module()),
            strlen($this->router->fetch_class()) > 3 ? humanize($this->router->fetch_class()) : strtoupper($this->router->fetch_class())
        ];
    }

    public function _remap($method) {
        if (method_exists($this, $method)) {
            call_user_func_array([$this, $method], array_slice($this->uri->rsegments, 2));
        } else {
            if (method_exists($this, '_404')) {
                call_user_func_array([$this, '_404'], [$method]);
            } else {
                show_404(strtolower(get_class($this)) . '/' . $method);
            }
        }
        $this->_load_view();
    }

    protected function _load_view() {
        if ($this->view !== FALSE) {
            $view = (!empty($this->view)) ? $this->view : 'layouts/AdminLTE/base';
            $data['yield'] = $this->load->view($view, $this->data, TRUE);
            if (!empty($this->asides)) {
                foreach ($this->asides as $name => $file)
                    $data['asides'] = $this->load->view($file, $this->data, TRUE);
            }
            $data = array_merge($this->data, $data);
            $layout = FALSE;
            if (!isset($this->layout)) {
                if (file_exists(APPPATH . 'views/layouts/' . $this->router->class . '.php')) {
                    $layout = 'layouts/' . $this->router->class;
                } else {
                    $layout = 'layouts/AdminLTE/application';
                }
            } else if ($this->layout !== FALSE) {
                $layout = $this->layout;
            }

            if ($layout == FALSE) {
                $this->output->set_output($data['yield']);
            } else {
                $this->load->view($layout, $data);
            }
        }
    }

    private function _load_models() {
        foreach ($this->models as $model)
            $this->load->model($this->_model_name($model), $model);
    }

    protected function _model_name($model) {
        return str_replace('%', $model, $this->model_string);
    }

    private function _load_helpers() {
        foreach ($this->helpers as $helper)
            $this->load->helper($helper);
    }

    protected function index() {
        $this->load->library(['pagination', 'table']);
        $config['base_url'] = base_url($this->_base . '/index/');
        $config['total_rows'] = $this->{$this->router->fetch_class()}->count_all();
        $this->pagination->initialize($config);

        $this->{$this->router->fetch_class()}->order_by($this->_primary_key, 'ASC');
        $this->{$this->router->fetch_class()}->limit(5, !empty($this->uri->segment(4)) ? 5 * ($this->uri->segment(4) - 1) : 0);

        $items = $this->_get_items();
        foreach ($this->{$this->router->fetch_class()}->get_all() as $index => $row) {
            $row = object_to_array($row);
            foreach ($row as $k => $v) {
                if (!empty($items) && array_key_exists($k, $items)) {
                    $row[$k] = $items[$k][$v];
                }
            }

            $row = array_intersect_key($row, $this->_selected_field());
            $this->data['datagrid'][$index] = array_to_object($row);
        }

        $this->data['links'] = $this->pagination->create_links();
        foreach ($this->data['form'] as $head)
            $this->data['datagrid_header'][$head['name']] = $head['label'];
    }

    private function _selected_field() {
        $array[$this->_primary_key] = 'Primary Key';
        if (empty($this->data['form']))
            return $array;

        foreach ($this->data['form'] as $field) {
            $array[$field['name']] = $field['label'];
        }

        return $array;
    }

    private function _get_items() {
        $array = [];
        foreach ($this->data['form'] as $field) {
            if (!empty($field['items']))
                $array[$field['name']] = $field['items'];
        }

        return $array;
    }

    protected function create() {
        $this->view = 'layouts/AdminLTE/form';
        $this->data['action'] = $this->_base . '/insert/';
    }

    protected function insert() {
        $this->{$this->router->fetch_class()}->insert($this->input->post());
        redirect($this->_base, 'refresh');
    }

    protected function update() {
        $this->view = 'layouts/AdminLTE/form';
        $this->data['action'] = $this->_base . '/edit/';
        $primary_key = $this->uri->segment(4);
        $this->data['record'] = $this->{$this->router->fetch_class()}->get($primary_key);
    }

    protected function edit() {
        $record = $this->{$this->router->fetch_class()}->get($this->input->post($this->_primary_key));
        if (!empty($record)) {
            $this->{$this->router->fetch_class()}->update($record->{$this->_primary_key}, $this->input->post());
            redirect($this->_base, 'refresh');
        }
    }

    protected function delete() {
        $primary_key = $this->uri->segment(4);
        $this->{$this->router->fetch_class()}->delete($primary_key);
        redirect($this->_base, 'refresh');
    }

}
