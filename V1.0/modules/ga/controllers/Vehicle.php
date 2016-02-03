<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Vehicle
 *
 * @author nanank
 */
class Vehicle extends GN_Controller {

    protected $models = ['vehicle', 'vehicle_type'];

    public function __construct() {
        parent::__construct();
        $this->data['form'] = [
            [
                'name' => 'vehicle_type_id',
                'label' => 'Vehicle Type',
                'type' => 'dropdown',
                'items' => $this->vehicle_type->dropdown('vehicle_type_name'),
                'rules' => 'required'
            ],
            [
                'name' => 'vehicle_police_number',
                'label' => 'Police Number',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'vehicle_color',
                'label' => 'Color',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'vehicle_chassis_number',
                'label' => 'Chassis Number',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required|numeric'
            ],
            [
                'name' => 'vehicle_engine_number',
                'label' => 'Engine Number',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required|numeric'
            ],
            [
                'name' => 'vehicle_status',
                'label' => 'Is Active?',
                'type' => 'checkbox',
                'items' => NULL,
                'rules' => NULL
            ]
        ];
    }

}
