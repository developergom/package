<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$config['upload_path'] = UPLOAD_PATH;
$config['allowed_types'] = UPLOAD_TYPE;
$config['file_name'] = NULL;
$config['file_ext_tolower'] = TRUE;
$config['overwrite'] = TRUE;
$config['max_size'] = MAX_UPLOAD_SIZE;
$config['max_width'] = 0;
$config['max_height'] = 0;
$config['min_width'] = 480;
$config['min_height'] = 480;
$config['max_filename'] = 0;
$config['max_filename_increment'] = 0;
$config['encrypt_name'] = TRUE;
$config['remove_spaces'] = TRUE;
$config['detect_mime'] = TRUE;
$config['mod_mime_fx'] = TRUE;

/* End of file upload.php */
/* Location: ./application/config/upload.php */