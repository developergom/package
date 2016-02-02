<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Sla_type
 *
 * @author nanank
 */
class Sla_type extends GN_Controller {

    protected $models = ['sla_type'];
    protected $helpers = ['string'];

    public function __construct() {
        parent::__construct();
        //$this->view = FALSE;
    }

//    public function index() {
//        $this->load->library(['pagination', 'table']);
//        $config['base_url'] = base_url('ga/sla_type/index/');
//        $config['total_rows'] = $this->sla_type->count_all();
//        $this->pagination->initialize($config);
//
//        $this->sla_type->order_by('sla_type_id', 'ASC');
//        $this->sla_type->limit(5, !empty($this->uri->segment(4)) ? 5 * ($this->uri->segment(4) - 1) : 0);
//        foreach ($this->sla_type->get_all() as $index => $row) {
//            if (isset($row->CI_rownum))
//                unset($row->CI_rownum);
//            
//            $this->data['sla_type'][$index] = $row;
//        }
//        
//        $this->data['links'] = $this->pagination->create_links();
//
//        debug($this->data);
//        $this->load->view('header');
//        $this->load->view('sla_type', $this->data);
//        $this->load->view('footer');
//    }
//
//    public function create() {
//        //debug('here');
//        $this->load->view('header');
//        $this->load->view('sla_type_create', $this->data);
//        $this->load->view('footer');
//    }
//
//    protected function insert() {
//        debug($this->input->post());
//    }
//
//    public function update() {
//        $sla_type_id = $this->uri->segment(4);
//        $this->data['sla_type'] = $this->sla_type->get($sla_type_id);
//        $this->data['sla_type_id'] = $this->data['sla_type']->sla_type_id;
//
//        //debug($this->data);
//        $this->load->view('header');
//        $this->load->view('sla_type_update', $this->data);
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
