<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Configs_model
 *
 * @author soniibrol
 */
class Home_model extends GN_Model {
    
    public $_db_group = 'SSO';
    public $_table = 'configs';
    public $primary_key = 'config_id';
    public $protected_attributes = ['config_id'];

    
    public function __construct() {
        parent::__construct();
    }
}
