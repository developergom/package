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
    private $_banner_type = [
        'thumb' => [
            'width' => 850,
            'height' => 480,
            'ratio' => 6
        ],
        'slider' => [
            'width' => 1600,
            'height' => 600,
            'ratio' => 6
        ],
        'video'
    ];
    private $_validation;

    public function __construct() {
        parent::__construct();
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
                'name' => 'categories[]',
                'label' => 'Categories',
                'rules' => 'required'
            ]
        ];
        
    }

    protected function index() {
        $this->load->library('pagination');
        $page = !empty($this->uri->segment(4)) ? $this->perpage * ($this->uri->segment(4) - 1) : 0;
        $config['base_url'] = base_url($this->base . '/index/');
        $config['per_page'] = $this->perpage;
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

            $upload = $this->_upload_banner(url_title($this->input->post('post_title')), $this->input->post('crop'));
            if (is_array($upload))
                $data['post_featured_img'] = json_encode_db($upload);


            $post_id = $this->post->insert($data);
            $this->_set_category($post_id, $this->input->post('categories'));
            if ($this->input->post('tags') !== FALSE)
                $this->_set_tag($post_id, $this->input->post('tags'));

            redirect($this->base, 'refresh');
        }
    }

    protected function update() {
        $this->view = 'gaportal/form_post';
        $this->data['action'] = $this->base . '/edit/';
        $this->data['record'] = $this->post->with('ptc')->with('ptt')->get($this->uri->segment(4));
    }

    protected function edit() {
        if ($this->validation($this->_validation) === FALSE) {
            $this->update();
        } else {
            $post_id = $this->input->post('post_id');
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

                $upload = $this->_upload_banner($this->input->post('post_title'), $this->input->post('crop'));
                if (is_array($upload))
                    $data['post_featured_img'] = json_encode_db($upload);

                $this->validation($this->_validation);
                $this->post->update($post->post_id, $data);
                $this->_set_category($post->post_id, $this->input->post('categories'));

                if ($this->input->post('tags') !== FALSE)
                    $this->_set_tag($post->post_id, $this->input->post('tags'));
            }

            redirect($this->base, 'refresh');
        }
    }

    protected function delete() {
        $post_id = $this->uri->segment(4);
        $post = $this->post->get($post_id);
        if (!empty($post_id) && !empty($post_id)) {
            foreach (json_decode_db($post->post_featured_img) as $banner) {
                if (file_exists('./assets/images/gaportal/post/thumb/' . $banner))
                    unlink('./assets/images/gaportal/post/thumb/' . $banner);

                if (file_exists('./assets/images/gaportal/post/slider/' . $banner))
                    unlink('./assets/images/gaportal/post/slider/' . $banner);
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

    private function _upload_banner($title, $crop = TRUE) {
        if (count($_FILES['post_featured_img']['name']) > 1) {
            for ($i = 0; $i < count($_FILES['post_featured_img']['name']); $i++)
                $name[] = url_title($title) . '-' . $i;
        } else {
            $name = [url_title($title)];
        }

        $config['file_name'] = $name;
        $config['upload_path'] = './assets/images/gaportal/post/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 5000;
        $config['max_width'] = 96000;
        $config['max_height'] = 17680;
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);
        if ($this->upload->do_multi_upload('post_featured_img') === FALSE) {
            return $this->upload->display_errors();
        } else {
            foreach ($this->upload->get_multi_upload_data() as $banner) {
                $filename[] = $banner['file_name'];
                if ($crop) {
                    $this->_create_banner($banner, 'slider');
                    $this->_create_banner($banner, 'thumb');
                }
                unlink($banner['full_path']);
            }
        }

        return $filename;
    }

    private function _create_banner($img, $type = NULL) {
        $this->load->library('image_lib');
        $this->image_lib->initialize([
            'image_library' => 'GD2',
            'quality' => 100,
            'source_image' => $img['full_path'],
            'new_image' => $img['file_path'] . '/' . $type . '/' . $img['file_name'],
            //'master_dim' => 'auto',
            'maintain_ratio' => FALSE,
            'create_thumb' => FALSE,
            'width' => (int) $this->_banner_type[$type]['width'],
            'height' => (int) $this->_banner_type[$type]['height'],
            'x_axis' => $this->_banner_type[$type]['width'] / $this->_banner_type[$type]['ratio'],
            'y_axis' => $this->_banner_type[$type]['height'] / $this->_banner_type[$type]['ratio']
        ]);

        if ($this->image_lib->crop() === FALSE)
            return $this->image_lib->display_errors();
    }

}
