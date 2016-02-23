<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Module_model
 *
 * @author soniibrol
 */
class User_model extends GN_Model {
    
    public $_db_group = 'SSO';
    public $primary_key = 'user_id';
    public $protected_attributes = ['user_id'];
    public $before_create = ['create_log','set_password','set_avatar'];
    public $before_update = ['update_log'];
    public $has_many = ['user_role' =>
        [
            'model' => 'user_role_model',
            'primary_key' => 'user_id'
        ]
    ];
    public $validate = [
        [
            'field' => 'user_name',
            'label' => 'Username',
            'rules' => 'required|max_length[50]|is_unique[users.user_name]'
        ],
        [
            'field' => 'user_firstname',
            'label' => 'First Name',
            'rules' => 'required|max_length[50]'
        ],
        [
            'field' => 'user_lastname',
            'label' => 'Last Name',
            'rules' => 'max_length[50]'
        ],
        [
            'field' => 'user_email',
            'label' => 'Email',
            'rules' => 'required|max_length[100]'
        ],
        [
            'field' => 'user_phone',
            'label' => 'Phone',
            'rules' => 'max_length[15]'
        ]
    ];

    
    public function __construct() {
        parent::__construct();
    }

    private function set_password($user) {
        $this->load->library('encrypt');
        $user['user_password'] = $this->encrypt->encode('password');
        return $user;
    }

    private function set_avatar() {
        $user['user_avatar'] = 'default.jpg';
    }
}
