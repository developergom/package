<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Prvnc
 *
 * @author nanank
 */
class Province extends GN_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Prvnc');
    }

    public function index() {
        $data = $this->Prvnc->with('Cntry')->get_all();
    }

}
