<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Category_model
 *
 * @author nanank
 */
class Category_model extends GN_Model {

    public $_db_group = 'GAPORTAL';
    public $primary_key = 'category_id';
    public $protected_attributes = ['category_id'];
    public $before_create = ['slug', 'create_log'];
    public $before_update = ['slug', 'update_log'];

    public function __construct() {
        parent::__construct();
    }

    protected function slug($category) {
        $category['category_slug'] = url_title($category['category_name'], '_', TRUE);
        return $category;
    }

}
