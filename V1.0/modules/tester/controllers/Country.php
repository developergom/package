<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of test
 *
 * @author nanank
 */
class Country extends GN_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Cntry');
        //$this->load->model('Test1');
        $this->model = $this->Cntry;
        //$this->relations = $this->Test1->option('rid', 'rnme');
    }

}
