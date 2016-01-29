<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Building_plan
 *
 * @author nanank
 */
class Building_plan extends GN_Controller {

    protected $models = ['building_plan'];
    protected $helpers = [];
    
    private $_building_plan_unit;
    private $_building_plan_level;

    public function __construct() {
        parent::__construct();

        $this->data['id'] = $this->building_plan->primary_key;
        $this->_building_plan_unit = ['I' => 'Unit I', 'II' => 'Unit II', 'III' => 'Unit III'];
        for ($i = 1; $i < 10; $i++)
            $this->_building_plan_level[$i] = 'Level ' . $i;
        
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
    }

    public function index() {
        $this->load->library(['pagination', 'table']);
        $config['base_url'] = base_url('ga/building_plan/index/');
        $config['total_rows'] = $this->building_plan->count_all();
        $this->pagination->initialize($config);

        $this->building_plan->order_by('building_plan_id', 'ASC');
        $this->building_plan->limit(5, !empty($this->uri->segment(4)) ? 5 * ($this->uri->segment(4) - 1) : 0);
        foreach ($this->building_plan->get_all() as $index => $row) {
            if (isset($row->CI_rownum))
                unset($row->CI_rownum);

            unset($row->create_by);
            unset($row->create_when);
            unset($row->update_by);
            unset($row->update_when);

            $this->data['datagrid'][$index] = $row;
        }

        $this->data['datagrid_header'] = ['Description', 'Unit', 'Level', 'Status'];
        $this->data['links'] = $this->pagination->create_links();
    }

    public function create() {
        $this->view = 'layouts/AdminLTE/form';
        $this->data['building_plan_unit'] = $this->_building_plan_unit;
        $this->data['building_plan_level'] = $this->_building_plan_level;
    }

    protected function insert() {
        $this->building_plan->insert($this->input->post());
        redirect('ga/building_plan/index', 'refresh');
    }

    public function update() {
        $this->view = 'layouts/AdminLTE/form';
        $building_plan_id = $this->uri->segment(4);
        $this->data['record'] = $this->building_plan->get($building_plan_id);
        $this->data['building_plan_unit'] = $this->_building_plan_unit;
        $this->data['building_plan_level'] = $this->_building_plan_level;
    }

    protected function edit() {
        $building_plan = $this->building_plan->get($this->input->post('building_plan_id'));
        if (!empty($building_plan)) {
            $this->building_plan->update($building_plan->building_plan_id, $this->input->post());
            redirect('ga/building_plan/index', 'refresh');
        }
    }

    protected function delete() {
        $building_plan_id = $this->uri->segment(4);
        $this->building_plan->delete($building_plan_id);
        redirect('ga/building_plan/index', 'refresh');
    }

}
