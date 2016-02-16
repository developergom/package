<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Media_to_post_model
 *
 * @author nanank
 */
class Media_to_post_model extends GN_Model {

    public $_db_group = 'GAPORTAL';
    public $_table = 'media_to_post';

    public function __construct() {
        parent::__construct();
    }

}
