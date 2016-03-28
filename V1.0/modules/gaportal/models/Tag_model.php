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
    public $before_create = ['slug', 'create_log'];
    public $before_update = ['slug', 'create_log'];

    public function __construct() {
        parent::__construct();
    }
    
    protected function slug($tags) {
        $tags['tag_slug'] = url_title($tags['tag_content'], '_', TRUE);
        return $tags;
    }

}
