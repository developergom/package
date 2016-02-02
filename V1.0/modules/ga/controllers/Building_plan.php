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
        for ($i = 1; $i < 10; $i++) :
            $this->_building_plan_level[$i] = 'Level ' . $i;
        endfor;
        
        $this->data['form'] = [
            [
                'name' => 'building_plan_unit',
                'label' => 'Unit',
                'type' => 'dropdown',
                'rules' => 'required'
            ],
            [
                'name' => 'building_plan_level',
                'label' => 'Level (floor)',
                'type' => 'dropdown',
                'rules' => 'required'
            ],
            [
                'name' => 'building_plan_description',
                'label' => 'Description',
                'type' => 'textarea',
                'rules' => 'required'
            ],
            [
                'name' => 'building_plan_status',
                'label' => 'Is Acitve?',
                'type' => 'checkbox',
                'rules' => NULL
            ]
        ];

        $this->data['datagrid_header'] = ['Description', 'Unit', 'Level', 'Status'];
    }

    public function create() {
        $this->view = 'building_plan_create';
        $this->data['action'] = $this->router->fetch_module() . '/' . $this->router->fetch_class() . '/insert/';
        $this->data['building_plan_unit'] = $this->_building_plan_unit;
        $this->data['building_plan_level'] = $this->_building_plan_level;
    }

    public function update() {
        $this->view = 'building_plan_update';
        $building_plan_id = $this->uri->segment(4);
        $this->data['action'] = $this->router->fetch_module() . '/' . $this->router->fetch_class() . '/edit/';
        $this->data['record'] = $this->building_plan->get($building_plan_id);
        $this->data['building_plan_unit'] = $this->_building_plan_unit;
        $this->data['building_plan_level'] = $this->_building_plan_level;
    }

}
