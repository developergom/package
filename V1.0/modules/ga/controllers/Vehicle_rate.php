<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Vehicle_rate
 *
 * @author nanank
 */
class Vehicle_rate extends GN_Controller {

    protected $models = ['vehicle_rate', 'vehicle_type'];

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
                'name' => 'vehicle_rate_6_hour',
                'label' => '6 Hour',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required|numeric'
            ],
            [
                'name' => 'vehicle_rate_12_hour',
                'label' => '12 Hour',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required|numeric'
            ],
            [
                'name' => 'vehicle_rate_24_hour',
                'label' => '24 Hour',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required|numeric'
            ],
            [
                'name' => 'vehicle_rate_monthly',
                'label' => 'Monthly',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required|numeric'
            ],
            [
                'name' => 'vehicle_rate_extend_hour',
                'label' => 'Hourly Extend (%)',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required|numeric'
            ],
            [
                'name' => 'vehicle_rate_status',
                'label' => 'Is Active?',
                'type' => 'checkbox',
                'items' => NULL,
                'rules' => NULL
            ]
        ];
    }

}
