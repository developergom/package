<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Vehicle_rate
 *
 * @author nanank
 */
class Vehicle_rate extends GN_Controller {

    protected $models = ['vehicle_rate'];
    protected $helpers = ['string'];

    public function __construct() {
        parent::__construct();
        $this->view = FALSE;
    }

    public function index() {
        $this->load->library(['pagination', 'table']);
        $config['base_url'] = base_url('ga/vehicle_rate/index/');
        $config['total_rows'] = $this->vehicle_rate->count_all();
        $this->pagination->initialize($config);

        $this->vehicle_rate->order_by('vehicle_rate_id', 'ASC');
        $this->vehicle_rate->limit(5, !empty($this->uri->segment(4)) ? 5 * ($this->uri->segment(4) - 1) : 0);
        foreach ($this->vehicle_rate->get_all() as $index => $row) {
            if (isset($row->CI_rownum))
                unset($row->CI_rownum);
            
            $this->data['vehicle_rate'][$index] = $row;
        }
        
        $this->data['links'] = $this->pagination->create_links();

        debug($this->data);
        $this->load->view('header');
        $this->load->view('vehicle_rate', $this->data);
        $this->load->view('footer');
    }

    public function create() {
        //debug('here');
        $this->load->view('header');
        $this->load->view('vehicle_rate_create', $this->data);
        $this->load->view('footer');
    }

    protected function insert() {
        debug($this->input->post());
    }

    public function update() {
        $vehicle_rate_id = $this->uri->segment(4);
        $this->data['vehicle_rate'] = $this->vehicle_rate->get($vehicle_rate_id);
        $this->data['vehicle_rate_id'] = $this->data['vehicle_rate']->vehicle_rate_id;

        //debug($this->data);
        $this->load->view('header');
        $this->load->view('vehicle_rate_update', $this->data);
        $this->load->view('footer');
    }

    protected function edit() {
        debug($this->input->post());
    }
    
    protected function delete() {
        debug('here');
    }

}
