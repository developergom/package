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
    public $before_create = ['slug', 'create_log'];
    public $before_update = ['slug', 'update_log'];
    public $has_many = ['category'];
    public $belongs_to = ['tag'];

    public function __construct() {
        parent::__construct();
    }

    protected function slug($post) {
        $post['post_slug'] = url_title($post['post_title']);
        return $post;
    }

}
