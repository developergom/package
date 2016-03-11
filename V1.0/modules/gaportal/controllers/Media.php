<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Media
 *
 * @author nanank
 */
class Media extends GN_Controller {

    protected $models = ['media'];
    protected $helpers = ['number', 'file', 'text'];
    private $_thumbnail;

    public function __construct() {
        parent::__construct();
        $this->load->library('upload');
        $this->data['title'] = 'Media Library';

        $media_property = json_decode_db(MEDIA_PROPERTY);
        $this->_thumbnail = $media_property['thumbnail'];
    }

    protected function index($page = 0) {
        $this->perpage = 12;
        $this->load->library('pagination');
        $config['per_page'] = $this->perpage;
        $config['base_url'] = base_url($this->base . '/index/');
        $config['total_rows'] = $this->media->count_all();
        $page = !empty($page) ? $this->perpage * ($page - 1) : 0;
        $this->pagination->initialize($config);

        $this->view = 'media';
        $this->data['style'] = ['gnUpload'];
        $this->data['script'] = ['gnUpload', 'media'];

        $this->data['datagrid'] = $this->media->order_by('create_when', 'DESC')->limit($this->perpage, $page)->get_all();
        $this->data['links'] = $this->pagination->create_links();
    }

    protected function edit() {
        $this->sso_new->check_access('u');
        $record = $this->media->get($this->input->post('media_id'));
        if (!empty($record)) {
            $update = $this->media->update($record->media_id, $this->input->post());
            exit($update);
        }

        exit();
    }

    protected function delete($primary_key = 0) {
        $this->sso_new->check_access('d');
        $record = $this->media->get($primary_key);
        if (!empty($record)) {
            unlink($record->media_url);
            if ($record->media_is_image) {
                $media_url = explode('/', $record->media_url);
                unlink($media_url[0] . '/' . $media_url[1] . '/thumbnails/' . $media_url[2]);
            }
            $delete = $this->media->delete($record->media_id);
            if ($delete)
                redirect('gaportal/media/?message=delete&status=success', 'refresh');
        }
    }

    protected function upload() {
        if ($this->upload->do_upload('upload_media')) {
            $media = $this->upload->data();
            $insert = [
                'media_filename' => $media['client_name'],
                'media_is_image' => $media['is_image'],
                'media_mime' => $media['file_type'],
                'media_dimension' => $media['image_size_str'],
                'media_extension' => $media['file_ext'],
                'media_filesize' => $media['file_size'],
                'media_url' => UPLOAD_PATH . $media['file_name'],
                'media_path' => $media['full_path'],
                'media_status' => 'active'
            ];

            if ($media['is_image'])
                $this->__crop($media);

            $this->media->insert($insert);
            exit('gaportal/media/');
        } else {
            echo str_replace(['<p>', '</p>'], NULL, $this->upload->display_errors());
        }
    }

    private function __crop(Array $img = []) {
        $config['image_library'] = 'gd2';
        $config['source_image'] = UPLOAD_PATH . $img['file_name'];
        $config['new_image'] = UPLOAD_PATH . 'thumbnails/' . $img['file_name'];
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = FALSE;
        $this->load->library('image_lib', $config + $this->__rectangle($img['image_width'], $img['image_height']));

        if ($this->image_lib->crop() === FALSE)
            echo $this->image_lib->display_errors();
    }

    private function __rectangle() {
        list($width, $height) = func_get_args();
        $return = [];
        if ($width > $this->_thumbnail['length'] && $height > $this->_thumbnail['length']) {
            $return['width'] = $this->_thumbnail['length'];
            $return['height'] = $this->_thumbnail['length'];
            $return['x_axis'] = ($width - $this->_thumbnail['length']) / 2;
            $return['y_axis'] = ($height - $this->_thumbnail['length']) / 2;
        } else {
            $return['width'] = $this->_thumbnail['length'] / $this->_thumbnail['ratio'];
            $return['height'] = $this->_thumbnail['length'] / $this->_thumbnail['ratio'];
            $return['x_axis'] = ($width - ($this->_thumbnail['length'] / $this->_thumbnail['ratio'])) / 2;
            $return['y_axis'] = ($height - ($this->_thumbnail['length'] / $this->_thumbnail['ratio'])) / 2;
        }

        return $return;
    }

    protected function detail() {
        $media_id = $this->input->post('media_id');
        $media = $this->media->get($media_id);
        echo json_encode($media);
        exit();
    }

//    protected function upload() {
//        if ($_FILES['file']['error'] != 4) {
//            if (file_exists('asset/img/gaportal/blog/' . $_FILES['file']['name']))
//                unlink('asset/img/gaportal/blog/' . $_FILES['file']['name']);
//
//            $config['upload_path'] = 'asset/img/gaportal/blog/';
//            $config['allowed_types'] = 'gif|jpg|png';
//            //$config['max_size'] = $this->Setting->findByKey('image_max_size');
//            $this->load->library('upload', $config);
//
//            if ($this->upload->do_upload("file")) {
//                $image = $this->upload->data();
//                $url = 'asset/img/gaportal/blog/' . $image['orig_name'];
//                $media = [
//                    'media_type' => 'post',
//                    'media_mime' => $image['file_type'],
//                    'media_extension' => $image['file_ext'],
//                    'media_filesize' => $image['file_size'],
//                    'media_description' => $image['raw_name'],
//                    'media_path' => $url
//                ];
//
//                $this->media->insert($media);
//                exit(json_encode([
//                    'path' => $url,
//                    'name' => $image["raw_name"]
//                ]));
//            } else {
//                $errors = $this->upload->display_errors();
//                exit($errors);
//            }
//        }
//        exit;
//    }

    protected function upload_from_url() {
        $media = [
            'media_type' => 'post',
//            'media_mime' => $image['file_type'],
//            'media_extension' => $image['file_ext'],
//            'media_filesize' => $image['file_size'],
//            'media_description' => $image['raw_name'],
            'media_path' => $this->input->post('file')
        ];
        $this->media->insert($media);
        exit(json_encode([
            'path' => $url,
            'name' => $image["raw_name"]
        ]));
    }

    protected function browse() {

        $this->data['medias'] = $this->media->as_array()->get_all();
        $this->layout = FALSE;
        $this->view = 'gaportal/browse';
    }

}
