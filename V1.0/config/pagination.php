<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* This Application Must Be Used With BootStrap 3 *  */
$config['use_page_numbers'] = TRUE;
$config['enable_query_strings'] = FALSE;
$config['page_query_string'] = FALSE;
$config['reuse_query_string'] = FALSE;
$config['query_string_segment'] = 'page';
$config['per_page'] = ROW_PERPAGE;
$config['uri_segment'] = 4;
$config['full_tag_open'] = '<nav><ul class="pagination pagination-sm">';
$config['full_tag_close'] = '</ul></nav>';
$config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';
$config['cur_tag_open'] = '<li class="active"><a href="#">';
$config['cur_tag_close'] = '<i class="sr-only">(current)</i></a></li>';
$config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
$config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
$config['next_link'] = '<i class="fa fa-angle-right"></i>';
$config['next_tag_open'] = '<li>';
$config['next_tagl_close'] = '</li>';
$config['prev_tag_open'] = '<li>';
$config['prev_tagl_close'] = '</li>';
$config['first_tag_open'] = '<li>';
$config['first_tagl_close'] = '</li>';
$config['last_tag_open'] = '<li>';
$config['last_tagl_close'] = '</li>';

/* End of file pagination.php */
/* Location: ./application/config/pagination.php */