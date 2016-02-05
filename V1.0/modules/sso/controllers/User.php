<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Users
 *
 * @author soniibrol
 */
class User extends GN_Controller {
    protected $models = ['user'];
    protected $helpers = [];

    public function __construct() {
        parent::__construct();
        $this->data['form'] = [
            [
                'name' => 'user_name',
                'label' => 'Username',
                'type' => 'input',
                'rules' => 'required|max_length[50]|is_unique[users.user_name]'
            ],
            /*[
                'name' => 'user_password',
                'label' => 'Password',
                'type' => 'password',
                'rules' => 'required|min[8]|max[50]'
            ],*/
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

        $this->data['style'] = [];
        $this->data['script'] = ['jquery.inputmask','jquery.inputmask.date.extensions','jquery.inputmask.extensions'];
    }

    /*public function index() {
        debug($this->data);
    }*/

    /*protected function insert() {
        if($this->validation($this->data['form'])===FALSE){
            $this->view = 'layouts/AdminLTE/form';
            $this->data['action'] = $this->router->fetch_module() . '/' . $this->router->fetch_class() . '/insert/';
        }else{
            $this->user->insert($this->input->post());
            redirect('sso/user');
        }
    }*/
   
}
