<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Vehicle_rate
 *
 * @author nanank
 */
class Vehicle_rate extends GN_Controller {

    protected $models = ['vehicle_rate', 'vehicle_type'];
    protected $alias = [
        'vehicle_type' => ['vehicle_type_id' => 'vehicle_type_name']
    ];

    public function __construct() {
        parent::__construct();
        $this->data['form'] = [
            [
                'name' => 'vehicle_type_id',
                'label' => 'Vehicle Type',
                'type' => 'dropdown',
                'rules' => 'required'
            ],
            [
                'name' => 'vehicle_rate_6_hour',
                'label' => '6 Hour',
                'type' => 'input',
                'rules' => 'required|numeric'
            ],
            [
                'name' => 'vehicle_rate_12_hour',
                'label' => '12 Hour',
                'type' => 'input',
                'rules' => 'required|numeric'
            ],
            [
                'name' => 'vehicle_rate_24_hour',
                'label' => '24 Hour',
                'type' => 'input',
                'rules' => 'required|numeric'
            ],
            [
                'name' => 'vehicle_rate_monthly',
                'label' => 'Monthly',
                'type' => 'input',
                'rules' => 'required|numeric'
            ],
            [
                'name' => 'vehicle_rate_extend_hour',
                'label' => 'Hourly Extend (%)',
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

        $this->data['datagrid_header'] = ['Vahicle Type', '6 Hour', '12 Hour', '24 Hour', 'Monthly', 'Extend (%)', 'Status'];
    }

//    public function index() {
//        //$this->layout = '';
//        $this->view = 'ga/vehicle_rate';
//        $this->load->library(['pagination', 'table']);
//        $config['base_url'] = base_url('ga/vehicle_rate/index/');
//        $config['total_rows'] = $this->vehicle_rate->count_all();
//        $this->pagination->initialize($config);
//
//        $this->vehicle_rate->order_by($this->vehicle_rate->primary_key, 'ASC');
//        $this->vehicle_rate->limit(5, !empty($this->uri->segment(4)) ? 5 * ($this->uri->segment(4) - 1) : 0);
//        foreach ($this->vehicle_rate->with('type')->as_array()->get_all() as $index => $row) {
//            $row = object_to_array($row);
//            if (isset($row['CI_rownum']))
//                unset($row['CI_rownum']);
//
//            unset($row['create_by']);
//            unset($row['create_when']);
//            unset($row['update_by']);
//            unset($row['update_when']);
//
//            $this->data['datagrid'][$index] = $row;
//        }
//
//        $this->data['links'] = $this->pagination->create_links();
//    }
//    public function create() {
//        $this->view = 'ga/vehicle_rate_create';
//    }
}
