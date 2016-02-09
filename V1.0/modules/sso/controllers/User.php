<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Users
 *
 * @author soniibrol
 */
class User extends GN_Controller {
    protected $models = ['user','role'];
    protected $helpers = [];

    public function __construct() {
        parent::__construct();
        //debug($this->role->dropdown('role_name'));
        $this->data['form'] = [
            [
                'name' => 'user_name',
                'label' => 'Username',
                'type' => 'input',
                'rules' => 'required|max_length[50]|is_unique[users.user_name]'
            ],
            [
                'name' => 'user_firstname',
                'label' => 'First Name',
                'type' => 'input',
                'rules' => 'required|max_length[50]'
            ],
            [
                'name' => 'user_lastname',
                'label' => 'Last Name',
                'type' => 'input',
                'rules' => 'max_length[50]'
            ],
            [
                'name' => 'user_email',
                'label' => 'Email',
                'type' => 'email',
                'rules' => 'required|max_length[100]'
            ],
            [
                'name' => 'user_phone',
                'label' => 'Phone',
                'type' => 'input',
                'rules' => 'max_length[15]'
            ],
            [
                'name' => 'user_birthdate',
                'label' => 'Birth Date',
                'type' => 'date',
                'rules' => ''
            ],
            [
                'name' => 'role_id',
                'label' => 'Role(s)',
                'type' => 'multiselect',
                'items' => $this->role->multiselect('role_name'),
                'rules' => NULL
            ],
            [
                'name' => 'user_status',
                'label' => 'Is Active?',
                'type' => 'checkbox',
                'rules' => NULL
            ]
        ];

        $this->data['style'] = [];
        $this->data['script'] = ['jquery.inputmask','jquery.inputmask.date.extensions','jquery.inputmask.extensions'];
    }

    protected function edit() {
        $custom_rules = [
            [
                'name' => 'user_firstname',
                'label' => 'First Name',
                'type' => 'input',
                'rules' => 'required|max_length[50]'
            ],
            [
                'name' => 'user_lastname',
                'label' => 'Last Name',
                'type' => 'input',
                'rules' => 'max_length[50]'
            ],
            [
                'name' => 'user_email',
                'label' => 'Email',
                'type' => 'email',
                'rules' => 'required|max_length[100]'
            ],
            [
                'name' => 'user_phone',
                'label' => 'Phone',
                'type' => 'input',
                'rules' => 'max_length[15]'
            ],
            [
                'name' => 'user_birthdate',
                'label' => 'Birth Date',
                'type' => 'date',
                'rules' => ''
            ],
            [
                'name' => 'user_status',
                'label' => 'Is Active?',
                'type' => 'checkbox',
                'rules' => NULL
            ]
        ];
        $custom_base = $this->router->fetch_module() . '/' . $this->router->fetch_class();

        $actual = $this->user->get($this->input->post('user_id'));
        if($this->input->post('user_name')!==$actual->user_name) { 
            array_push($custom_rules, 
                [
                    'name' => 'user_name',
                    'label' => 'Username',
                    'type' => 'input',
                    'rules' => 'required|max_length[50]|is_unique[users.user_name]'
                ]
            );
        }

        $record = $this->user->get($this->input->post('user_id'));
        if (!empty($record)) {
            if($this->validation($custom_rules)===FALSE) {
                redirect($custom_base . '/update/' . $this->input->post('user_id'));
            } else {
                $this->user->update($record->{$this->user->primary_key}, $this->input->post(), TRUE);
                redirect($custom_base, 'refresh');
            }
        }
    }
   
}
