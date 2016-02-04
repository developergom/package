<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Menu
 *
 * @author soniibrol
 */
class Menu extends GN_Controller {

    protected $models = ['menu', 'module','apps'];
    protected $asides = ['modal-list-icon'];

    public function __construct() {
        parent::__construct();
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
                'rules' => 'required|max[50]'
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
                'rules' => 'required|max[255]'
            ],
            [
                'name' => 'menu_icon',
                'label' => 'Icon',
                'type' => 'icon',
                'rules' => 'max[255]'
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

        $this->data['script'] = ['list-icon-modal'];

    }

}
