<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Category
 *
 * @author nanank
 */
class Category extends GN_Controller {

    protected $models = ['category'];

    public function __construct() {
        parent::__construct();
        $this->data['recursive'] = ['category_id', 'category_parent', 'category_name'];
        $this->data['form'] = [
            [
                'name' => 'category_parent',
                'label' => 'Is Sub From',
                'type' => 'dropdown',
                'items' => $this->category->dropdown('category_name'),
                'rules' => NULL
            ],
            [
                'name' => 'category_name',
                'label' => 'Name',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'category_description',
                'label' => 'Description',
                'type' => 'textarea',
                'items' => NULL,
                'rules' => 'required'
            ]
        ];
    }

}
