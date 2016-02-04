<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Tag_model
 *
 * @author nanank
 */
class Tag_model extends GN_Model {

    public $_db_group = 'GAPORTAL';
    public $primary_key = 'tag_id';
    public $has_many = ['post'];

    public function __construct() {
        parent::__construct();
    }

}
