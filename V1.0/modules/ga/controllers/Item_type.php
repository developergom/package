<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Item_type
 *
 * @author nanank
 */
class Item_type extends GN_Controller {

    protected $models = ['item_type'];
    protected $helpers = [];

    public function __construct() {
        parent::__construct();
        $this->data['id'] = $this->item_type->primary_key;
        $this->data['form'] = [
            [
                'name' => 'item_type_name',
                'label' => 'Name',
                'type' => 'input',
                'rules' => 'required'
            ],
            [
                'name' => 'item_type_desc',
                'label' => 'Description',
                'type' => 'textarea',
                'rules' => 'required'
            ],
            [
                'name' => 'item_type_status',
                'label' => 'Is Acitve?',
                'type' => 'checkbox',
                'rules' => NULL
            ]
        ];
        
        $this->data['style'] = ['datepicker3'];
        $this->data['script'] = ['jquery.inputmask.extensions', 'jquery.inputmask.date.extensions', 'bootstrap-datepicker'];
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

            $this->data['datagrid'][$index] = $row;
        }

        $this->data['datagrid_header'] = ['Name', 'Description', 'Status'];
        $this->data['links'] = $this->pagination->create_links();
    }


    protected function insert() {
        $this->item_type->insert($this->input->post());
        redirect('ga/item_type/index', 'refresh');
    }

    public function update() {
        $this->view = 'layouts/AdminLTE/form';
        $item_type_id = $this->uri->segment(4);
        $this->data['record'] = $this->item_type->get($item_type_id);
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
