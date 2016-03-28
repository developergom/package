<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Role
 *
 * @author soniibrol
 */
class Role extends GN_Controller {

    protected $models = ['role', 'menu', 'action', 'module', 'role_module'];
    protected $helpers = [];
    protected $return_type = 'array';
    protected $_base = '';
    protected $_primary_key = 'role_id';
    protected $_perpage = 5;

    public function __construct() {
        parent::__construct();
        $this->_base = $this->router->fetch_module() . '/' . $this->router->fetch_class();
        $this->data['form'] = [
            [
                'name' => 'role_name',
                'label' => 'Role Name',
                'type' => 'input',
                'rules' => 'required|max_length[100]'
            ],
            [
                'name' => 'role_desc',
                'label' => 'Description',
                'type' => 'textarea',
                'rules' => NULL
            ],
            [
                'name' => 'role_status',
                'label' => 'Is Active?',
                'type' => 'checkbox',
                'rules' => NULL
            ]
        ];

        $this->data['script'] = ['sso/role'];
    }

    public function create() {
        $this->sso_new->check_access('c');
        $this->load->helper('recursive');

        $recursive = data_recursive(object_to_array($this->menu->get_all()), 'menu_id', 'menu_parent');
        $this->data['menu'] = datagrid_recursive($recursive, 'menu_name');
        foreach ($this->data['menu'] as $row => $val) {
            $this->data['menu'][$row]['_action'] = [];
            $module = object_to_array($this->module->get($val['module_id']));
            foreach (unserialize($module['module_action']) as $k => $v) {
                $act = object_to_array($this->action->get($v));
                array_push($this->data['menu'][$row]['_action'], $v);
            }
        }
        $this->data['action'] = object_to_array($this->action->get_all());

        $this->view = 'sso/role/create';
    }

    protected function insert() {
        $this->sso_new->check_access('c');
        if ($this->validation($this->data['form']) === FALSE) {
            $this->view = 'layouts/AdminLTE/form';
            $this->data['action'] = $this->_base . '/insert/';
        } else {
            $data_role = [
                'role_name' => $this->input->post('role_name'),
                'role_desc' => $this->input->post('role_desc'),
                'role_status' => $this->input->post('role_status')
            ];

            $insert_id = $this->{$this->router->fetch_class()}->insert($data_role);

            $this->insert_role_module($insert_id);

            redirect($this->_base, 'refresh');
        }
    }

    public function update($primary_key = 0) {
        $this->sso_new->check_access('u');
        $this->load->helper('recursive');

        $recursive = data_recursive(object_to_array($this->menu->get_all()), 'menu_id', 'menu_parent');
        $this->data['menu'] = datagrid_recursive($recursive, 'menu_name');
        foreach ($this->data['menu'] as $row => $val) {
            $this->data['menu'][$row]['_action'] = [];
            $module = object_to_array($this->module->get($val['module_id']));
            foreach (unserialize($module['module_action']) as $k => $v) {
                $act = object_to_array($this->action->get($v));
                array_push($this->data['menu'][$row]['_action'], $v);
            }

            //looping untuk access_key
            $role_module = object_to_array($this->role_module->get_many_by(['role_id' => $this->uri->segment(4), 'module_id' => $val['module_id']]));
            foreach ($role_module as $key => $value)
                $this->data['menu'][$row]['_access_key'] = unserialize($value['access_key']);
        }

        $this->data['actions'] = object_to_array($this->action->get_all());

        $this->view = 'sso/role/update';
        $this->data['action'] = $this->_base . '/edit/';
        $primary_key = $this->uri->segment(4);
        $this->data['record'] = $this->role->get($primary_key);
    }

    protected function edit() {
        $this->sso_new->check_access('u');
        $record = $this->{$this->router->fetch_class()}->get($this->input->post($this->_primary_key));
        if (!empty($record)) {
            if ($this->validation($this->data['form']) === FALSE) {
                $this->view = 'layouts/AdminLTE/form';
                $this->data['action'] = $this->_base . '/edit/';
                $primary_key = $this->uri->segment(4);
                $this->data['record'] = $this->{$this->router->fetch_class()}->get($primary_key);
            } else {
                $data_role = [
                    'role_name' => $this->input->post('role_name'),
                    'role_desc' => $this->input->post('role_desc'),
                    'role_status' => $this->input->post('role_status')
                ];
                $this->{$this->router->fetch_class()}->update($record->{$this->_primary_key}, $data_role);

                $this->role_module->delete_by("role_id = " . $this->input->post($this->_primary_key) . "");

                $this->insert_role_module($record->{$this->_primary_key});

                redirect($this->_base, 'refresh');
            }
        }
    }

    protected function insert_role_module($role_id) {
        $modules = object_to_array($this->module->get_all());
        foreach ($modules as $key => $value) {
            $access_key = [];
            $action = unserialize($value['module_action']);
            foreach ($action as $k => $v) {
                if (isset($_POST['action_' . $value['module_id'] . '_' . $v]))
                    array_push($access_key, $v);
            }

            $data_role_module = [
                'role_id' => $role_id,
                'module_id' => $value['module_id'],
                'access_key' => serialize($access_key)
            ];
            $this->role_module->insert($data_role_module);
        }
    }

}
