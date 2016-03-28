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
    public $primary_key = 'tag_id';
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
