<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Action
 *
 * @author soniibrol
 */
class Action extends GN_Controller {

    protected $models = ['action'];
    protected $helpers = [];

    public function __construct() {
        parent::__construct();
        $this->data['form'] = [
            [
                'name' => 'action_name',
                'label' => 'Action Name',
                'type' => 'input',
                'rules' => 'required|max[100]'
            ],
            [
                'name' => 'action_alias',
                'label' => 'Alias',
                'type' => 'input',
                'rules' => 'required|max[50]|is_unique[actions.action_alias]'
            ],
            [
                'name' => 'action_desc',
                'label' => 'Description',
                'type' => 'textarea',
                'rules' => 'required'
            ],
            [
                'name' => 'action_status',
                'label' => 'Is Active?',
                'type' => 'checkbox',
                'rules' => NULL
            ]
        ];
        
        $this->data['style'] = [];
        $this->data['script'] = [];
        $this->data['datagrid_header'] = ['Action Name', 'Alias', 'Description', 'Status'];
    }

}
