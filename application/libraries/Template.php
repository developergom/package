<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Template {

    private $_core = NULL;

    public function __construct() {
        $this->_core =& get_instance();
    }

    public function load($template, $view = NULL, $data = NULL) {
        if (!is_null($view)) {
            $body = $this->_core->load->view($view, $data, TRUE);
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

        
        $data['app_name'] = $this->_core->cfg->app_name;
        $data['title' ] = $this->_core->cfg->page['mnme'];
        $data['content_header'] = anchor($this->_core->cfg->page['mlnk'], '<i class="fa ' . $this->_core->cfg->page['mico'] . '"></i> ' . $this->_core->cfg->page['mnme']);
        $data['style'] = $this->_core->cfg->style;
        $data['script'] = $this->_core->cfg->script;
        
        $this->_core->load->view('templates/' . $template, $data);
    }

}
