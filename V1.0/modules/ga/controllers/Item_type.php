<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Item_type
 *
 * @author nanank
 */
class Item_type extends GN_Controller {

    protected $models = ['item_type'];

    public function __construct() {
        parent::__construct();
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
        
        $this->data['datagrid_header'] = ['Name', 'Description', 'Status'];
    }


}
