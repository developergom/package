<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Media
 *
 * @author nanank
 */
class Media extends GN_Controller {

    protected $models = ['media'];

    public function __construct() {
        parent::__construct();
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
