<?php

class Media extends CI_Controller{
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->load->model('asm/master/media_model');
		echo '<pre>';
		print_r($this->media_model->get());
		echo 'This is media';
	}
}