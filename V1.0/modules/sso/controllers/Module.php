<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Module
 *
 * @author soniibrol
 */
class Module extends GN_Controller {

    protected $models = ['module', 'action','apps'];
    protected $_base = '';
    protected $_primary_key = '';
    protected $_perpage = 5;

    public function __construct() {
        parent::__construct();
        $this->_base = $this->router->fetch_module() . '/' . $this->router->fetch_class();
        $this->_primary_key = 'module_id';
        $this->data['form'] = [
            [
                'name' => 'module_url',
                'label' => 'URL',
                'type' => 'input',
                'rules' => 'required|max_length[255]|is_unique[modules.module_url]|alpha_dash'
            ],
            [
                'name' => 'app_id',
                'label' => 'Apps Name',
                'type' => 'dropdown',
                'items' => $this->apps->dropdown('app_name'),
                'rules' => 'required'
            ],
            [
                'name' => 'module_desc',
                'label' => 'Description',
                'type' => 'textarea',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'module_status',
                'label' => 'Is Active?',
                'type' => 'checkbox',
                'items' => NULL,
                'rules' => NULL
            ],
            [
                'name' => 'module_action[]',
                'label' => 'Action',
                'type' => 'multiselect',
                'items' => $this->action->multiselect('action_name'),
                'rules' => 'required'
            ]
        ];

    }

    public function index() {
        $this->load->library(['pagination', 'table']);
        $page = !empty($this->uri->segment(4)) ? $this->_perpage * ($this->uri->segment(4) - 1) : 0;
        $config['base_url'] = base_url($this->_base . '/index/');
        $config['total_rows'] = $this->{$this->router->fetch_class()}->count_all();
        $this->_set_datagrid_header(isset($this->data['recursive']) ? $this->data['recursive'][1] : NULL);
        $unshift = [$this->_primary_key => 'Primary Key'] + $this->data['datagrid_header'];
        $items = $this->_get_items();
        
        $this->module->order_by($this->_primary_key, 'ASC');
        $this->module->limit($this->_perpage, $page);
        foreach ($this->module->get_all() as $index => $row) {
            $row = object_to_array($row);
            foreach ($row as $k => $v) {
                if (!empty($items) && array_key_exists($k, $items)){
                    $row[$k] = empty($v) ? $v : $items[$k][$v];
                }
            }

            $row['module_action[]'] = '';
            if(@unserialize($row['module_action']) !== false) {
                $module_action = unserialize($row['module_action']);
                foreach($module_action as $key => $value) {
                    $action = $this->action->get($value);
                    $row['module_action[]'] .= '<span class="label label-info">' . $action->action_name . '</span> ';
                }
            }else{
                $row['module_action[]'] = '';
            }

            $row = array_intersect_key($row, $unshift);
            $this->data['datagrid'][$index] = array_to_object($row);
        }

        $this->pagination->initialize($config);
        $this->data['links'] = $this->pagination->create_links();
    }

    private function _get_items() {
        $array = [];
        foreach ($this->data['form'] as $field) {
            if (!empty($field['items']))
                $array[$field['name']] = $field['items'];
        }

        return $array;
    }

    protected function insert() {
        if($this->validation($this->data['form'])===FALSE) {
            $this->view = 'layouts/AdminLTE/form';
            $this->data['action'] = $this->_base . '/insert/'; 
        } else {
            $data_module = [
                'module_url' => $this->input->post('module_url'),
                'app_id' => $this->input->post('app_id'),
                'module_action' => serialize($this->input->post('module_action')),
                'module_desc' => $this->input->post('module_desc'),
                'module_status' => $this->input->post('module_status')
            ];

            $this->{$this->router->fetch_class()}->insert($data_module);

            redirect($this->_base, 'refresh');
        }
    }

    public function update() {
        $this->view = 'layouts/AdminLTE/form';
        $this->data['action'] = $this->_base . '/edit/';
        $primary_key = $this->uri->segment(4);
        $this->data['record'] = $this->{$this->router->fetch_class()}->get($primary_key);
        
        if(@unserialize($this->data['record']->module_action) !== false) {
            $module_action = unserialize($this->data['record']->module_action);
            foreach($module_action as $key => $value)
                $this->data['record']->{'module_action[]'}[] = $value;
        }else{
            $this->data['record']->{'module_action[]'}[] = [];
        }
    }

    public function edit() {
        $custom_rules = [
            [
                'name' => 'module_url',
                'label' => 'Module URL',
                'type' => 'input',
                'rules' => 'required|max_length[255]|alpha_dash'
            ],
            [
                'name' => 'app_id',
                'label' => 'App Name',
                'type' => 'dropdown',
                'items' => $this->apps->dropdown('app_name'),
                'rules' => 'required'
            ],
            [
                'name' => 'module_action[]',
                'label' => 'Action',
                'type' => 'multiselect',
                'items' => $this->action->multiselect('action_name'),
                'rules' => 'required'
            ],
            [
                'name' => 'module_desc',
                'label' => 'Description',
                'type' => 'textarea',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'module_status',
                'label' => 'Is Active?',
                'type' => 'checkbox',
                'items' => NULL,
                'rules' => NULL
            ]
        ];

        $actual = $this->module->get($this->input->post('module_id'));
        if($this->input->post('module_url')!==$actual->module_url) { 
            array_push($custom_rules, 
                [
                    'name' => 'module_url',
                    'label' => 'Module URL',
                    'type' => 'input',
                    'rules' => 'required|max_length[255]|is_unique[modules.module_url]|alpha_dash'
                ]
            );
        }

        $record = $this->module->get($this->input->post('module_id'));
        if (!empty($record)) {
            if($this->validation($custom_rules)===FALSE) {
                redirect($this->_base . '/update/' . $this->input->post('module_id'));
            } else {
                $data_module = [
                    'module_url' => $this->input->post('module_url'),
                    'app_id' => $this->input->post('app_id'),
                    'module_action' => serialize($this->input->post('module_action')),
                    'module_desc' => $this->input->post('module_desc'),
                    'module_status' => $this->input->post('module_status')
                ];

                $this->module->update($record->{$this->module->primary_key}, $data_module, TRUE);

                redirect($this->_base, 'refresh');
            }
        }
    }

    public function api_all() {
        $this->view = FALSE;
        $tmp = $this->module->get_all();

        echo json_encode($tmp);
    }

}
