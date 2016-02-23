<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Post_to_category_model
 *
 * @author nanank
 */
class Post_to_category_model extends GN_Model {

    public $_db_group = 'GAPORTAL';
    public $_table = 'post_to_category';
    //public $primary_key = 'category_id';
    public $belongs_to = [
        'post' => [
            'model' => 'gaportal/post_model',
            'primary_key' => 'post_id'
        ]
    ];

    public function __construct() {
        parent::__construct();
    }

}
