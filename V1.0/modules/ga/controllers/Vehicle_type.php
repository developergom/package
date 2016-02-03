<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Vehicle_type
 *
 * @author nanank
 */
class Vehicle_type extends GN_Controller {

    protected $models = ['vehicle_type'];

    public function __construct() {
        parent::__construct();
        $this->data['form'] = [
            [
                'name' => 'vehicle_type_brand',
                'label' => 'Brand',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'vehicle_type_name',
                'label' => 'Name',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'vehicle_type_year',
                'label' => 'Year',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required|numeric'
            ],
            [
                'name' => 'vehicle_type_status',
                'label' => 'Is Active?',
                'type' => 'checkbox',
                'items' => NULL,
                'rules' => NULL
            ]
        ];

    }

}
