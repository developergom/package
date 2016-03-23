<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Configs
 *
 * @author soniibrol
 */
class Configs extends GN_Controller {

    protected $models = ['configs'];
    protected $helpers = [];
    protected $_base = '';

    public function __construct() {
        parent::__construct();
        $this->_base = $this->router->fetch_module() . '/' . $this->router->fetch_class();
        $this->data['form'] = [
            [
                'name' => 'config_key',
                'label' => 'Key',
                'type' => 'input',
                'rules' => 'required|max_length[100]|is_unique[configs.config_key]|alpha_dash'
            ],
            [
                'name' => 'config_value',
                'label' => 'Value',
                'type' => 'textarea',
                'rules' => 'required|max_length[255]'
            ],
            [
                'name' => 'config_desc',
                'label' => 'Description',
                'type' => 'textarea',
                'rules' => NULL
            ]
        ];
    }

    public function edit($primary_key = 0) {
        debug($this->input->post());
        $this->sso_new->check_access('u');
        $custom_rules = [
            [
                'name' => 'config_value',
                'label' => 'Value',
                'type' => 'textarea',
                'rules' => 'required|max_length[255]'
            ],
            [
                'name' => 'config_desc',
                'label' => 'Description',
                'type' => 'textarea',
                'rules' => NULL
            ]
        ];

        $actual = $this->configs->get($this->input->post('config_id'));
        if ($this->input->post('config_key') !== $actual->config_key) {
            array_push($custom_rules, [
                'name' => 'config_key',
                'label' => 'Key',
                'type' => 'input',
                'rules' => 'required|max_length[100]|is_unique[configs.config_key]|alpha_dash'
                    ]
            );
        }

        $record = $this->configs->get($this->input->post('config_id'));
        if (!empty($record)) {
            if ($this->validation($custom_rules) === FALSE) {
                redirect($this->_base . '/update/' . $this->input->post('config_key'));
            } else {
                $data_config = [
                    'config_key' => $this->input->post('config_key'),
                    'config_value' => $this->input->post('config_value'),
                    'config_desc' => $this->input->post('config_desc')
                ];

                $this->configs->update($record->config_id, $data_config, TRUE);

                redirect($this->_base, 'refresh');
            }
        }
    }

}
