<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Room
 *
 * @author nanank
 */
class Room extends GN_Controller {

    protected $models = ['room'];
    protected $helpers = ['string'];

    public function __construct() {
        parent::__construct();
        $this->view = FALSE;
    }

    public function index() {
        $this->load->library(['pagination', 'table']);
        $config['base_url'] = base_url('ga/room/index/');
        $config['total_rows'] = $this->room->count_all();
        $this->pagination->initialize($config);

        $this->room->order_by('room_id', 'ASC');
        $this->room->limit(5, !empty($this->uri->segment(4)) ? 5 * ($this->uri->segment(4) - 1) : 0);
        foreach ($this->room->get_all() as $index => $row) {
            if (isset($row->CI_rownum))
                unset($row->CI_rownum);
            
            $this->data['room'][$index] = $row;
        }
        
        $this->data['links'] = $this->pagination->create_links();

        debug($this->data);
        $this->load->view('header');
        $this->load->view('room', $this->data);
        $this->load->view('footer');
    }

    public function create() {
        //debug('here');
        $this->load->view('header');
        $this->load->view('room_create', $this->data);
        $this->load->view('footer');
    }

    protected function insert() {
        debug($this->input->post());
    }

    public function update() {
        $room_id = $this->uri->segment(4);
        $this->data['room'] = $this->room->get($room_id);
        $this->data['room_id'] = $this->data['room']->room_id;

        //debug($this->data);
        $this->load->view('header');
        $this->load->view('room_update', $this->data);
        $this->load->view('footer');
    }

    protected function edit() {
        debug($this->input->post());
    }
    
    protected function delete() {
        debug('here');
    }

}
