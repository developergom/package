<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Usr
 *
 * @author nanank
 */
class Usr extends GN_Model {
    
    public $primary_key = 'uid';
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
    
    public function __construct() {
        parent::__construct();
    }
    
}