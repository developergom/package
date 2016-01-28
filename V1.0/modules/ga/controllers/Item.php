<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Item
 *
 * @author nanank
 */
class Item extends GN_Controller {

    protected $models = ['item'];
    protected $helpers = ['string'];

    public function __construct() {
        parent::__construct();
        $this->view = FALSE;
    }

    public function index() {
        $this->load->library(['pagination', 'table']);
        $config['base_url'] = base_url('ga/item/index/');
        $config['total_rows'] = $this->item->count_all();
        $this->pagination->initialize($config);

        $this->item->order_by('item_id', 'ASC');
        $this->item->limit(5, !empty($this->uri->segment(4)) ? 5 * ($this->uri->segment(4) - 1) : 0);
        foreach ($this->item->get_all() as $index => $row) {
            if (isset($row->CI_rownum))
                unset($row->CI_rownum);
            
            $this->data['item'][$index] = $row;
        }
        
        $this->data['links'] = $this->pagination->create_links();

        debug($this->data);
        $this->load->view('header');
        $this->load->view('item', $this->data);
        $this->load->view('footer');
    }

    public function create() {
        //debug('here');
        $this->load->view('header');
        $this->load->view('item_create', $this->data);
        $this->load->view('footer');
    }

    protected function insert() {
        debug($this->input->post());
    }

    public function update() {
        $item_id = $this->uri->segment(4);
        $this->data['item'] = $this->item->get($item_id);
        $this->data['item_id'] = $this->data['item']->item_id;

        //debug($this->data);
        $this->load->view('header');
        $this->load->view('item_update', $this->data);
        $this->load->view('footer');
    }

    protected function edit() {
        debug($this->input->post());
    }
    
    protected function delete() {
        debug('here');
    }

}
