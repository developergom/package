<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Action
 *
 * @author soniibrol
 */
class Action extends GN_Controller {

    protected $models = ['action'];
    protected $helpers = [];

    public function __construct() {
        parent::__construct();
        $this->data['form'] = [
            [
                'name' => 'action_name',
                'label' => 'Action Name',
                'type' => 'input',
                'rules' => 'required|max_length[100]'
            ],
            [
                'name' => 'action_alias',
                'label' => 'Alias',
                'type' => 'input',
                'rules' => 'required|max_length[50]|is_unique[actions.action_alias]'
            ],
            [
                'name' => 'action_desc',
                'label' => 'Description',
                'type' => 'textarea',
                'rules' => 'required'
            ],
            [
                'name' => 'action_status',
                'label' => 'Is Active?',
                'type' => 'checkbox',
                'rules' => NULL
            ]
        ];
        
        $this->data['style'] = [];
        $this->data['script'] = [];
    }

    protected function edit() {
        $custom_rules = [
            [
                'name' => 'action_name',
                'label' => 'Action Name',
                'type' => 'input',
                'rules' => 'required|max_length[100]'
            ],
            [
                'name' => 'action_desc',
                'label' => 'Description',
                'type' => 'textarea',
                'rules' => 'required'
            ],
            [
                'name' => 'action_status',
                'label' => 'Is Active?',
                'type' => 'checkbox',
                'rules' => NULL
            ]
        ];
        $custom_base = $this->router->fetch_module() . '/' . $this->router->fetch_class();

        $actual = $this->action->get($this->input->post('action_id'));
        if($this->input->post('action_alias')!==$actual->action_alias) { 
            array_push($custom_rules, 
                [
                    'name' => 'action_alias',
                    'label' => 'Alias',
                    'type' => 'input',
                    'rules' => 'required|max_length[50]|is_unique[actions.action_alias]'
                ]
            );
        }

        $record = $this->action->get($this->input->post('action_id'));
        if (!empty($record)) {
            if($this->validation($custom_rules)===FALSE) {
                redirect($custom_base . '/update/' . $this->input->post('action_id'));
            } else {
                $this->action->update($record->{$this->action->primary_key}, $this->input->post(), TRUE);
                redirect($custom_base, 'refresh');
            }
        }
    }

}
