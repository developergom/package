<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Module
 *
 * @author soniibrol
 */
class Module extends GN_Controller {

    protected $models = ['module', 'action'];
    protected $_base = '';

    public function __construct() {
        parent::__construct();
        $this->_base = $this->router->fetch_module() . '/' . $this->router->fetch_class();
        $this->data['form'] = [
            [
                'name' => 'module_id',
                'label' => 'Module ID',
                'type' => 'input',
                'rules' => 'required|max_length[255]|is_unique[modules.module_id]'
            ],
            [
                'name' => 'module_name',
                'label' => 'Modules',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required|max_length[50]'
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

    }

    protected function insert() {
        if($this->validation($this->data['form'])===FALSE) {
            $this->view = 'layouts/AdminLTE/form';
            $this->data['action'] = $this->_base . '/insert/'; 
        } else {
            debug($this->input->post());

            $data_user = [
                'user_name' => $this->input->post('user_name'),
                'user_firstname' => $this->input->post('user_firstname'),
                'user_lastname' => $this->input->post('user_lastname'),
                'user_email' => $this->input->post('user_email'),
                'user_phone' => $this->input->post('user_phone'),
                'user_birthdate' => $this->input->post('user_birthdate'),
                'user_status' => $this->input->post('user_status')
            ];

            $insert_id = $this->{$this->router->fetch_class()}->insert($data_user);

            if(count($this->input->post('role_id')) > 0) {
                $data_user_role = [];
                foreach($this->input->post('role_id') as $k => $v) {
                    $data_user_role[$k] = [
                        'user_id' => $insert_id,
                        'role_id' => $v
                    ];
                }

                $this->user_role->insert_many($data_user_role);
            }

            redirect($this->_base, 'refresh');
        }
    }

    public function api_all() {
        $this->view = FALSE;
        $tmp = $this->module->get_all();

        echo json_encode($tmp);
    }

}
