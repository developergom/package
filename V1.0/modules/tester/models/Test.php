<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Test
 *
 * @author nanank
 */
class Test extends CI_Model {

    public $attribute = [];

    public function __construct() {
        parent::__construct();
        //$this->attribute['connection'] = '';
        //$this->attribute['grid'] = 'SIMPLE'; // SIMPLE|DEFAULT|DATAGRID
        //$this->attribute['recursive'] = [];
        $this->attribute['table'] = 'usr';
        $this->attribute['field'] = [
            'uid' => [
                'is_primary' => TRUE,
                'type' => 'INT',
                'show' => FALSE,
                'label' => 'User ID',
                'form' => 'hidden',
                'rules' => 'required|is_unique'
            ],
            'unme' => [
                'is_primary' => FALSE,
                'type' => 'STRING',
                'show' => TRUE,
                'label' => 'Username',
                'form' => 'input',
                'rules' => 'required'
            ],
            'upass' => [
                'is_primary' => FALSE,
                'type' => 'STRING',
                'show' => FALSE,
                'label' => 'Password',
                'form' => 'password',
                'rules' => 'required'
            ],
            'ufnme' => [
                'is_primary' => FALSE,
                'type' => 'STRING',
                'show' => TRUE,
                'label' => 'Fullname',
                'form' => 'input',
                'rules' => 'required'
            ],
            'uninme' => [
                'is_primary' => FALSE,
                'type' => 'STRING',
                'show' => TRUE,
                'label' => 'Nickname',
                'form' => 'input',
                'rules' => ''
            ],
            'ubirth' => [
                'is_primary' => FALSE,
                'type' => 'STRING',
                'show' => TRUE,
                'label' => 'Date Of Birth',
                'form' => 'date',
                'rules' => 'required'
            ],
            'umail' => [
                'is_primary' => FALSE,
                'type' => 'STRING',
                'show' => TRUE,
                'label' => 'Email',
                'form' => 'email',
                'rules' => 'required|valid_email'
            ],
            'upp' => [
                'is_primary' => FALSE,
                'type' => 'STRING',
                'show' => FALSE,
                'label' => 'Profile Picture',
                'form' => 'upload',
                'rules' => ''
            ],
            'ustat' => [
                'is_primary' => FALSE,
                'type' => 'BOOLEAN',
                'show' => TRUE,
                'label' => 'Status',
                'form' => 'checkbox',
                'rules' => ''
            ]
        ];
        
        $this->attribute['index'] = [
            'rl' => [
                'key' => 'rid',
                'show_in_datagrid' => FALSE,
                'show_in_form' => TRUE
            ]
        ];
    }

}
