<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Category
 *
 * @author nanank
 */
class Category extends GN_Controller {

    protected $models = ['category'];
    protected $helpers = ['string'];

    public function __construct() {
        parent::__construct();
        $this->view = FALSE;
        $this->data['category'] = $this->category->get_all();
    }

    public function index() {
        $this->load->library('table');
        $header = ['category_parent' => 'Parent', 'category_name' => 'Name', 'category_slug' => 'Slug'];
        $this->table->set_heading($header);
        foreach (object_to_array($this->data['category']) as $row) {
            $data = array_intersect_key($row, $header);
            $this->table->add_row($data);
            //debug($data);
        }

        $table = $this->table->generate();

        $this->load->view('header');
        $this->load->view('portal/category', ['data' => $table]);
        $this->load->view('footer');
    }

}
