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
                'rules' => 'required'
            ],
            [
                'name' => 'vehicle_type_name',
                'label' => 'Name',
                'type' => 'input',
                'rules' => 'required'
            ],
            [
                'name' => 'vehicle_type_year',
                'label' => 'Year',
                'type' => 'input',
                'rules' => 'required|numeric'
            ],
            [
                'name' => 'vehicle_type_status',
                'label' => 'Is Active?',
                'type' => 'checkbox',
                'rules' => NULL
            ]
        ];

        $this->data['datagrid_header'] = ['Brand', 'Name', 'Year', 'Status'];
    }

}
