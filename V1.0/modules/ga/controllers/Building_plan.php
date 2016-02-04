<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Building_plan
 *
 * @author nanank
 */
class Building_plan extends GN_Controller {

    protected $models = ['building_plan'];
    private $_building_plan_unit;
    private $_building_plan_level;

    public function __construct() {
        parent::__construct();

        $this->_building_plan_unit = ['I' => 'Unit I', 'II' => 'Unit II', 'III' => 'Unit III'];
        for ($i = 1; $i < 10; $i++)
            $this->_building_plan_level[$i] = 'Level ' . $i;

        $this->data['form'] = [
            [
                'name' => 'building_plan_unit',
                'label' => 'Unit',
                'type' => 'dropdown',
                'items' => $this->_building_plan_unit,
                'rules' => 'required'
            ],
            [
                'name' => 'building_plan_level',
                'label' => 'Level (floor)',
                'type' => 'dropdown',
                'items' => $this->_building_plan_level,
                'rules' => 'required'
            ],
            [
                'name' => 'building_plan_description',
                'label' => 'Description',
                'type' => 'textarea',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'building_plan_status',
                'label' => 'Is Acitve?',
                'type' => 'checkbox',
                'items' => NULL,
                'rules' => NULL
            ]
        ];
    }

}
