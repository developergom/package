<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Sla
 *
 * @author nanank
 */
class Sla extends GN_Controller {

    protected $models = ['sla', 'sla_type', 'item'];

    public function __construct() {
        parent::__construct();
        $this->data['form'] = [
            [
                'name' => 'sla_type_id',
                'label' => 'Sla Type',
                'type' => 'dropdown',
                'items' => $this->sla_type->dropdown('sla_type_name'),
                'rules' => 'required'
            ],
            [
                'name' => 'item_id',
                'label' => 'Item',
                'type' => 'dropdown',
                'items' => $this->item->dropdown('item_name'),
                'rules' => 'required'
            ],
            [
                'name' => 'sla_day',
                'label' => 'Day',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'sla_spmb',
                'label' => 'SPMB',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'sla_offering',
                'label' => 'Offering',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'sla_approve_1',
                'label' => 'First Approval',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'sla_approve_2',
                'label' => 'Second Approval',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'sla_bs',
                'label' => 'BS',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'sla_po',
                'label' => 'PO',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'sla_production',
                'label' => 'Production',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'sla_received',
                'label' => 'REceived',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'sla_total_day',
                'label' => 'Total Day',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'sla_status',
                'label' => 'Is Active?',
                'type' => 'checkbox',
                'items' => NULL,
                'rules' => NULL
            ]
        ];
    }

}
