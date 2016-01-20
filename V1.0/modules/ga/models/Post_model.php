<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Post_model
 *
 * @author nanank
 */
class Post_model extends GN_Model {
    
    public $_db_group = 'GAPORTAL';
    public $primary_key = 'post_id';
    
    public function __construct() {
        parent::__construct();
    }
}
