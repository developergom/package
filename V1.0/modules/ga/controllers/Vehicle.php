<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Vehicle
 *
 * @author nanank
 */
class Vehicle extends GN_Controller {

    protected $models = ['vehicle'];
    protected $helpers = ['string'];

    public function __construct() {
        parent::__construct();
        //$this->view = FALSE;
    }

//    public function index() {
//        $this->load->library(['pagination', 'table']);
//        $config['base_url'] = base_url('ga/vehicle/index/');
//        $config['total_rows'] = $this->vehicle->count_all();
//        $this->pagination->initialize($config);
//
//        $this->vehicle->order_by('vehicle_id', 'ASC');
//        $this->vehicle->limit(5, !empty($this->uri->segment(4)) ? 5 * ($this->uri->segment(4) - 1) : 0);
//        foreach ($this->vehicle->get_all() as $index => $row) {
//            if (isset($row->CI_rownum))
//                unset($row->CI_rownum);
//            
//            $this->data['vehicle'][$index] = $row;
//        }
//        
//        $this->data['links'] = $this->pagination->create_links();
//
//        debug($this->data);
//        $this->load->view('header');
//        $this->load->view('vehicle', $this->data);
//        $this->load->view('footer');
//    }
//
//    public function create() {
//        //debug('here');
//        $this->load->view('header');
//        $this->load->view('vehicle_create', $this->data);
//        $this->load->view('footer');
//    }
//
//    protected function insert() {
//        debug($this->input->post());
//    }
//
//    public function update() {
//        $vehicle_id = $this->uri->segment(4);
//        $this->data['vehicle'] = $this->vehicle->get($vehicle_id);
//        $this->data['vehicle_id'] = $this->data['vehicle']->vehicle_id;
//
//        //debug($this->data);
//        $this->load->view('header');
//        $this->load->view('vehicle_update', $this->data);
//        $this->load->view('footer');
//    }
//
//    protected function edit() {
//        debug($this->input->post());
//    }
//    
//    protected function delete() {
//        debug('here');
//    }

}
