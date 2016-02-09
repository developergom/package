<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Module
 *
 * @author soniibrol
 */
class Module extends GN_Controller {

    protected $models = ['module', 'apps'];

    public function __construct() {
        parent::__construct();
        $this->data['form'] = [
            [
                'name' => 'app_id',
                'label' => 'Apps',
                'type' => 'dropdown',
                'items' => $this->apps->dropdown('app_name'),
                'rules' => 'required'
            ],
            [
                'name' => 'module_name',
                'label' => 'Modules',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required|max_length[50]'
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

    }

    public function api_all() {
        $this->view = FALSE;
        $tmp = $this->module->get_all();

        echo json_encode($tmp);
    }

}
