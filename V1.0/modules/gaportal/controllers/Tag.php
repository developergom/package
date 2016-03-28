<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Tag
 *
 * @author nanank
 */
class Tag extends GN_Controller {

    protected $models = ['tag'];

    public function __construct() {
        parent::__construct();

        $this->data['form'] = [
            
        ];
    }

}
