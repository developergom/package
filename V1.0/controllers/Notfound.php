<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of notfound
 *
 * @author nanank
 */
class Notfound extends CI_Controller {
    
    private $_attr = [];
    
    public function __construct() {
        parent::__construct();
        $this->cfg->check_session();
    }
    
    public function index() {
        $this->_attr['title'] = 'Error 404';
        $this->_attr['content_header'] = '404 Error Page';
        $this->_attr['breadcrumb'] = [anchor('/', '<i class="fa fa-home"></i> Error 404')];
        $this->template->load('AdminLTE', 'notfound', $this->_attr);
    }
}

/* End of file notfound.php */
/* Location: ./application/controllers/notfound.php */