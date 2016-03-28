<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Test1
 *
 * @author nanank
 */
class Test1 extends GN_Model {

    public $table = 'rl';
    public $primary_key = 'rid';

    public function __construct() {
        parent::__construct();
        $this->field = [
            'rid' => [
                'type' => 'INT',
                'show' => TRUE,
                'label' => NULL,
                'form' => 'hidden',
                'rules' => 'required'
            ],
            'rnme' => [
                'type' => 'STRING',
                'show' => TRUE,
                'label' => 'Name',
                'form' => 'input',
                'rules' => 'required'
            ],
            'rdesc' => [
                'type' => 'STRING',
                'show' => TRUE,
                'label' => 'Description',
                'form' => 'input',
                'rules' => 'required' //exact_length[8]
            ],
            'rstat' => [
                'type' => 'BOOLEAN',
                'show' => TRUE,
                'label' => 'Status',
                'form' => 'checkbox',
                'rules' => 'is_natural'
            ]
        ];
    }

}
