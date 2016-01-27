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

    public function __construct() {
        parent::__construct();
    }

}
