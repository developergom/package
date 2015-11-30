<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of menus
 *
 * @author soniibrol
 */
class Test extends CI_Controller {

    public $sess = null;
    protected $app_name = null;
    protected $page = array();
    protected $perpage = null;
    protected $style = array();
    protected $script = array('list-icon-modal');
    protected $header = array();
    protected $footer = array();

    public function __construct() {
        parent::__construct();

        $this->load->model('ts');

        $this->sess = $this->session->userdata('user');
        if (empty($this->sess))
            redirect('in/');

        $this->page = $this->mn->gtbylnk($this->uri->segment(1) . '/' . $this->uri->segment(2));
        $this->app_name = $this->cfg->init('APPLICATION_NAME');
        $this->perpage = (int) $this->cfg->init('ROW_PERPAGE');

        $css = 'dataTables.bootstrap';
        array_push($this->style, $css);

        $this->header = array(
            'app_name' => $this->app_name,
            'title' => $this->page['mnme'],
            'content_header' => '<i class="fa ' . $this->page['mico'] . '"></i> ' . $this->page['mnme'],
            'style' => $this->style
        );


        $js = 'pages/test';
        array_push($this->script, 'jquery.dataTables');
        array_push($this->script, 'dataTables.bootstrap');
        array_push($this->script, 'serverSideDataTables');
        array_push($this->script, $js);

        $this->footer = array('script' => $this->script);
    }

    public function index() {
        $udata = data_recursive($this->mn->fmn(), 'mid', 'mpar');
        $recursive = datagrid_recursive($udata, 'mnme');
        /*$this->header['breadcrumb'] = array(anchor('/', '<i class="fa fa-home"></i> Home'), $this->page['mnme']);*/
        $this->header['breadcrumb'] = array(anchor('/', '<i class="fa fa-home"></i> Home'), '');
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $config['base_url'] = base_url('sso/menus/index/');
        $config['per_page'] = $this->perpage;
        $config['uri_segment'] = 4;
        $config['total_rows'] = count($recursive);
        $this->pagination->initialize($config);
        $data = array_slice($recursive, $page, $config['per_page']);
        $this->load->view('header', $this->header);
        $this->load->view('sso/test/indexlish', array('data' => $data, 'row' => count($recursive), 'links' => $this->pagination->create_links()));
        $this->load->view('footer', $this->footer);
    }

    function list_json(){
		//custom header table taken from field
		$order_field=array(
				'mnme',
				'mlnk',
				'ufnme',
				'mn.uu'
			);

		//don't edit me
		$order_key = (!$this->input->get('iSortCol_0'))?0:$this->input->get('iSortCol_0');
		$order = (!$this->input->get('iSortCol_0'))?'mnme':$order_field[$order_key];
		$sort = (!$this->input->get('sSortDir_0'))?'desc':$this->input->get('sSortDir_0');
		$search = (!$this->input->get('sSearch'))?'':$this->input->get('sSearch');

		$limit = (!$this->input->get('iDisplayLength'))?10:$this->input->get('iDisplayLength');
		$start = (!$this->input->get('iDisplayStart'))?0:$this->input->get('iDisplayStart');
		$data['no'] = $start+1;
		$data['sEcho'] = (!$this->input->get('callback'))?0:$this->input->get('callback');
		$data['iTotalRecords'] = $this->ts->count_all($search,$order_field);
		$data['test'] = $this->ts->get_paged_list($limit, $start, $order, $sort, $search, $order_field)->result();
		$data['callback'] = $this->input->get('callback');

		$this->load->view('test/list_json', $data);
	}
}

/* End of file test.php */
/* Location: ./application/modules/sso/controllers/test.php */