<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* This Application Must Be Used With BootStrap 3 *  */
$config['use_page_numbers'] = TRUE;
//$config['enable_query_strings'] = TRUE;
//$config['page_query_string'] = TRUE;
//$config['reuse_query_string'] = TRUE;
//$config['query_string_segment'] = 'page';

//$config['base_url'] = base_url($this->setting->uri_string());
//$config['per_page'] = $this->setting->perpage;
$config['per_page'] = ROW_PERPAGE;
//$config['uri_segment'] = $this->setting->segment;

$config['full_tag_open'] = '<nav><ul class="pagination pagination-sm">';
$config['full_tag_close'] = '</ul></nav>';
$config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';
$config['cur_tag_open'] = '<li class="active"><a href="#">';
$config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
$config['first_link'] = '<span class="fa fa-angle-double-left"></span>';
$config['prev_link'] = '<span class="fa fa-angle-left"></span>';
$config['last_link'] = '<span class="fa fa-angle-double-right"></span>';
$config['next_link'] = '<span class="fa fa-angle-right"></span>';
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