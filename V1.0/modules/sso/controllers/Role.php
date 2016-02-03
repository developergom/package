<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Role
 *
 * @author soniibrol
 */
class Role extends GN_Controller {

    protected $models = ['role'];
    protected $helpers = [];

    public function __construct() {
        parent::__construct();
        //$this->data['id'] = $this->role->primary_key;
        $this->data['form'] = [
            [
                'name' => 'role_name',
                'label' => 'Role Name',
                'type' => 'input',
                'rules' => 'required|max[100]'
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
        
        $this->data['style'] = ['datepicker3'];
        $this->data['script'] = ['jquery.inputmask.extensions', 'jquery.inputmask.date.extensions', 'bootstrap-datepicker'];
        $this->data['datagrid_header'] = ['Role Name', 'Description', 'Status'];
    }

}
