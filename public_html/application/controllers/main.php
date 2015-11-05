<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('comm_model','comm');
        $this->load->model('tagindex_model','tagindex');
        $this->load->model('sell_model','sell');
	}
	
	public function index(){
//        echo 1;die;
        $data = '';
//        $this->load->view('header', $data);
        $this->load->view('main');
//        $this->load->view('footer');

	}





}


