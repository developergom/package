<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Post
 *
 * @author nanank
 */
class Post extends GN_Controller {

    protected $models = ['post', 'media'];

    public function __construct() {
        parent::__construct();

        $this->data['style'] = ['bootstrap3-wysihtml5.min', 'editor'];
        $this->data['script'] = ['bootstrap3-wysihtml5.all.min', 'editor'];
        $this->data['form'] = [
            [
                'name' => 'post_title',
                'label' => 'Title',
                'type' => 'input',
                'items' => NULL,
                'rules' => 'required'
            ],
//            [
//                'name' => 'post_subtitle',
//                'label' => 'Subtitle',
//                'type' => 'input',
//                'items' => NULL,
//                'rules' => 'required'
//            ],
            [
                'name' => 'post_content',
                'label' => 'Content',
                'type' => 'wysiwyg',
                'items' => NULL,
                'rules' => 'required'
            ],
//            [
//                'name' => 'post_featured_img',
//                'label' => 'Featured Image',
//                'type' => 'upload',
//                'items' => NULL,
//                'rules' => 'required'
//            ],
//            [
//                'name' => 'post_format',
//                'label' => 'Format',
//                'type' => 'dropdown',
//                'items' => [],
//                'rules' => 'required'
//            ],
        ];
    }
    
    protected function index() {
        
    }

    

}
