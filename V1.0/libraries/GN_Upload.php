<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Post
 *
 * @author nanank
 */
class GN_Upload extends CI_Upload {

    protected $_multi_upload_data = [];
    protected $_multi_file_name_override = NULL;
    
    public function __construct($config = array()) {
        parent::__construct($config);
    }

    public function initialize(Array $config = [], $reset = TRUE) {
        $defaults = [
            'max_size' => 0,
            'max_width' => 0,
            'max_height' => 0,
            'max_filename' => 0,
            'allowed_types' => NULL,
            'file_temp' => NULL,
            'file_name' => NULL,
            'orig_name' => NULL,
            'file_type' => NULL,
            'file_size' => NULL,
            'file_ext' => NULL,
            'upload_path' => NULL,
            'overwrite' => FALSE,
            'encrypt_name' => FALSE,
            'is_image' => FALSE,
            'image_width' => NULL,
            'image_height' => NULL,
            'image_type' => NULL,
            'image_size_str' => NULL,
            'error_msg' => [],
            'mimes' => [],
            'remove_spaces' => TRUE,
            'xss_clean' => FALSE,
            'temp_prefix' => 'temp_file_',
            'client_name' => NULL
        ];

        foreach ($defaults as $key => $val) {
            if (isset($config[$key])) {
                $method = "set_{$key}";
                if (method_exists($this, $method)) {
                    $this->$method($config[$key]);
                } else {
                    $this->$key = $config[$key];
                }
            } else {
                $this->$key = $val;
            }
        }

        if (!empty($this->file_name)) {
            if (is_array($this->file_name)) {
                $this->_file_name_override = NULL;
                $this->_multi_file_name_override = $this->file_name;
            } else {
                $this->_file_name_override = $this->file_name;
                $this->_multi_file_name_override = NULL;
            }
        }
    }

    protected function _file_mime_type($file, $count = 0) {
        $tmp_name = is_array($file['name']) ? $file['tmp_name'][$count] : $file['tmp_name'];
        $type = is_array($file['name']) ? $file['type'][$count] : $file['type'][$count];
        $regexp = "/^([a-z\-]+\/[a-z0-9\-\.\+]+)(;\s.+)?$/";
        if (function_exists('finfo_file')) {
            $finfo = finfo_open(FILEINFO_MIME);
            if (is_resource($finfo)) {
                $mime = @finfo_file($finfo, $tmp_name);
                finfo_close($finfo);
                if (is_string($mime) && preg_match($regexp, $mime, $matches)) {
                    $this->file_type = $matches[1];
                    return;
                }
            }
        }

        if (DIRECTORY_SEPARATOR !== '\\') {
            $cmd = 'file --brief --mime ' . escapeshellarg($tmp_name) . ' 2>&1';
            if (function_exists('exec')) {
                $mime = @exec($cmd, $mime, $return_status);
                if ($return_status === 0 && is_string($mime) && preg_match($regexp, $mime, $matches)) {
                    $this->file_type = $matches[1];
                    return;
                }
            }

            if ((bool) @ini_get('safe_mode') === FALSE && function_exists('shell_exec')) {
                $mime = @shell_exec($cmd);
                if (strlen($mime) > 0) {
                    $mime = explode('\n', trim($mime));
                    if (preg_match($regexp, $mime[(count($mime) - 1)], $matches)) {
                        $this->file_type = $matches[1];
                        return;
                    }
                }
            }

            if (function_exists('popen')) {
                $proc = @popen($cmd, 'r');
                if (is_resource($proc)) {
                    $mime = @fread($proc, 512);
                    @pclose($proc);
                    if ($mime !== FALSE) {
                        $mime = explode('\n', trim($mime));
                        if (preg_match($regexp, $mime[(count($mime) - 1)], $matches)) {
                            $this->file_type = $matches[1];
                            return;
                        }
                    }
                }
            }
        }

        if (function_exists('mime_content_type')) {
            $this->file_type = @mime_content_type($tmp_name);
            if (strlen($this->file_type) > 0)
                return;
        }
        $this->file_type = $type;
    }

    protected function set_multi_upload_data() {
        $this->_multi_upload_data[] = [
            'file_name' => $this->file_name,
            'file_type' => $this->file_type,
            'file_path' => $this->upload_path,
            'full_path' => $this->upload_path . $this->file_name,
            'raw_name' => str_replace($this->file_ext, NULL, $this->file_name),
            'orig_name' => $this->orig_name,
            'client_name' => $this->client_name,
            'file_ext' => $this->file_ext,
            'file_size' => $this->file_size,
            'is_image' => $this->is_image(),
            'image_width' => $this->image_width,
            'image_height' => $this->image_height,
            'image_type' => $this->image_type,
            'image_size_str' => $this->image_size_str
        ];
    }

    public function get_multi_upload_data() {
        return $this->_multi_upload_data;
    }

    public function do_multi_upload($field) {
        $this->_multi_upload_data = [];
        if (!isset($_FILES[$field]))
            return FALSE;

        if (!is_array($_FILES[$field]['name']))
            return $this->do_upload($field);

        if (!$this->validate_upload_path())
            return FALSE;

        foreach ($_FILES[$field]['name'] as $i => $v) {
            if (!is_uploaded_file($_FILES[$field]['tmp_name'][$i])) {
                $error = (!isset($_FILES[$field]['error'][$i])) ? 4 : $_FILES[$field]['error'][$i];
                switch ($error) {
                    case 1:
                        $this->set_error('upload_file_exceeds_limit');
                        break;
                    case 2:
                        $this->set_error('upload_file_exceeds_form_limit');
                        break;
                    case 3:
                        $this->set_error('upload_file_partial');
                        break;
                    case 4:
                        $this->set_error('upload_no_file_selected');
                        break;
                    case 6:
                        $this->set_error('upload_no_temp_directory');
                        break;
                    case 7:
                        $this->set_error('upload_unable_to_write_file');
                        break;
                    case 8:
                        $this->set_error('upload_stopped_by_extension');
                        break;
                    default:
                        $this->set_error('upload_no_file_selected');
                        break;
                }
                return FALSE;
            }

            $this->file_temp = $_FILES[$field]['tmp_name'][$i];
            $this->file_size = $_FILES[$field]['size'][$i];
            $this->_file_mime_type($_FILES[$field], $i);
            $this->file_type = preg_replace('/^(.+?);.*$/', '\\1', $this->file_type);
            $this->file_type = strtolower(trim(stripslashes($this->file_type), '"'));
            $this->file_name = $this->_prep_filename($_FILES[$field]['name'][$i]);
            $this->file_ext = $this->get_extension($this->file_name);
            $this->client_name = $this->file_name;

            if (!$this->is_allowed_filetype()) {
                $this->set_error('upload_invalid_filetype');
                return FALSE;
            }

            if (!empty($this->_multi_file_name_override[$i])) {
                $this->file_name = $this->_prep_filename($this->_multi_file_name_override[$i]);
                if (strpos($this->_multi_file_name_override[$i], '.') === FALSE) {
                    $this->file_name .= $this->file_ext;
                } else {
                    $this->file_ext = $this->get_extension($this->_multi_file_name_override[$i]);
                }

                if (!$this->is_allowed_filetype(TRUE)) {
                    $this->set_error('upload_invalid_filetype');
                    return FALSE;
                }
            }

            if ($this->file_size > 0)
                $this->file_size = round($this->file_size / 1024, 2);

            if (!$this->is_allowed_filesize()) {
                $this->set_error('upload_invalid_filesize');
                return FALSE;
            }

            if (!$this->is_allowed_dimensions()) {
                $this->set_error('upload_invalid_dimensions');
                return FALSE;
            }

            $this->file_name = $this->clean_file_name($this->file_name);
            if ($this->max_filename > 0)
                $this->file_name = $this->limit_filename_length($this->file_name, $this->max_filename);

            if ($this->remove_spaces == TRUE)
                $this->file_name = preg_replace('/\s+/', '_', $this->file_name);

            $this->orig_name = $this->file_name;
            if ($this->overwrite == FALSE) {
                $this->file_name = $this->set_filename($this->upload_path, $this->file_name);
                if ($this->file_name === FALSE)
                    return FALSE;
            }

            if ($this->xss_clean) {
                if ($this->do_xss_clean() === FALSE) {
                    $this->set_error('upload_unable_to_write_file');
                    return FALSE;
                }
            }

            if (!@copy($this->file_temp, $this->upload_path . $this->file_name)) {
                if (!@move_uploaded_file($this->file_temp, $this->upload_path . $this->file_name)) {
                    $this->set_error('upload_destination_error');
                    return FALSE;
                }
            }

            $this->set_image_properties($this->upload_path . $this->file_name);
            $this->set_multi_upload_data();
        }
        return TRUE;
    }

    protected function clean_file_name($filename) {
        return get_instance()->security->sanitize_filename($filename);
    }
}