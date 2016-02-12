<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Post
 *
 * @author nanank
 */
class Post extends GN_Controller {

    protected $models = ['post', 'category', 'post_to_category', 'tag', 'post_to_tag', 'media', 'media_to_post'];
    protected $helpers = ['text'];

    public function __construct() {
        parent::__construct();

        $this->data['style'] = ['summernote'];
        $this->data['script'] = ['summernote.min', 'gaportal-post'];
        $this->data['categories'] = $this->category->dropdown('category_name');
        $this->data['tags'] = $this->tag->dropdown('tag_content');
    }

    protected function index() {
        $this->view = 'gaportal/post';
        $this->data['datagrid'] = $this->post->with('ptc')->with('ptt')->get_all();
    }

    protected function create() {
        $this->view = 'gaportal/form_post';
        $this->data['action'] = $this->base . '/insert/';
    }

    protected function insert() {
        $data = [
            'post_title' => $this->input->post('post_title'),
            'post_content' => $this->input->post('post_content'),
            'post_status' => $this->input->post('post_status'),
            'post_publish_when' => $this->input->post('post_status') == 'publish' ? date('Y-m-d H:i:s') : NULL
        ];

        $post_id = $this->post->insert($data);
        $this->_set_category($post_id, $this->input->post('categories'));
        if ($this->input->post('tags') !== FALSE)
            $this->_set_tag($post_id, $this->input->post('tags'));

        redirect($this->base, 'refresh');
    }

    protected function update() {
        $this->view = 'gaportal/form_post';
        $this->data['action'] = $this->base . '/edit/';
        $this->data['record'] = $this->post->with('ptc')->with('ptt')->get($this->uri->segment(4));
    }

    protected function edit() {
        $post_id = $this->input->post('post_id');
        $post = $this->post->get($post_id);
        if (!empty($this->post->get($post_id))) {
            $data = [
                'post_title' => $this->input->post('post_title'),
                'post_content' => $this->input->post('post_content'),
                'post_status' => $this->input->post('post_status'),
                'post_publish_when' => $this->input->post('post_status') == 'publish' ? date('Y-m-d H:i:s') : NULL
            ];

            $this->post->update($post->post_id, $data);
            $this->_set_category($post->post_id, $this->input->post('categories'));

            if ($this->input->post('tags') !== FALSE)
                $this->_set_tag($post->post_id, $this->input->post('tags'));
        }

        redirect($this->base, 'refresh');
    }

    private function _set_category($post_id, $categories) {
        $post_to_category = [];
        foreach ($categories as $category) {
            $post_to_category[] = [
                'post_id' => $post_id,
                'category_id' => $category
            ];
        }

        $this->post_to_category->delete_by('post_id', $post_id);
        $this->post_to_category->insert_many($post_to_category);
    }

    private function _set_tag($post_id, $tags) {
        $post_to_tag = [];
        foreach (explode(',', $tags) as $tag) {
            $get_tag = $this->tag->get_by('tag_slug', url_title($tag, '_', TRUE));
            $post_to_tag[] = [
                'post_id' => $post_id,
                'tag_id' => empty($get_tag) ? $this->tag->insert(['tag_content' => humanize($tag)]) : $get_tag->tag_id
            ];
        }

        $this->post_to_tag->delete_by('post_id', $post_id);
        $this->post_to_tag->insert_many($post_to_tag);
    }

}
