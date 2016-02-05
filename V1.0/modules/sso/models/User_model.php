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
    public $before_create = ['create_log','set_password'];
    public $before_update = ['update_log'];
    protected $soft_delete = TRUE;
    //protected $_temporary_with_deleted = TRUE;
    //protected $_temporary_only_deleted = TRUE;
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

    public function set_password($user) {
        $this->load->library('encryption');
        $user['user_password'] = $this->encryption->encrypt('password');
        return $user;
    }
}
