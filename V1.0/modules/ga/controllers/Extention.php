<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Extention
 *
 * @author nanank
 */
class Extention extends GN_Controller {

    protected $models = ['extention'];
    
    private $_extention_type;

    public function __construct() {
        parent::__construct();
        $this->_extention_type = ['fax' => 'Fax', 'direct' => 'Direct', 'hunting' => 'Hunting'];
        $this->data['form'] = [
            [
                'name' => 'extention_type',
                'label' => 'Type',
                'type' => 'dropdown',
                'items' => $this->_extention_type,
                'rules' => 'required'
            ],
            [
                'name' => 'extention_number',
                'label' => 'Number',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'extention_status',
                'label' => 'Is Acitve?',
                'type' => 'checkbox',
                'items' => NULL,
                'rules' => NULL
            ]
        ];
    }

}
