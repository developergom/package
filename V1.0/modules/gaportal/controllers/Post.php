<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Post
 *
 * @author nanank
 */
class Post extends GN_Controller {

    protected $models = ['post', 'category', 'post_to_category', 'tag', 'post_to_tag', 'media', 'media_to_post'];
    protected $helpers = ['text', 'number'];
    private $_banner_type;
    private $_validation;

    public function __construct() {
        parent::__construct();

        $this->_banner_type = json_decode_db(BANNER_TYPE);
        $this->load->library('upload');
        $this->data['style'] = ['summernote'];
        $this->data['script'] = ['summernote.min'];
        $this->data['categories'] = $this->category->multiselect('category_name');
        $this->data['tags'] = $this->tag->dropdown('tag_content');
        $this->_validation = [
            [
                'name' => 'post_title',
                'label' => 'Post Title',
                'rules' => 'required'
            ],
            [
                'name' => 'post_content',
                'label' => 'Content',
                'rules' => 'required'
            ],
            [
                'name' => 'post_featured_img',
                'label' => 'Banner',
                'rules' => 'callback_handle_upload'
            ],
            [
                'name' => 'categories[]',
                'label' => 'Categories',
                'rules' => 'required'
            ]
        ];
    }

    protected function index($page = 0) {
        $this->load->library('pagination');
        $page = !empty($page) ? $this->perpage * ($page - 1) : 0;
        $config['base_url'] = base_url($this->base . '/index/');
        $config['total_rows'] = $this->post->count_all();
        $this->pagination->initialize($config);
        $this->view = 'gaportal/post';
        $this->data['datagrid'] = $this->post->with('ptc')->with('ptt')->order_by('post_id', 'ASC')->limit($this->perpage, $page)->get_all();
        $this->data['links'] = $this->pagination->create_links();
    }

    public function create() {
        $this->view = 'gaportal/form_post';
        $this->data['action'] = $this->base . '/insert/';
    }

    protected function insert() {
        if ($this->validation($this->_validation) === FALSE) {
            $this->create();
        } else {
            $data = [
                'post_title' => $this->input->post('post_title'),
                'post_content' => $this->input->post('post_content'),
                'post_status' => $this->input->post('post_status'),
                'post_publish_when' => $this->input->post('post_status') == 'publish' ? date('Y-m-d H:i:s') : NULL
            ];

            $upload = $this->_upload_banner($data['post_title']);
            if (is_array($upload))
                $data['post_featured_img'] = json_encode_db($upload);

            $post_id = $this->post->insert($data);
            $this->_set_category($post_id, $this->input->post('categories'));
            if ($this->input->post('tags') !== FALSE)
                $this->_set_tag($post_id, $this->input->post('tags'));

            redirect($this->base, 'refresh');
        }
    }

    protected function update($post_id = 0) {
        $this->view = 'gaportal/form_post';
        $this->data['action'] = $this->base . '/edit/';
        $this->data['record'] = $this->post->with('ptc')->with('ptt')->get($post_id);
    }

    protected function edit() {
        $post_id = $this->input->post('post_id');

        if ($this->validation($this->_validation) === FALSE) {
            $this->update($post_id);
        } else {
            $post = $this->post->get($post_id);
            if (!empty($post)) {
                $data = [
                    'post_title' => $this->input->post('post_title'),
                    'post_content' => $this->input->post('post_content')
                ];

                if ($this->input->post('post_status') == 'publish') {
                    $data['post_status'] = 'publish';
                    $data['post_publish_when'] = date('Y-m-d H:i:s');
                } else if ($this->input->post('post_status') == 'draft') {
                    $data['post_status'] = 'draft';
                    $data['post_publish_when'] = NULL;
                }

                $upload = $this->_upload_banner($data['post_title']);
                if (is_array($upload))
                    $data['post_featured_img'] = json_encode_db($upload);

                $this->post->update($post->post_id, $data);
                $this->_set_category($post->post_id, $this->input->post('categories'));

                if ($this->input->post('tags') !== FALSE)
                    $this->_set_tag($post->post_id, $this->input->post('tags'));
            }

            redirect($this->base, 'refresh');
        }
    }

    protected function delete($post_id = 0) {
        $post = $this->post->get($post_id);
        if (!empty($post)) {
            foreach (json_decode_db($post->post_featured_img) as $banner) {
                if (file_exists($banner))
                    unlink($banner);
            }

            $this->post->delete($post->post_id);
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
            if (empty($tag))
                continue;

            $get_tag = $this->tag->get_by('tag_slug', url_title($tag, '_', TRUE));
            $post_to_tag[] = [
                'post_id' => $post_id,
                'tag_id' => empty($get_tag) ? $this->tag->insert(['tag_content' => $tag]) : $get_tag->tag_id
            ];
        }

        $this->post_to_tag->delete_by('post_id', $post_id);
        $this->post_to_tag->insert_many($post_to_tag);
    }

    private function _upload_banner($name) {
        $path = UPLOAD_PATH . $this->module;
        if (count($_FILES['post_featured_img']['name']) > 1) {
            for ($i = 1; $i <= count($_FILES['post_featured_img']['name']); ++$i)
                $filename[] = url_title($name) . '-' . $i;
        } else {
            $filename = [url_title($name)];
        }

        $config['upload_path'] = $path;
        $config['file_name'] = $filename;
        $config['allowed_types'] = IMAGE_ALLOWED;
        $config['max_size'] = MAX_UPLOAD_SIZE;
        $config['overwrite'] = TRUE;
        $this->upload->initialize($config);

        if ($this->upload->do_multi_upload('post_featured_img')) {
            foreach ($this->upload->get_multi_upload_data() as $banner)
                $return[] = $path . '/' . $banner['file_name'];

            return $return;
        }
    }

    public function handle_upload() {
        $config['upload_path'] = UPLOAD_PATH;
        $config['allowed_types'] = IMAGE_ALLOWED;
        $config['max_size'] = MAX_UPLOAD_SIZE;
        $config['min_width'] = 570;
        $config['min_height'] = 600;
        $this->upload->initialize($config);

        //if (isset($_FILES['post_featured_img'])) {
        if ($this->upload->do_multi_upload('post_featured_img')) {
            foreach ($this->upload->get_multi_upload_data() as $img)
                unlink($img['full_path']);

            return TRUE;
        } else {
            $this->form_validation->set_message('handle_upload', str_replace(['<p>', '</p>'], NULL, $this->upload->display_errors()));
            return FALSE;
        }
        //} else {
        //$this->form_validation->set_message('handle_upload', 'You must upload an image!');
        //return FALSE;
        //}
    }

}
