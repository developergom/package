<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Comment_model
 *
 * @author nanank
 */
class Comment_model extends GN_Model {

    public $_db_group = 'GAPORTAL';
    public $primary_key = 'comment_id';
    public $before_create = ['create_log'];
    public $before_update = ['create_log'];

    public function __construct() {
        parent::__construct();
    }
    

}
