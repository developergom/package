<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of GN_Model
 *
 * @author nanank
 */
class GN_Controller extends CI_Controller {
    /* --------------------------------------------------------------
     * VARIABLES
     * ------------------------------------------------------------ */

    /**
     * The current request's view. Automatically guessed
     * from the name of the controller and action
     */
    protected $view = NULL;

    /**
     * An array of variables to be passed through to the
     * view, layout and any asides
     */
    protected $data = [];

    /**
     * The name of the layout to wrap around the view.
     */
    protected $layout;

    /**
     * An arbitrary list of asides/partials to be loaded into
     * the layout. The key is the declared name, the value the file
     */
    protected $asides = [];

    /**
     * A list of models to be autoloaded
     */
    protected $models = [];

    /**
     * A formatting string for the model autoloading feature.
     * The percent symbol (%) will be replaced with the model name.
     */
    protected $model_string = '%';

    /**
     * A list of helpers to be autoloaded
     */
    protected $helpers = [];

    /* --------------------------------------------------------------
     * GENERIC METHODS
     * ------------------------------------------------------------ */

    /**
     * Initialise the controller, tie into the CodeIgniter superobject
     * and try to autoload the models and helpers
     */
    public function __construct() {
        parent::__construct();
        $this->_load_models();
        $this->_load_helpers();
        $this->data['title'] = anchor($this->setting->page['mlnk'], '<i class="fa ' . $this->setting->page['mico'] . '"></i> ' . $this->setting->page['mnme']);
        
    }

    /* --------------------------------------------------------------
     * VIEW RENDERING
     * ------------------------------------------------------------ */

    /**
     * Override CodeIgniter's despatch mechanism and route the request
     * through to the appropriate action. Support custom 404 methods and
     * autoload the view into the layout.
     */
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

    /**
     * Automatically load the view, allowing the developer to override if
     * he or she wishes, otherwise being conventional.
     */
    protected function _load_view() {
// If $this->view == FALSE, we don't want to load anything
        if ($this->view !== FALSE) {
// If $this->view isn't empty, load it. If it isn't, try and guess based on the controller and action name
            $view = (!empty($this->view)) ? $this->view : 'layouts/' . $this->setting->template . '/base';
// Load the view into $yield
            $data['yield'] = $this->load->view($view, $this->data, TRUE);

            if (!empty($this->asides)) { // Do we have any asides? Load them.
                foreach ($this->asides as $name => $file)
                    $data['yield_' . $name] = $this->load->view($file, $this->data, TRUE);
            }
// Load in our existing data with the asides and view
            $data = array_merge($this->data, $data);
            $layout = FALSE;
            if (!isset($this->layout)) { // If we didn't specify the layout, try to guess it
                if (file_exists(APPPATH . 'views/layouts/' . $this->router->class . '.php')) {
                    $layout = 'layouts/' . $this->router->class;
                } else {
                    $layout = 'layouts/' . $this->setting->template . '/application';
                }
            } else if ($this->layout !== FALSE) { // If we did, use it
                $layout = $this->layout;
            }

            if ($layout == FALSE) { // If $layout is FALSE, we're not interested in loading a layout, so output the view directly
                $this->output->set_output($data['yield']);
            } else { // Otherwise? Load away :)
                $this->load->view($layout, $data);
            }
        }
    }

    /* --------------------------------------------------------------
     * MODEL LOADING
     * ------------------------------------------------------------ */

    /**
     * Load models based on the $this->models array
     */
    private function _load_models() {
        foreach ($this->models as $model)
            $this->load->model($this->_model_name($model), $model);
    }

    /**
     * Returns the loadable model name based on
     * the model formatting string
     */
    protected function _model_name($model) {
        return str_replace('%', $model, $this->model_string);
    }

    /* --------------------------------------------------------------
     * HELPER LOADING
     * ------------------------------------------------------------ */

    /**
     * Load helpers based on the $this->helpers array
     */
    private function _load_helpers() {
        foreach ($this->helpers as $helper)
            $this->load->helper($helper);
    }
    
    public function index() {
        $this->data['breadcrumb'] = [anchor('/', '<i class="fa fa-home"></i> Home'), $this->setting->page['mnme']];
    }
    
    public function form() {
        $this->data['breadcrumb'] = [anchor('/', '<i class="fa fa-home"></i> Home'), $this->setting->page['mnme'], 'Form'];
        $this->data['action'] = $this->setting->uri_string();
        $this->data['key'] = [];
        $this->view = 'layouts/' . $this->setting->template . '/form';
    }

}
