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
    protected $base = '';

    public function __construct() {
        parent::__construct();
        $this->base = $this->router->fetch_module() . '/' . $this->router->fetch_class();
        $this->data['recursive'] = ['menu_id','menu_parent','menu_name'];
        $this->data['form'] = [
            /*[
                'name' => 'app_id',
                'label' => 'Apps',
                'type' => 'dropdown',
                'items' => $this->apps->dropdown('app_name'),
                'rules' => 'required'
            ],*/
            [
                'name' => 'module_id',
                'label' => 'Module',
                'type' => 'dropdown',
                'items' => $this->module->dropdown('module_name'),
                'rules' => 'required'
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
                'name' => 'menu_link',
                'label' => 'Link',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required|max_length[255]'
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
                'rules' => 'required'
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

    public function create() {
        $this->data['apps_data'] = $this->apps->dropdown('app_name');

        $this->view = 'sso/menu/create';   
    }

    protected function insert() {
        $data_insert = [
            'module_id' => $this->input->post('module_id'),
            'menu_name' => $this->input->post('menu_name'),
            'menu_desc' => $this->input->post('menu_desc'),
            'menu_link' => $this->input->post('menu_link'),
            'menu_icon' => $this->input->post('menu_icon'),
            'menu_order' => $this->input->post('menu_order'),
            'menu_parent' => $this->input->post('menu_parent'),
            'menu_status' => $this->input->post('menu_status')
        ];

        if($this->validation($this->data['form'])===FALSE) {
            $this->data['apps_data'] = $this->apps->dropdown('app_name');

            $this->view = 'sso/menu/create';   
        } else {
            $this->{$this->router->fetch_class()}->insert($data_insert);
            redirect($this->base, 'refresh');
        }
    }

    public function update() {
        $this->view = 'sso/menu/update';
        $this->data['action'] = $this->base . '/edit/';
        $primary_key = $this->uri->segment(4);
        $this->data['record'] = $this->{$this->router->fetch_class()}->get($primary_key);
        $this->data['apps_data'] = $this->apps->dropdown('app_name');
        $this->data['selected_apps'] = $this->module->get($this->data['record']->module_id);
    }

    protected function edit() {
        $data_insert = [
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
        }
    }

}
