<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of home
 *
 * @author nanank
 */
class Home extends CI_Controller {
    
    private $_attr = [];
    
    public function __construct() {
        parent::__construct();
        $this->load->library('template');
        $this->setting->check_session();
    }
    
    public function index() {
        $this->_attr['title'] = 'Home';
        $this->_attr['breadcrumb'] = [anchor('/', '<i class="fa fa-home"></i> Home')];
        $this->template->load($this->setting->template . '/default', 'home', $this->_attr);
    }
    
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */