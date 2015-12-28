<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Template {

    var $ci;

    public function __construct() {
        $this->ci =& get_instance();
    }

    public function load($template, $view = NULL, $data = NULL, $use_default = FALSE) {
        if (!is_null($view)) {
            if ($use_default)
                $view = 'templates/' . $view;
            
            $body = $this->ci->load->view($view, $data, TRUE);
            if (is_null($data)) {
                $data = ['body' => $body];
            } else if (is_array($data)) {
                $data['body'] = $body;
            } else if (is_object($data)) {
                $data->body = $body;
            }
        } else {
            show_error('Unable to find the requested file: ' . $view);
        }

        $data['app_name'] = $this->ci->setting->app_name;
        $data['title'] = (!empty($data['title'])) ? $data['title'] : $this->ci->setting->page['mnme'];
        $data['content_header'] = (!empty($data['content_header'])) ? $data['content_header'] : anchor($this->ci->setting->page['mlnk'], '<i class="fa ' . $this->ci->setting->page['mico'] . '"></i> ' . $this->ci->setting->page['mnme']);
        $data['style'] = $this->ci->setting->style;
        $data['script'] = $this->ci->setting->script;

        $this->ci->load->view('templates/' . $template, $data);
    }

}
