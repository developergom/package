<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Role
 *
 * @author soniibrol
 */
class Role extends GN_Controller {

    protected $models = ['role','menu','action'];
    protected $helpers = [];
    protected $return_type = 'array';

    public function __construct() {
        parent::__construct();
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
    }

    public function create() {
        $this->load->helper('recursive');
        $this->menu->as_array();

        $recursive = data_recursive($this->menu->get_all(),'menu_id','menu_parent');
        $this->data['menu'] = datagrid_recursive($recursive,'menu_name');
        $this->action->as_array();
        $this->data['action'] = $this->action->get_all();
        
        $this->view = 'sso/role/create';   
    }

}
