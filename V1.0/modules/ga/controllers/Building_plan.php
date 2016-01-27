<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Building_plan
 *
 * @author nanank
 */
class Building_plan extends GN_Controller {

    protected $models = ['building_plan'];
    protected $helpers = ['string'];

    public function __construct() {
        parent::__construct();
        $this->view = FALSE;
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
            
            $this->data['building_plan'][$index] = $row;
        }
        
        $this->data['links'] = $this->pagination->create_links();

        debug($this->data);
        $this->load->view('header');
        $this->load->view('building_plan', $this->data);
        $this->load->view('footer');
    }

    public function create() {
        //debug('here');
        $this->load->view('header');
        $this->load->view('building_plan_create', $this->data);
        $this->load->view('footer');
    }

    protected function insert() {
        debug($this->input->post());
    }

    public function update() {
        $building_plan_id = $this->uri->segment(4);
        $this->data['building_plan'] = $this->building_plan->get($building_plan_id);
        $this->data['building_plan_id'] = $this->data['building_plan']->building_plan_id;

        //debug($this->data);
        $this->load->view('header');
        $this->load->view('building_plan_update', $this->data);
        $this->load->view('footer');
    }

    protected function edit() {
        debug($this->input->post());
    }
    
    protected function delete() {
        debug('here');
    }

}
