<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Media_model
 *
 * @author nanank
 */
class Media_model extends GN_Model {

    public $_db_group = 'GAPORTAL';
    public $primary_key = 'media_id';
    public $before_create = ['create_log'];
    public $before_update = ['update_log'];

    public function __construct() {
        parent::__construct();
    }

}
