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
    public $protected_attributes = ['post_id'];
    public $before_create = ['slug', 'create_log'];
    public $before_update = ['slug', 'update_log'];
    public $before_delete = ['delete_attr'];
    public $has_many = [
        'ptc' => [
            'primary_key' => 'post_id',
            'model' => 'post_to_category_model'
        ],
        'ptt' => [
            'primary_key' => 'post_id',
            'model' => 'post_to_tag_model'
        ]
    ];

    public function __construct() {
        parent::__construct();
    }

    protected function slug($post) {
        $post['post_slug'] = url_title($post['post_title'], '_', TRUE);
        return $post;
    }
    
    protected function delete_attr($post_id) {
        $this->load->model('post_to_category_model');
        $this->load->model('post_to_tag_model');
        
        $this->post_to_category->delete_by('post_id', $post_id);
        $this->post_to_tag->delete_by('post_id', $post_id);
    }

}
