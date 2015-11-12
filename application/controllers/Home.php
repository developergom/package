<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of home
 *
 * @author nanank
 */
class Home extends CI_Controller {
    
    public $sess = null;
    protected $app_name = null;
    protected $perpage = null;
    protected $style = array();
    protected $script = array();
    protected $header = array();
    protected $footer = array();
    
    public function __construct() {
        parent::__construct();
        $this->sess = $this->session->userdata('user');
        if (empty($this->sess))
            redirect('in/');
        
        $this->app_name = $this->cfg->init('APPLICATION_NAME');
        $this->perpage = (int) $this->cfg->init('ROW_PERPAGE');
        $this->header = array(
            'app_name' => $this->app_name, 
            'title' => 'Home',
            'content_header' => '<i class="fa fa-home"></i> Home', 
            'style' => $this->style
        );
        $this->footer = array('script' => $this->script);
    }
    
    public function index() {
        $this->header['breadcrumb'] = array(anchor('/', '<i class="fa fa-home"></i> Home'));
        $this->load->view('header', $this->header);
        $this->load->view('home');
        $this->load->view('footer', $this->footer);
    }
    
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */