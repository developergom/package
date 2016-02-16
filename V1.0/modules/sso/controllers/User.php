<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Users
 *
 * @author soniibrol
 */
class User extends GN_Controller {
    protected $models = ['user','role','user_role'];
    protected $helpers = [];
    protected $_base = '';
    protected $_primary_key = 'user_id';
    protected $_perpage = 5;

    public function __construct() {
        parent::__construct();
        $this->_base = $this->router->fetch_module() . '/' . $this->router->fetch_class();
        $this->data['form'] = [
            [
                'name' => 'user_name',
                'label' => 'Username',
                'type' => 'input',
                'rules' => 'required|max_length[50]|is_unique[users.user_name]'
            ],
            [
                'name' => 'user_firstname',
                'label' => 'First Name',
                'type' => 'input',
                'rules' => 'required|max_length[50]'
            ],
            [
                'name' => 'user_lastname',
                'label' => 'Last Name',
                'type' => 'input',
                'rules' => 'max_length[50]'
            ],
            [
                'name' => 'user_email',
                'label' => 'Email',
                'type' => 'email',
                'rules' => 'required|max_length[100]'
            ],
            [
                'name' => 'user_phone',
                'label' => 'Phone',
                'type' => 'input',
                'rules' => 'max_length[15]'
            ],
            [
                'name' => 'user_birthdate',
                'label' => 'Birth Date',
                'type' => 'date',
                'rules' => ''
            ],
            [
                'name' => 'user_status',
                'label' => 'Is Active?',
                'type' => 'checkbox',
                'rules' => NULL
            ],
            [
                'name' => 'role_id[]',
                'label' => 'Role(s)',
                'type' => 'multiselect',
                'items' => $this->role->multiselect('role_name'),
                'rules' => NULL
            ]
        ];

        $this->data['style'] = [];
        $this->data['script'] = ['jquery.inputmask','jquery.inputmask.date.extensions','jquery.inputmask.extensions'];
    }

    public function index() {
        $this->load->library(['pagination', 'table']);
        $page = !empty($this->uri->segment(4)) ? $this->_perpage * ($this->uri->segment(4) - 1) : 0;
        $config['base_url'] = base_url($this->_base . '/index/');
        $config['total_rows'] = $this->{$this->router->fetch_class()}->count_all();
        $this->_set_datagrid_header(isset($this->data['recursive']) ? $this->data['recursive'][1] : NULL);
        $unshift = [$this->_primary_key => 'Primary Key'] + $this->data['datagrid_header'] + ['role' => 'Role'];
        $items = $this->_get_items();
        
        $this->user->order_by($this->_primary_key, 'ASC');
        $this->user->limit($this->_perpage, $page);
        foreach ($this->user->with('user_role')->get_all() as $index => $row) {
            $row = object_to_array($row);
            foreach ($row as $k => $v) {
                if (!empty($items) && array_key_exists($k, $items)){
                    $row[$k] = empty($v) ? $v : $items[$k][$v];
                }
            }

            $row['role'] = '';
            foreach($row['user_role'] as $key => $value) {
                $role = $this->role->get($value['role_id']);
                $row['role'] .= '<span class="label label-info">' . $role->role_name . '</span> ';
            }

            $row = array_intersect_key($row, $unshift);
            $this->data['datagrid'][$index] = array_to_object($row);
        }

        $this->pagination->initialize($config);
        $this->data['links'] = $this->pagination->create_links();
    }

    private function _get_items() {
        $array = [];
        foreach ($this->data['form'] as $field) {
            if (!empty($field['items']))
                $array[$field['name']] = $field['items'];
        }

        return $array;
    }

    private function _set_datagrid_header() {
        $parent = func_get_args();
        foreach ($this->data['form'] as $head) {
            if ($head['name'] == reset($parent))
                continue;

            $this->data['datagrid_header'][$head['name']] = $head['label'];
        }
    }

    protected function insert() {
        if($this->validation($this->data['form'])===FALSE) {
            $this->view = 'layouts/AdminLTE/form';
            $this->data['action'] = $this->_base . '/insert/'; 
        } else {
            $data_user = [
                'user_name' => $this->input->post('user_name'),
                'user_firstname' => $this->input->post('user_firstname'),
                'user_lastname' => $this->input->post('user_lastname'),
                'user_email' => $this->input->post('user_email'),
                'user_phone' => $this->input->post('user_phone'),
                'user_birthdate' => $this->input->post('user_birthdate'),
                'user_status' => $this->input->post('user_status')
            ];

            $insert_id = $this->{$this->router->fetch_class()}->insert($data_user);

            if(count($this->input->post('role_id')) > 0) {
                $data_user_role = [];
                foreach($this->input->post('role_id') as $k => $v) {
                    $data_user_role[$k] = [
                        'user_id' => $insert_id,
                        'role_id' => $v
                    ];
                }

                $this->user_role->insert_many($data_user_role);
            }

            redirect($this->_base, 'refresh');
        }
    }

    public function update() {
        $this->view = 'sso/user/update';
        $this->data['action'] = $this->_base . '/edit/';
        $primary_key = $this->uri->segment(4);
        $this->data['record'] = $this->user->with('user_role')->get($primary_key);
        foreach($this->data['record']->user_role as $key => $value)
            $this->data['record']->{'role_id[]'}[] = $value->role_id;
        //debug($this->data['record']);
    }

    protected function edit() {
        $custom_rules = [
            [
                'name' => 'user_firstname',
                'label' => 'First Name',
                'type' => 'input',
                'rules' => 'required|max_length[50]'
            ],
            [
                'name' => 'user_lastname',
                'label' => 'Last Name',
                'type' => 'input',
                'rules' => 'max_length[50]'
            ],
            [
                'name' => 'user_email',
                'label' => 'Email',
                'type' => 'email',
                'rules' => 'required|max_length[100]'
            ],
            [
                'name' => 'user_phone',
                'label' => 'Phone',
                'type' => 'input',
                'rules' => 'max_length[15]'
            ],
            [
                'name' => 'user_birthdate',
                'label' => 'Birth Date',
                'type' => 'date',
                'rules' => ''
            ],
            [
                'name' => 'user_status',
                'label' => 'Is Active?',
                'type' => 'checkbox',
                'rules' => NULL
            ]
        ];
        $custom_base = $this->router->fetch_module() . '/' . $this->router->fetch_class();

        $actual = $this->user->get($this->input->post('user_id'));
        if($this->input->post('user_name')!==$actual->user_name) { 
            array_push($custom_rules, 
                [
                    'name' => 'user_name',
                    'label' => 'Username',
                    'type' => 'input',
                    'rules' => 'required|max_length[50]|is_unique[users.user_name]'
                ]
            );
        }

        $record = $this->user->get($this->input->post('user_id'));
        if (!empty($record)) {
            if($this->validation($custom_rules)===FALSE) {
                redirect($custom_base . '/update/' . $this->input->post('user_id'));
            } else {
                $data_user = [
                    'user_name' => $this->input->post('user_name'),
                    'user_firstname' => $this->input->post('user_firstname'),
                    'user_lastname' => $this->input->post('user_lastname'),
                    'user_email' => $this->input->post('user_email'),
                    'user_phone' => $this->input->post('user_phone'),
                    'user_birthdate' => $this->input->post('user_birthdate'),
                    'user_status' => $this->input->post('user_status')
                ];

                $this->user->update($record->{$this->user->primary_key}, $data_user, TRUE);

                $this->user_role->delete_by('user_id',$this->input->post('user_id'));

                if(count($this->input->post('role_id')) > 0) {
                    $data_user_role = [];
                    foreach($this->input->post('role_id') as $k => $v) {
                        $data_user_role[$k] = [
                            'user_id' => $this->input->post('user_id'),
                            'role_id' => $v
                        ];
                    }

                    $this->user_role->insert_many($data_user_role);
                }

                redirect($custom_base, 'refresh');
            }
        }
    }
   
    public function delete() {
        $primary_key = $this->uri->segment(4);
        $this->user->delete($primary_key);

        $this->user_role->delete_by('user_id',$primary_key);

        redirect($this->_base, 'refresh');
    }
}
