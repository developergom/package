<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Building_plan_model
 *
 * @author nanank
 */
class Building_plan_model extends GN_Model {

    public $_db_group = 'GAFFAIR';
    public $primary_key = 'building_plan_id';
    public $protected_attributes = ['building_plan_id'];
    public $before_create = ['create_log'];
    public $before_update = ['update_log'];
    public $validate = [
        [
            'field' => 'building_plan_unit',
            'label' => 'Unit',
            'rules' => 'required'
        ],
        [
            'field' => 'building_plan_level',
            'label' => 'Level (floor)',
            'rules' => 'required|numeric'
        ],
        [
            'field' => 'building_plan_description',
            'label' => 'Description',
            'rules' => 'required'
        ]
    ];

    public function __construct() {
        parent::__construct();
    }

}
