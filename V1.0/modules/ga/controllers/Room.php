<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Room
 *
 * @author nanank
 */
class Room extends GN_Controller {

    protected $models = ['room', 'building_plan'];

    public function __construct() {
        parent::__construct();
        $this->data['form'] = [
            [
                'name' => 'building_plan_id',
                'label' => 'Building Plan',
                'type' => 'dropdown',
                'items' => $this->building_plan->dropdown('building_plan_unit'),
                'rules' => 'required'
            ],
            [
                'name' => 'room_name',
                'label' => 'Name',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'room_capacity',
                'label' => 'Capacity',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required|numeric'
            ],
            [
                'name' => 'room_number_of_seats',
                'label' => 'Seats',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required|numeric'
            ],
            [
                'name' => 'room_have_whiteboard',
                'label' => 'Have Whiteboard',
                'type' => 'checkbox',
                'items' => NULL,
                'rules' => NULL
            ],
            [
                'name' => 'room_status',
                'label' => 'Is Active?',
                'type' => 'checkbox',
                'items' => NULL,
                'rules' => NULL
            ]
        ];

    }

}
