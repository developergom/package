<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Apps
 *
 * @author soniibrol
 */
class Apps extends GN_Controller {

    protected $models = ['apps'];
    protected $helpers = [];
    protected $asides = ['modal-list-icon'];

    public function __construct() {
        parent::__construct();
        //$this->data['id'] = $this->role->primary_key;
        $this->data['form'] = [
            [
                'name' => 'app_name',
                'label' => 'Apps Name',
                'type' => 'input',
                'rules' => 'required|max[100]'
            ],
            [
                'name' => 'app_desc',
                'label' => 'Description',
                'type' => 'textarea',
                'rules' => NULL
            ],
            [
                'name' => 'app_order',
                'label' => 'Order',
                'type' => 'input',
                'rules' => 'required|numeric'
            ],
            [
                'name' => 'app_icon',
                'label' => 'Icon',
                'type' => 'icon',
                'rules' => NULL
            ],
            [
                'name' => 'app_url',
                'label' => 'Apps URL',
                'type' => 'input',
                'rules' => 'required|max[255]'
            ],
            [
                'name' => 'app_status',
                'label' => 'Is Active?',
                'type' => 'checkbox',
                'rules' => NULL
            ]
        ];
        
        $this->data['style'] = [];
        $this->data['script'] = ['list-icon-modal'];
        $this->data['datagrid_header'] = ['Apps Name', 'Description', 'Order', 'Icon', 'URL', 'Status'];
    }

}
