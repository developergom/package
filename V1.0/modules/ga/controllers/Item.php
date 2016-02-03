<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Item
 *
 * @author nanank
 */
class Item extends GN_Controller {

    protected $models = ['item', 'item_type'];

    public function __construct() {
        parent::__construct();
        $this->data['form'] = [
            [
                'name' => 'item_type_id',
                'label' => 'Type',
                'type' => 'dropdown',
                'items' => $this->item_type->dropdown('item_type_name'),
                'rules' => 'required'
            ],
            [
                'name' => 'item_name',
                'label' => 'Name',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'item_description',
                'label' => 'Description',
                'type' => 'textarea',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'item_sku_number',
                'label' => 'SKU Number',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'item_stock',
                'label' => 'Stock',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'item_unit',
                'label' => 'Unit',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'item_price',
                'label' => 'Price',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'item_bun',
                'label' => 'BUN',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'item_status',
                'label' => 'Is Active?',
                'type' => 'checkbox',
                'items' => NULL,
                'rules' => NULL
            ]
        ];

    }

}
