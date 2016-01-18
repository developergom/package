<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Rl
 *
 * @author nanank
 */
class Rl extends GN_Model {
    
    public $primary_key = 'rid';
    public $has_many = [
        'Url' => [
            'model' => 'Url',
            'primary_key' => 'rid'
        ]
    ];
    
    public function __construct() {
        parent::__construct();
    }
    
}