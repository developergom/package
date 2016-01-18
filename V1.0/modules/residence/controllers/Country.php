<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Country
 *
 * @author nanank
 */
class Country extends GN_Controller {

    protected $models = ['Cntry'];
    protected $model_string = '%';
    protected $helpers = [];

    public function __construct() {
        parent::__construct();
    }

//    public function index() {
//        $this->data[] = $this->Cntry->get_all();
//    }
    
//    public function show() {
//        
//    }

}
