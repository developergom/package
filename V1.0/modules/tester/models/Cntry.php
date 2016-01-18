<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Test
 *
 * @author nanank
 */
class Cntry extends GN_Model {

    public $connection = 'RESIDENCE';
    public $table = 'cntry';
    public $primary_key = 'cid';
    //public $sort_order = 'mid ASC';
    //public $recursive = ['mpar', 'mnme'];

    public function __construct() {
        parent::__construct();
        $this->field = [
            'cid' => [
                'type' => 'INT',
                'show' => TRUE,
                'label' => NULL,
                'form' => 'hidden',
                'rules' => 'required|is_unique'
            ],
            'ccd' => [
                'type' => 'STRING',
                'show' => TRUE,
                'label' => 'Code',
                'form' => 'input',
                'rules' => 'required'
            ],
            'cnm' => [
                'type' => 'STRING',
                'show' => TRUE,
                'label' => 'Name',
                'form' => 'input',
                'rules' => 'required'
            ],
            'ciso3cd' => [
                'type' => 'STRING',
                'show' => TRUE,
                'label' => 'ISO3 Code',
                'form' => 'input',
                'rules' => 'required'
            ],
            'cncd' => [
                'type' => 'STRING',
                'show' => TRUE,
                'label' => 'Code',
                'form' => 'input',
                'rules' => 'required|numeric'
            ]
        ];
    }

}
