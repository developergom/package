<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Users
 *
 * @author nanank
 */
class Users extends GN_Controller {
    protected $models = ['users'];

    public function __construct() {
        parent::__construct();
        $this->data['id'] = $this->item_type->primary_key;
        $this->data['form'] = [
            [
                'name' => 'item_type_name',
                'label' => 'Name',
                'type' => 'input',
                'rules' => 'required'
            ],
            [
                'name' => 'item_type_desc',
                'label' => 'Description',
                'type' => 'textarea',
                'rules' => 'required'
            ],
            [
                'name' => 'item_type_status',
                'label' => 'Is Acitve?',
                'type' => 'checkbox',
                'rules' => NULL
            ]
        ];
    }

   
}
