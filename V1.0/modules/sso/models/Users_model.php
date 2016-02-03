<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of User_model
 *
 * @author nanank
 */
class Users_model extends GN_Model {

    //public $_table = 'users';
    public $primary_key = 'user_id';
    /*public $has_many = [
        'Url' => [
            'model' => 'Url',
            'primary_key' => 'uid'
        ]
    ];*/
    public $validate = [
        [
            'field' => 'user_name',
            'label' => 'Username',
            'rules' => 'required|is_unique[users.user_name]'
        ],
        [
            'field' => 'user_fullname',
            'label' => 'Fullname',
            'rules' => 'required|max_length[50]'
        ],
        [
            'field' => 'user_email',
            'label' => 'Email',
            'rules' => 'required|valid_email|max_length[50]'
        ]
    ];
    protected $soft_delete = TRUE;
    protected $soft_delete_key = 'user_status';

    public function __construct() {
        parent::__construct();
    }

}
