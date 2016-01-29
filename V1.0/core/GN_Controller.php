<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of GN_Model
 *
 * @author nanank
 */
class GN_Controller extends CI_Controller {

    protected $view = NULL;
    protected $data = [];
    protected $layout;
    protected $asides = [];
    protected $models = [];
    protected $model_string = '%_model';
    protected $helpers = [];

    public function __construct() {
        parent::__construct();

        $this->_load_models();
        $this->_load_helpers();
        $this->data['title'] = $this->router->fetch_class();
        $this->data['base'] = $this->router->fetch_module() . '/' . $this->router->fetch_class();
        $this->data['breadcrumb'] = [
            '<i class="fa fa-home"></i> Home',
            humanize($this->router->fetch_module()),
            humanize($this->router->fetch_class())
        ];
    }

    public function _remap($method) {
        if (method_exists($this, $method)) {
            call_user_func_array([$this, $method], array_slice($this->uri->rsegments, 2));
        } else {
            if (method_exists($this, '_404')) {
                call_user_func_array([$this, '_404'], [$method]);
            } else {
                show_404(strtolower(get_class($this)) . '/' . $method);
            }
        }
        $this->_load_view();
    }

    protected function _load_view() {
        if ($this->view !== FALSE) {
            $view = (!empty($this->view)) ? $this->view : 'layouts/AdminLTE/base';
            $data['yield'] = $this->load->view($view, $this->data, TRUE);
            if (!empty($this->asides)) {
                foreach ($this->asides as $name => $file)
                    $data['yield_' . $name] = $this->load->view($file, $this->data, TRUE);
            }
            $data = array_merge($this->data, $data);
            $layout = FALSE;
            if (!isset($this->layout)) {
                if (file_exists(APPPATH . 'views/layouts/' . $this->router->class . '.php')) {
                    $layout = 'layouts/' . $this->router->class;
                } else {
                    $layout = 'layouts/AdminLTE/application';
                }
            } else if ($this->layout !== FALSE) {
                $layout = $this->layout;
            }

            if ($layout == FALSE) {
                $this->output->set_output($data['yield']);
            } else {
                $this->load->view($layout, $data);
            }
        }
    }

    private function _load_models() {
        foreach ($this->models as $model)
            $this->load->model($this->_model_name($model), $model);
    }

    protected function _model_name($model) {
        return str_replace('%', $model, $this->model_string);
    }

    private function _load_helpers() {
        foreach ($this->helpers as $helper)
            $this->load->helper($helper);
    }

    protected function index() {
        
    }

    protected function create() {
        $this->view = 'layouts/AdminLTE/form';
    }

    protected function update() {
        
    }

    protected function delete() {
        
    }

}
