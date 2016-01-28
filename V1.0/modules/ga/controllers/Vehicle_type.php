<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Vehicle_type
 *
 * @author nanank
 */
class Vehicle_type extends GN_Controller {

    protected $models = ['vehicle_type'];
    protected $helpers = ['string'];

    public function __construct() {
        parent::__construct();
        $this->view = FALSE;
    }

    public function index() {
        $this->load->library(['pagination', 'table']);
        $config['base_url'] = base_url('ga/vehicle_type/index/');
        $config['total_rows'] = $this->vehicle_type->count_all();
        $this->pagination->initialize($config);

        $this->vehicle_type->order_by('vehicle_type_id', 'ASC');
        $this->vehicle_type->limit(5, !empty($this->uri->segment(4)) ? 5 * ($this->uri->segment(4) - 1) : 0);
        foreach ($this->vehicle_type->get_all() as $index => $row) {
            if (isset($row->CI_rownum))
                unset($row->CI_rownum);
            
            $this->data['vehicle_type'][$index] = $row;
        }
        
        $this->data['links'] = $this->pagination->create_links();

        debug($this->data);
        $this->load->view('header');
        $this->load->view('vehicle_type', $this->data);
        $this->load->view('footer');
    }

    public function create() {
        //debug('here');
        $this->load->view('header');
        $this->load->view('vehicle_type_create', $this->data);
        $this->load->view('footer');
    }

    protected function insert() {
        debug($this->input->post());
    }

    public function update() {
        $vehicle_type_id = $this->uri->segment(4);
        $this->data['vehicle_type'] = $this->vehicle_type->get($vehicle_type_id);
        $this->data['vehicle_type_id'] = $this->data['vehicle_type']->vehicle_type_id;

        //debug($this->data);
        $this->load->view('header');
        $this->load->view('vehicle_type_update', $this->data);
        $this->load->view('footer');
    }

    protected function edit() {
        debug($this->input->post());
    }
    
    protected function delete() {
        debug('here');
    }

}
