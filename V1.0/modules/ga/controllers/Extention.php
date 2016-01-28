<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Extention
 *
 * @author nanank
 */
class Extention extends GN_Controller {

    protected $models = ['extention'];
    protected $helpers = ['string'];

    public function __construct() {
        parent::__construct();
        $this->view = FALSE;
    }

    public function index() {
        $this->load->library(['pagination', 'table']);
        $config['base_url'] = base_url('ga/extention/index/');
        $config['total_rows'] = $this->extention->count_all();
        $this->pagination->initialize($config);

        $this->extention->order_by('extention_id', 'ASC');
        $this->extention->limit(5, !empty($this->uri->segment(4)) ? 5 * ($this->uri->segment(4) - 1) : 0);
        foreach ($this->extention->get_all() as $index => $row) {
            if (isset($row->CI_rownum))
                unset($row->CI_rownum);
            
            $this->data['extention'][$index] = $row;
        }
        
        $this->data['links'] = $this->pagination->create_links();

        debug($this->data);
        $this->load->view('header');
        $this->load->view('extention', $this->data);
        $this->load->view('footer');
    }

    public function create() {
        //debug('here');
        $this->load->view('header');
        $this->load->view('extention_create', $this->data);
        $this->load->view('footer');
    }

    protected function insert() {
        debug($this->input->post());
    }

    public function update() {
        $extention_id = $this->uri->segment(4);
        $this->data['extention'] = $this->extention->get($extention_id);
        $this->data['extention_id'] = $this->data['extention']->extention_id;

        //debug($this->data);
        $this->load->view('header');
        $this->load->view('extention_update', $this->data);
        $this->load->view('footer');
    }

    protected function edit() {
        debug($this->input->post());
    }
    
    protected function delete() {
        debug('here');
    }

}
