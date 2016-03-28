<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of MasterConfiguration_model
 *
 * @author nanank
 */
class AppConfiguration_model extends GN_Model {
    
    protected $_table = 'cfg';
    protected $primary_key = 'key';
    protected $validate = [
    						[
    							'field' => 'key',
    							'label' => 'Key',
    							'rules' => 'required'
    						],
    						[
    							'field' => 'value',
    							'label' => 'Value',
    							'rules' => 'required'
    						]
    					];


    public function __construct() {
        parent::__construct();
    }
    
    
}
