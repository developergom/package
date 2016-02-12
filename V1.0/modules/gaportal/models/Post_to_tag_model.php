<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Post_to_tag_model
 *
 * @author nanank
 */
class Post_to_tag_model extends GN_Model {

    public $_db_group = 'GAPORTAL';
    public $_table = 'post_to_tag';

    public function __construct() {
        parent::__construct();
    }

}
