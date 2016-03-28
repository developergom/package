<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Sla_type
 *
 * @author nanank
 */
class Sla_type extends GN_Controller {

    protected $models = ['sla_type'];

    public function __construct() {
        parent::__construct();
        $this->data['form'] = [
            [
                'name' => 'sla_type_name',
                'label' => 'Name',
                'type' => 'input',
                'slas' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'sla_type_desc',
                'label' => 'Description',
                'type' => 'textarea',
                'slas' => NULL,
                'rules' => 'required'
            ],
            [
                'name' => 'sla_type_status',
                'label' => 'Is Acitve?',
                'type' => 'checkbox',
                'slas' => NULL,
                'rules' => NULL
            ]
        ];
    }


}
