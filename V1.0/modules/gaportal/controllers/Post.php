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

    protected function upload() {
        if ($_FILES['file']['error'] != 4) {
            if (file_exists('asset/img/gaportal/blog/' . $_FILES['file']['name']))
                unlink('asset/img/gaportal/blog/' . $_FILES['file']['name']);

            $config['upload_path'] = 'asset/img/gaportal/blog/';
            $config['allowed_types'] = 'gif|jpg|png';
            //$config['max_size'] = $this->Setting->findByKey('image_max_size');
            $this->load->library('upload', $config);

            if ($this->upload->do_upload("file")) {
                $image = $this->upload->data();
                $url = 'asset/img/gaportal/blog/' . $image['orig_name'];
                $media = [
                    'media_type' => 'post',
                    'media_mime' => $image['file_type'],
                    'media_extension' => $image['file_ext'],
                    'media_filesize' => $image['file_size'],
                    'media_description' => $image['raw_name'],
                    'media_path' => $url
                ];

                $this->media->insert($media);
                die(json_encode([
                    'link' => $url,
                    'name' => $image["raw_name"]
                ]));
            } else {
                $errors = $this->upload->display_errors();
                die($errors);
            }
        }
        exit;
    }

    protected function browse() {

        $this->data['medias'] = $this->media->as_array()->get_all();
        $this->layout = FALSE;
        $this->view = 'gaportal/browse';
    }

}
