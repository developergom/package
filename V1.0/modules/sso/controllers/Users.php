<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Users
 *
 * @author nanank
 */
class Users extends GN_Controller {
    protected $models = ['user'];

    public function __construct() {
        parent::__construct();
        $this->data['id'] = $this->item_type->primary_key;
        $this->data['form'] = [
            [
                'name' => 'user_name',
                'label' => 'Username',
                'type' => 'input',
                'rules' => 'required|max[50]|is_unique[users.user_name]'
            ],
            [
                'name' => 'user_password',
                'label' => 'Password',
                'type' => 'password',
                'rules' => 'required|min[8]|max[50]'
            ],
            [
                'name' => 'user_firstname',
                'label' => 'First Name',
                'type' => 'input',
                'rules' => 'required|max[50]'
            ],
            [
                'name' => 'user_last',
                'label' => 'Last Name',
                'type' => 'input',
                'rules' => 'max[50]'
            ],
            [
                'name' => 'user_email',
                'label' => 'Email',
                'type' => 'email',
                'rules' => 'required|max[100]'
            ],
            [
                'name' => 'user_phone',
                'label' => 'Phone',
                'type' => 'input',
                'rules' => 'max[15]'
            ],
            [
                'name' => 'user_birthdate',
                'label' => 'Birth Date',
                'type' => 'date',
                'rules' => ''
            ],
            [
                'name' => 'user_status',
                'label' => 'Is Acitve?',
                'type' => 'checkbox',
                'rules' => NULL
            ]
        ];
    }

   
}
