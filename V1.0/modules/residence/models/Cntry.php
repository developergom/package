<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Cntry
 *
 * @author nanank
 */
class Cntry extends GN_Model {

    public $_db_group = 'RESIDENCE';
    public $_table = 'Cntry';
    public $primary_key = 'cid';
    public $has_many = [
        'Prvnc' => [
            'model' => 'Prvnc',
            'primary_key' => 'pid'
        ]
    ];
    public $protected_attributes = [];
    public $validate = [
        [
            'field' => '',
            'label' => '',
            'rules' => 'required|valid_email|is_unique[users.email]'
        ]
    ];

    public function __construct() {
        parent::__construct();
    }

}
