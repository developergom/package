<?php

class AppConfiguration extends GN_Controller{
	protected $models = ['AppConfiguration'];
    protected $helpers = ['extension','string'];

	public function __construct(){
		parent::__construct();
		$this->view = FALSE;
		$this->load->library('form_validation');
	}

	public function index(){
		$data = array();
		$data['app_configuration'] = $this->AppConfiguration->get_all();

		$this->load->view('app_configuration/index',$data);
	}

	public function form(){
		if($this->input->post())
		{
			$data = array('key'=>$this->input->post('key'),'value'=>$this->input->post('value'));

			if($this->AppConfiguration->validate($data)==TRUE){
				$this->AppConfiguration->insert($data);

				echo 'saved';
			}else{
				$data = array();
				$data['action'] = base_url().'AppConfiguration/form';
				$data['key'] = '';
				$this->load->view('app_configuration/form',$data);
			}
		}else{
			$data = array();
			$data['action'] = base_url().'AppConfiguration/form';
			$data['key'] = '';
			$this->load->view('app_configuration/form',$data);
		}
	}


	function sbt(){
		if($this->input->post())
		{
			
		}
	}
}