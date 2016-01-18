<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of User_model
 *
 * @author nanank
 */
class User_model extends GN_Model {

    //public $_table = 'users';
    public $primary_key = 'user_id';
    public $has_many = [
        'Url' => [
            'model' => 'Url',
            'primary_key' => 'uid'
        ]
    ];
    //public $protected_attributes = ['upp'];
    public $validate = [
        [
            'field' => 'umail',
            'label' => 'Email',
            'rules' => 'required|valid_email|is_unique[users.email]'
        ]
    ];
    protected $soft_delete = TRUE;
    protected $soft_delete_key = 'user_status';

    public function __construct() {
        parent::__construct();
    }

}
