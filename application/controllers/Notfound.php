<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of notfound
 *
 * @author nanank
 */
class Notfound extends CI_Controller {
    
    public $sess = null;
    protected $app_name = null;
    protected $page = array();
    protected $perpage = null;
    protected $style = array();
    protected $script = array();
    protected $header = array();
    protected $footer = array();
    
    public function __construct() {
        parent::__construct();
        $this->output->set_status_header('404');
        $this->sess = $this->session->userdata('user');
        if (empty($this->sess))
            redirect('in/');
        
        $this->page = $this->mn->gtbylnk($this->uri->segment(1));
        $this->app_name = $this->cfg->init('APPLICATION_NAME');
        $this->perpage = (int) $this->cfg->init('ROW_PERPAGE');
        $this->header = array(
            'app_name' => $this->app_name, 
            'title' => 'Error 404',
            'content_header' => '404 Error Page', 
            'style' => $this->style
        );
        $this->footer = array('script' => $this->script);
    }
    
    public function index() {
        $this->header['breadcrumb'] = array(anchor('/', '<i class="fa fa-home"></i> Home'), 'Error 404');
        $this->load->view('header', $this->header);
        $this->load->view('notfound');
        $this->load->view('footer', $this->footer);
    }
}

/* End of file notfound.php */
/* Location: ./application/controllers/notfound.php */