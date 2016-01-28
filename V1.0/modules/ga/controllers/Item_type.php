<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Item_type
 *
 * @author nanank
 */
class Item_type extends GN_Controller {

    protected $models = ['item_type'];
    protected $helpers = ['string'];

    public function __construct() {
        parent::__construct();
        $this->view = FALSE;
    }

    public function index() {
        $this->load->library(['pagination', 'table']);
        $config['base_url'] = base_url('ga/item_type/index/');
        $config['total_rows'] = $this->item_type->count_all();
        $this->pagination->initialize($config);

        $this->item_type->order_by('item_type_id', 'ASC');
        $this->item_type->limit(5, !empty($this->uri->segment(4)) ? 5 * ($this->uri->segment(4) - 1) : 0);
        foreach ($this->item_type->get_all() as $index => $row) {
            if (isset($row->CI_rownum))
                unset($row->CI_rownum);

            unset($row->create_by);
            unset($row->create_when);
            unset($row->update_by);
            unset($row->update_when);

            $this->data['item_type'][$index] = $row;
        }

        $this->data['links'] = $this->pagination->create_links();

        //debug($this->data);
        $this->load->view('header');
        $this->load->view('item_type', $this->data);
        $this->load->view('footer');
    }

    public function create() {
        //debug('here');
        $this->load->view('header');
        $this->load->view('item_type_create', $this->data);
        $this->load->view('footer');
    }

    protected function insert() {
        $this->item_type->insert($this->input->post());
        redirect('ga/item_type/index', 'refresh');
    }

    public function update() {
        $item_type_id = $this->uri->segment(4);
        $this->data['item_type'] = $this->item_type->get($item_type_id);

        //debug($this->data);
        $this->load->view('header');
        $this->load->view('item_type_update', $this->data);
        $this->load->view('footer');
    }

    protected function edit() {
        $item_type = $this->item_type->get($this->input->post('item_type_id'));
        if (!empty($item_type)) {
            $this->item_type->update($item_type->item_type_id, $this->input->post());
            redirect('ga/item_type/index', 'refresh');
        }
    }

    protected function delete() {
        $item_type_id = $this->uri->segment(4);
        $this->item_type->delete($item_type_id);
        redirect('ga/item_type/index', 'refresh');
    }

}
