<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Menu
 *
 * @author soniibrol
 */
class Menu extends GN_Controller {

    protected $models = ['menu', 'module', 'apps'];
    protected $asides = ['modal-list-icon'];
    protected $_base = '';
    protected $_perpage = 10;
    protected $menu_parent_dropdown = [];

    public function __construct() {
        parent::__construct();
        $this->_perpage = 10;
        $this->_base = $this->router->fetch_module() . '/' . $this->router->fetch_class();
        $this->menu_parent_dropdown = $this->generate_option_recursive();
        $this->data['recursive'] = ['menu_id','menu_parent','menu_name'];
        $this->data['form'] = [
            [
                'name' => 'module_id',
                'label' => 'Module',
                'type' => 'dropdown',
                'items' => $this->module->dropdown('module_url'),
                'rules' => 'required|is_unique[menus.module_id]'
            ],
            [
                'name' => 'menu_name',
                'label' => 'Menu Name',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required|max_length[50]'
            ],
            [
                'name' => 'menu_desc',
                'label' => 'Description',
                'type' => 'textarea',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'menu_icon',
                'label' => 'Icon',
                'type' => 'icon',
                'rules' => 'max_length[255]'
            ],
            [
                'name' => 'menu_order',
                'label' => 'Order',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required|numeric'
            ],
            [
                'name' => 'menu_parent',
                'label' => 'Parent',
                'type' => 'dropdown',
                'items' => $this->menu_parent_dropdown,
                'rules' => ''
            ],
            [
                'name' => 'menu_status',
                'label' => 'Is Active?',
                'type' => 'checkbox',
                'items' => NULL,
                'rules' => NULL
            ]
        ];

        $this->data['script'] = ['list-icon-modal','sso/menu'];

    }

    private function generate_option_recursive() {
        $this->load->helper('recursive_helper');

        $menus = object_to_array($this->menu->get_all());
        $data_recursive = data_recursive($menus,'menu_id','menu_parent');
        $option_recursive = option_recursive($data_recursive,'menu_id','menu_name');

        return $option_recursive;

        //debug($this->data['parent_data']);
    }

    public function create() {
        $this->sso_new->check_access('c');
        $this->data['apps_data'] = $this->apps->dropdown('app_name');

        $this->view = 'sso/menu/create';   
    }

    protected function insert() {
        $this->sso_new->check_access('c');
        $data_insert = [
            'module_id' => $this->input->post('module_id'),
            'menu_name' => $this->input->post('menu_name'),
            'menu_desc' => $this->input->post('menu_desc'),
            'menu_icon' => $this->input->post('menu_icon'),
            'menu_order' => $this->input->post('menu_order'),
            'menu_parent' => ($this->input->post('menu_parent')!=='') ? $this->input->post('menu_parent') : 0,
            'menu_status' => $this->input->post('menu_status')
        ];

        if($this->validation($this->data['form'])===FALSE) {
            $this->data['apps_data'] = $this->apps->dropdown('app_name');

            $this->view = 'sso/menu/create';   
        } else {
            $this->{$this->router->fetch_class()}->insert($data_insert);
            redirect($this->_base, 'refresh');
        }
    }

    public function update($primary_key = 0) {
        $this->sso_new->check_access('u');
        $this->view = 'sso/menu/update';
        $this->data['action'] = $this->_base . '/edit/';
        $primary_key = $this->uri->segment(4);
        $this->data['record'] = $this->{$this->router->fetch_class()}->get($primary_key);
        $this->data['apps_data'] = $this->apps->dropdown('app_name');
        $this->data['selected_apps'] = $this->module->get($this->data['record']->module_id);
    }

    protected function edit() {
        $this->sso_new->check_access('u');
        $custom_rules = [
            [
                'name' => 'menu_name',
                'label' => 'Menu Name',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required|max_length[50]'
            ],
            [
                'name' => 'menu_desc',
                'label' => 'Description',
                'type' => 'textarea',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'menu_icon',
                'label' => 'Icon',
                'type' => 'icon',
                'rules' => 'max_length[255]'
            ],
            [
                'name' => 'menu_order',
                'label' => 'Order',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required|numeric'
            ],
            [
                'name' => 'menu_parent',
                'label' => 'Parent',
                'type' => 'dropdown',
                'items' => $this->menu->dropdown('menu_name'),
                'rules' => ''
            ],
            [
                'name' => 'menu_status',
                'label' => 'Is Active?',
                'type' => 'checkbox',
                'items' => NULL,
                'rules' => NULL
            ]
        ];

        $actual = $this->menu->get($this->input->post('menu_id'));
        if($this->input->post('module_id')!=$actual->module_id) { 
            array_push($custom_rules, 
                [
                    'name' => 'module_id',
                    'label' => 'Module',
                    'type' => 'dropdown',
                    'items' => $this->module->dropdown('module_url'),
                    'rules' => 'required|is_unique[menus.module_id]'
                ]
            );
        }

        $record = $this->menu->get($this->input->post('menu_id'));
        if (!empty($record)) {
            if($this->validation($custom_rules)===FALSE) {
                $this->view = 'sso/menu/update';
                $this->data['action'] = $this->_base . '/edit/';
                $primary_key = $this->input->post('menu_id');
                $this->data['record'] = $this->{$this->router->fetch_class()}->get($primary_key);
                $this->data['apps_data'] = $this->apps->dropdown('app_name');
                $this->data['selected_apps'] = $this->module->get($this->data['record']->module_id);
            } else {
                //debug('insert');
                $data_insert = [
                    'module_id' => $this->input->post('module_id'),
                    'menu_name' => $this->input->post('menu_name'),
                    'menu_desc' => $this->input->post('menu_desc'),
                    'menu_icon' => $this->input->post('menu_icon'),
                    'menu_order' => $this->input->post('menu_order'),
                    'menu_parent' => $this->input->post('menu_parent'),
                    'menu_status' => $this->input->post('menu_status')
                ];

                $this->{$this->router->fetch_class()}->update($record->menu_id, $data_insert);

                redirect($this->_base, 'refresh');
            }
        }

        /*$data_insert = [
            'module_id' => $this->input->post('module_id'),
            'menu_name' => $this->input->post('menu_name'),
            'menu_desc' => $this->input->post('menu_desc'),
            'menu_link' => $this->input->post('menu_link'),
            'menu_icon' => $this->input->post('menu_icon'),
            'menu_order' => $this->input->post('menu_order'),
            'menu_parent' => $this->input->post('menu_parent'),
            'menu_status' => $this->input->post('menu_status')
        ];
        $record = $this->{$this->router->fetch_class()}->get($this->input->post('menu_id'));
        if (!empty($record)) {
            if($this->validation($this->data['form'])===FALSE) {
                $this->view = 'sso/menu/update';
                $this->data['action'] = $this->base . '/edit/';
                $primary_key = $this->input->post('menu_id');
                $this->data['record'] = $this->{$this->router->fetch_class()}->get($primary_key);
                $this->data['apps_data'] = $this->apps->dropdown('app_name');
                $this->data['selected_apps'] = $this->module->get($this->data['record']->module_id);
            } else {
                $this->{$this->router->fetch_class()}->update($record->menu_id, $data_insert);
                redirect($this->base, 'refresh');
            }
        }*/
    }

}
