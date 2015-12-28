<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Setting
 *
 * @author nanank
 */
class Setting {

    var $ci;
    public $sess = NULL;
    public $app_name = NULL;
    public $perpage = 0;
    public $cwp = 0;
    public $segment = 4;
    public $access_key = NULL;
    public $style = [];
    public $script = [];
    public $page = NULL;
    public $template = NULL;

    public function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->model('Cfg', 'cfg');
        $this->ci->load->model('Sso/Mn', 'mn');

        $this->initialize();
    }

    public function initialize() {
        $this->sess = $this->ci->session->userdata('user');
        $this->app_name = $this->ci->cfg->init('APPLICATION_NAME');
        $this->perpage = (int) $this->ci->cfg->init('ROW_PERPAGE');
        $this->cwp = (int) $this->ci->cfg->init('COUNT_WRONG_PASSWORD');
        $this->access_key = $this->ci->cfg->init('ACCESS_KEY');
        $this->page = $this->ci->mn->gtbylnk($this->uri_string());
        $this->template = $this->ci->cfg->init('TEMPLATE_NAME');
    }

    public function check_session() {
        if (empty($this->sess))
            redirect('in/');

        return;
    }

    public function can_create() {
        if (in_array('c', $this->ci->sso->access))
            return TRUE;
        
        return FALSE;
    }

    public function can_edit() {
        if (in_array('u', $this->ci->sso->access))
            return TRUE;
        
        return FALSE;
    }

    public function can_delete() {
        if (in_array('d', $this->ci->sso->access))
            return TRUE;
        
        return FALSE;
    }
    
    public function quick_edit() {
        if($this->can_edit())
            //return TRUE;
        
        return FALSE;
    }

    public function uri_string() {
        return $this->ci->router->module . '/' . $this->ci->router->fetch_class();
    }

}
